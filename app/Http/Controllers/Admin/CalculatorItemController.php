<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CalculatorItem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CalculatorItemController extends Controller
{
    public function index()
    {
        return view('admin.calculator.index', [
            'groups' => CalculatorItem::orderBy('sort')->get()->groupBy('group'),
        ]);
    }

    public function create(Request $request)
    {
        return view('admin.calculator.form', ['item' => new CalculatorItem(['group' => $request->query('group', 'extra')])]);
    }

    public function store(Request $request)
    {
        CalculatorItem::create($this->validated($request));

        return redirect('trika/calculator')->with('message', trans('layout.add_suc'));
    }

    public function edit(CalculatorItem $calculator)
    {
        return view('admin.calculator.form', ['item' => $calculator]);
    }

    public function update(Request $request, CalculatorItem $calculator)
    {
        $calculator->update($this->validated($request));

        return redirect('trika/calculator')->with('message', trans('layout.edit_suc'));
    }

    public function destroy(CalculatorItem $calculator)
    {
        $calculator->delete();

        return back()->with('message', trans('layout.delete_suc'));
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'group' => ['required', Rule::in(CalculatorItem::GROUPS)],
            'ar_title' => 'required|string|max:255',
            'en_title' => 'required|string|max:255',
            'ar_hint' => 'nullable|string|max:255',
            'en_hint' => 'nullable|string|max:255',
            'price' => 'required|integer|min:0',
            'sort' => 'nullable|integer|min:0',
        ]);
        $data['sort'] ??= 0;

        return $data;
    }
}
