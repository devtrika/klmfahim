<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CostRequest;

class CostRequestController extends Controller
{
    public function index()
    {
        return view('admin.requests.index', ['requests' => CostRequest::latest()->get()]);
    }

    public function show(CostRequest $request)
    {
        $request->update(['seen' => true]);

        return view('admin.requests.show', ['item' => $request]);
    }

    public function destroy(CostRequest $request)
    {
        $request->delete();

        return redirect('trika/requests')->with('message', trans('layout.delete_suc'));
    }
}
