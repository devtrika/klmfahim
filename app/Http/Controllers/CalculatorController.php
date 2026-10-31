<?php

namespace App\Http\Controllers;

use App\Models\CalculatorItem;
use App\Models\CostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CalculatorController extends Controller
{
    public function show(Request $request)
    {
        return view('front.calculator', [
            'items' => $this->items(),
            'preset' => $request->only('jurisdiction', 'visas'),
        ]);
    }

    public function store(Request $request)
    {
        $items = $this->items();
        $ids = fn (string $group) => $items->get($group, collect())->pluck('uuid')->all();

        $data = $request->validate([
            'jurisdiction' => ['required', Rule::in($ids('jurisdiction'))],
            'activity' => ['required', Rule::in($ids('activity'))],
            'office' => ['required', Rule::in($ids('office'))],
            'visas' => 'required|integer|min:0|max:50',
            'shareholders' => 'required|integer|min:1|max:50',
            'extras' => 'array',
            'extras.*' => [Rule::in($ids('extra'))],
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:40',
            'email' => 'nullable|email|max:150',
        ]);

        $lang = LaravelLocalization::getCurrentLocale();
        $title = fn ($item) => $item->{$lang.'_title'};
        $pick = fn (string $group, $id) => $items[$group]->firstWhere('uuid', $id);

        $lines = collect();
        foreach (['jurisdiction', 'activity', 'office'] as $group) {
            $item = $pick($group, $data[$group]);
            $lines->push(['group' => $group, 'title' => $title($item), 'price' => $item->price]);
        }

        $visa = $items->get('visa', collect())->first();
        $shareholder = $items->get('shareholder', collect())->first();
        $lines->push(['group' => 'visas', 'title' => $data['visas'].' × '.($visa ? $title($visa) : ''), 'price' => $data['visas'] * ($visa->price ?? 0)]);
        $lines->push(['group' => 'shareholders', 'title' => (string) $data['shareholders'], 'price' => max(0, $data['shareholders'] - 1) * ($shareholder->price ?? 0)]);

        foreach ($data['extras'] ?? [] as $id) {
            $item = $pick('extra', $id);
            $lines->push(['group' => 'extra', 'title' => $title($item), 'price' => $item->price]);
        }

        $estimate = (int) $lines->sum('price');

        CostRequest::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'] ?? null,
            'selections' => $lines->map(fn ($l) => ['group' => $l['group'], 'title' => $l['title'], 'price' => $l['price']])->all(),
            'estimate' => $estimate,
        ]);

        return redirect(LaravelLocalization::localizeUrl('calculator'))
            ->with('quote', ['lines' => $lines->all(), 'estimate' => $estimate, 'name' => $data['name']]);
    }

    /** @return Collection<string, Collection<int, CalculatorItem>> */
    private function items(): Collection
    {
        return CalculatorItem::orderBy('sort')->get()->groupBy('group');
    }
}
