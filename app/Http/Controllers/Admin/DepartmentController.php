<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Dept;


class DepartmentController extends Controller {

    //
    function __construct(Dept $Page) {
        $this->page = $Page;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
        $pages = $this->page->getAll();
        return view('admin.depts.index', ['pages' => $pages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
        return view('admin.depts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
         $this->validate($request, [
            'ar_title' => 'required',
            'en_title' => 'required',
        ]);
        $this->page->add($request);
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
        $page = $this->page->getById($id);
        return view('admin.depts.edit', ['page' => $page]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
         $this->validate($request, [
            'ar_title' => 'required',
            'en_title' => 'required',
        ]);
        $this->page->edit($id, $request);
        $message = trans('layout.edit_suc');
        return redirect('admin/depts')->with(['message' => $message]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
        $this->page->remove($id);
        $message = trans('layout.delete_suc');
        return back()->with(['message' => $message]);
    }

}
