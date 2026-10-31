<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class PagesController extends Controller {

    //
    function __construct(Page $Page, \App\Models\Dept $dept) {
        $this->page = $Page;
        $this->dept = $dept;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
        $pages = $this->page->getAll();
        return view('admin.pages.index', ['pages' => $pages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $groups = $this->dept->getList();
        $groups =  Arr::add($groups, '', trans('layout.choosedept'));
        $groups = array_reverse($groups, TRUE);

        return view('admin.pages.create', ['depts' => $groups]);
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
            'ar_desc' => 'required',
            'en_desc' => 'required',
            'image' => 'required',
             'dept' => 'required',
        ]);
        $file = $request['image'];
        $filename = Str::random(5) . '.' . $file->getClientOriginalName();
        $destinationPath = public_path('upload/pages/');
        $file->move($destinationPath, $filename);
        $this->page->add($request, $filename);
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
        $groups = $this->dept->getList();
        $groups =  Arr::add($groups, '', trans('layout.choosedept'));
        $groups = array_reverse($groups, TRUE);

        $page = $this->page->getById($id);
        return view('admin.pages.edit', ['page' => $page, 'depts' => $groups]);
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
            'ar_desc' => 'required',
            'en_desc' => 'required',
               'dept' => 'required',
        ]);
        $filename = FALSE;
        if ($request->hasFile('image')) {
            $file = $request['image'];
            $filename = Str::random(5) . '.' . $file->getClientOriginalName();
            $destinationPath = public_path('upload/pages/');
            $file->move($destinationPath, $filename);
        }
        $this->page->edit($id, $request, $filename);
        $message = trans('layout.edit_suc');
        return redirect('trika/pages')->with(['message' => $message]);
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
