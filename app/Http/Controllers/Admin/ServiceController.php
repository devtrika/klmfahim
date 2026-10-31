<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        return view('admin.services.index', ['services' => Service::orderBy('sort')->get()]);
    }

    public function create()
    {
        return view('admin.services.form', ['service' => (new Service)->forceFill(['category' => 'setup'])]);
    }

    public function store(Request $request)
    {
        $service = new Service;
        $this->fill($service, $request);

        return redirect('trika/services')->with('message', trans('layout.add_suc'));
    }

    public function edit(Service $service)
    {
        return view('admin.services.form', ['service' => $service]);
    }

    public function update(Request $request, Service $service)
    {
        $this->fill($service, $request);

        return redirect('trika/services')->with('message', trans('layout.edit_suc'));
    }

    public function destroy(Service $service)
    {
        if ($service->image) {
            File::delete(public_path('upload/services/'.$service->image));
        }
        $service->delete();

        return back()->with('message', trans('layout.delete_suc'));
    }

    private function fill(Service $service, Request $request): void
    {
        $data = $request->validate([
            'category' => 'required|in:setup,government,corporate',
            'icon' => 'nullable|string|max:60',
            'ar_title' => 'required|string|max:255',
            'en_title' => 'required|string|max:255',
            'ar_short' => 'nullable|string|max:255',
            'en_short' => 'nullable|string|max:255',
            'ar_desc' => 'required|string',
            'en_desc' => 'required|string',
            'sort' => 'nullable|integer|min:0',
            'image' => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::random(5).'.'.Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)).'.'.$file->extension();
            $file->move(public_path('upload/services/'), $filename);
            if ($service->image) {
                File::delete(public_path('upload/services/'.$service->image));
            }
            $service->image = $filename;
        }

        unset($data['image']);
        $data['sort'] ??= 0;
        $service->forceFill($data)->save();
    }
}
