<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Http\Requests\StoreSlider;
use App\Http\Requests\UpdateSlider;
use Illuminate\Support\Str;

class SliderController extends Controller {

    //
    function __construct(Slider $Slider) {
        $this->slider = $Slider;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
        $sliders = $this->slider->getAll();
        return view('admin.slider.index', ['sliders' => $sliders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
        return view('admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSlider $request) {
        $file = $request['image'];
        $filename = Str::random(5) . '.' . $file->getClientOriginalName();
        $destinationPath = public_path('upload/slider/');
        $file->move($destinationPath, $filename);

        $this->slider->add($request, $filename);
        $message = trans('layout.add_suc');
        return back()->with(['message' => $message]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
        $slider = $this->slider->getById($id);
        return view('admin.slider.edit', ['slider' => $slider]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSlider $request, $id) {
        //
        $filename = FALSE;
        if ($request->hasFile('image')) {
            $file = $request['image'];
            $filename = Str::random(5) . '.' . $file->getClientOriginalName();
            $destinationPath = public_path('upload/slider/');
            $file->move($destinationPath, $filename);
        }

        $this->slider->edit($id, $request, $filename);
        $message = trans('layout.edit_suc');
        return redirect('admin/slider')->with(['message' => $message]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
        $this->slider->remove($id);
        $message = trans('layout.delete_suc');
        return back()->with(['message' => $message]);
    }

}
