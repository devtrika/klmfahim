<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CostRequest;
use App\Models\Invoice;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = Invoice::query()
            ->when(in_array($request->status, Invoice::STATUSES), fn ($q) => $q->where('status', $request->status))
            ->latest('issue_date')->latest('id')->get();

        return view('admin.invoices.index', [
            'invoices' => $invoices,
            'totals' => Invoice::selectRaw('status, count(*) as n, sum(total) as amount')->groupBy('status')->get()->keyBy('status'),
        ]);
    }

    public function create(Request $request)
    {
        $site = Site::current();
        $invoice = new Invoice([
            'number' => Invoice::nextNumber(),
            'status' => 'unpaid',
            'issue_date' => now(),
            'due_date' => now()->addDays(7),
            'vat_rate' => $site->vat_rate ?? 5,
            'discount' => 0,
        ]);
        $items = [['description' => '', 'quantity' => 1, 'unit_price' => 0]];

        // Pre-fill from a calculator quote request.
        if ($quote = CostRequest::where('uuid', (string) $request->query('request'))->first()) {
            $invoice->fill([
                'client_name' => $quote->name,
                'client_phone' => $quote->phone,
                'client_email' => $quote->email,
                'cost_request_id' => $quote->id,
            ]);
            $items = collect($quote->selections)->filter(fn ($l) => $l['price'] > 0)
                ->map(fn ($l) => ['description' => trans('front.lbl_'.$l['group']).' — '.$l['title'], 'quantity' => 1, 'unit_price' => $l['price']])
                ->values()->all() ?: $items;
        }

        return view('admin.invoices.form', ['invoice' => $invoice, 'items' => $items]);
    }

    public function store(Request $request)
    {
        $invoice = new Invoice(['created_by' => Auth::id()]);
        $this->save($invoice, $request);

        return redirect('trika/invoices/'.$invoice->id)->with('message', trans('layout.add_suc'));
    }

    public function show(Invoice $invoice)
    {
        return view('admin.invoices.show', ['invoice' => $invoice->load('items'), 'site' => Site::current()]);
    }

    public function edit(Invoice $invoice)
    {
        return view('admin.invoices.form', [
            'invoice' => $invoice,
            'items' => $invoice->items->map->only('description', 'quantity', 'unit_price')->all(),
        ]);
    }

    public function update(Request $request, Invoice $invoice)
    {
        $this->save($invoice, $request);

        return redirect('trika/invoices/'.$invoice->id)->with('message', trans('layout.edit_suc'));
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect('trika/invoices')->with('message', trans('layout.delete_suc'));
    }

    private function save(Invoice $invoice, Request $request): void
    {
        $data = $request->validate([
            'number' => ['required', 'string', 'max:30', Rule::unique('invoices', 'number')->ignore($invoice->id)],
            'status' => ['required', Rule::in(Invoice::STATUSES)],
            'client_name' => 'required|string|max:255',
            'client_phone' => 'nullable|string|max:40',
            'client_email' => 'nullable|email|max:255',
            'client_address' => 'nullable|string|max:255',
            'client_trn' => 'nullable|string|max:30',
            'issue_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:issue_date',
            'discount' => 'nullable|numeric|min:0',
            'vat_rate' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string|max:5000',
            'cost_request_id' => 'nullable|exists:cost_requests,id',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string|max:255',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        // Totals are always worked out here, never trusted from the form.
        $items = collect($data['items'])->values()->map(fn ($item, $i) => [
            'description' => $item['description'],
            'quantity' => round((float) $item['quantity'], 2),
            'unit_price' => round((float) $item['unit_price'], 2),
            'total' => round($item['quantity'] * $item['unit_price'], 2),
            'sort' => $i,
        ]);
        $subtotal = round($items->sum('total'), 2);
        $discount = min(round((float) ($data['discount'] ?? 0), 2), $subtotal);
        $vat = round(($subtotal - $discount) * $data['vat_rate'] / 100, 2);

        unset($data['items']);
        $invoice->fill($data + [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'vat_amount' => $vat,
            'total' => $subtotal - $discount + $vat,
        ]);

        DB::transaction(function () use ($invoice, $items) {
            $invoice->save();
            $invoice->items()->delete();
            $invoice->items()->createMany($items->all());
        });
    }
}
