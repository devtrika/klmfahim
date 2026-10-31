<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function index()
    {
        return view('admin.features.index', ['features' => Feature::orderBy('sort')->get()]);
    }

    public function create()
    {
        return view('admin.features.form', ['feature' => new Feature]);
    }

    public function store(Request $request)
    {
        Feature::create($this->validated($request));

        return redirect('admin/features')->with('message', trans('layout.add_suc'));
    }

    public function edit(Feature $feature)
    {
        return view('admin.features.form', ['feature' => $feature]);
    }

    public function update(Request $request, Feature $feature)
    {
        $feature->update($this->validated($request));

        return redirect('admin/features')->with('message', trans('layout.edit_suc'));
    }

    public function destroy(Feature $feature)
    {
        $feature->delete();

        return back()->with('message', trans('layout.delete_suc'));
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'ar_title' => 'required|string|max:255',
            'en_title' => 'required|string|max:255',
            'sort' => 'nullable|integer|min:0',
        ]);
        $data['sort'] ??= 0;

        return $data;
    }
}
