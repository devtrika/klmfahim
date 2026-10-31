<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Http\Requests\StoreVideo;

class VideoController extends Controller {

    //
    function __construct(Video $Video) {
        $this->slider = $Video;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
        $sliders = $this->slider->getAll();
        return view('admin.videos.index', ['sliders' => $sliders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
        return view('admin.videos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVideo $request) {
        $this->slider->add($request);
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
        return view('admin.videos.edit', ['slider' => $slider]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreVideo $request, $id) {

        $this->slider->edit($id, $request);
        $message = trans('layout.edit_suc');
        return redirect('trika/videos')->with(['message' => $message]);
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
