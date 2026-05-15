<?php

namespace App\Http\Controllers\Admin;

use App\Advantage;
use App\Http\Requests\StoreAdv;
use App\Http\Requests\UpdateAdv;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;


class AdvController extends Controller {

    //
    function __construct(Advantage $advantage) {
        $this->advantage = $advantage;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
        $advantages = $this->advantage->getAll();
        return view('admin.advantages.index', ['advantages' => $advantages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
        return view('admin.advantages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdv $request) {
        $file = $request['image'];
        $filename = Str::random(5) . '.' . $file->getClientOriginalName();
        $destinationPath = public_path('upload/advantages/');
        $file->move($destinationPath, $filename);

        $this->advantage->add($request, $filename);
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
        $advantage= $this->advantage->getById($id);
        return view('admin.advantages.edit', ['advantage' => $advantage]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdv $request, $id) {
        //
        $filename = FALSE;
        if ($request->hasFile('image')) {
            $file = $request['image'];
            $filename = Str::random(5) . '.' . $file->getClientOriginalName();
            $destinationPath = public_path('upload/advantages/');
            $file->move($destinationPath, $filename);
        }

        $this->advantage->edit($id, $request, $filename);
        $message = trans('layout.edit_suc');
        return redirect('admin/advantages')->with(['message' => $message]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
        $this->advantage->remove($id);
        $message = trans('layout.delete_suc');
        return back()->with(['message' => $message]);
    }

}
