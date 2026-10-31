<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Http\Requests\UpdateSite;
use Illuminate\Support\Str;

class SiteController extends Controller {

    //
    function __construct(Site $Site) {
        $this->site = $Site;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $site = $this->site->getData();
        return view('admin.site.index', ['site' => $site]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSite $request, $id) {
        $logo = FALSE;
        $first = FALSE;
        $second = FALSE;
        $third = FALSE;
        $footer = FALSE;
        $video = FALSE;
        $destinationPath = public_path('/');

        if ($request->hasFile('logo')) {
            $logo = Str::random(5) . '.' . $request['logo']->getClientOriginalName();
            $request['logo']->move($destinationPath, $logo);
        }
        if ($request->hasFile('video')) {

            $video = Str::random(20) . '.' . $request['video']->getClientOriginalExtension();
            $request['video']->move($destinationPath, $video);
        }

//        if ($request->hasFile('first')) {
//            $file = $request['first'];
//            $first = Str::random(5) . '.' . $file->getClientOriginalName();
//            $file->move($destinationPath, $first);
//        }
//        if ($request->hasFile('second')) {
//            $file = $request['second'];
//            $second = Str::random(5) . '.' . $file->getClientOriginalName();
//            $file->move($destinationPath, $second);
//        }
        if ($request->hasFile('third')) {
            $file = $request['third'];
            $third = Str::random(5) . '.' . $file->getClientOriginalName();
            $file->move($destinationPath, $third);
        }
        if ($request->hasFile('footer')) {
            $file = $request['footer'];
            $footer = Str::random(5) . '.' . $file->getClientOriginalName();
            $file->move($destinationPath, $footer);
        }
        $this->site->edit($request, $logo, $first, $second, $third, $footer, $video);
        $message = trans('layout.edit_suc');
        return back()->with(['message' => $message]);
    }
}
