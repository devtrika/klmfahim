<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UpdateClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Opinon;
// use App\Http\Requests\StoreOP ;
use Illuminate\Support\Str;


class OpinionController extends Controller {

    //
    function __construct(Opinon $client) {
        $this->client = $client;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
        $clients = $this->client->getAll();
        return view('admin.opinions.index', ['clients' => $clients]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
        return view('admin.opinions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        
        $this->validate($request, [
           "ar_title" => "required",
            "en_title" => "required",
            "ar_desc" => "required",
            "en_desc" => "required"
        ]);
        
       $filename =false;
          if ($request->hasFile('image')) {
        $file = $request['image'];
        $filename = Str::random(5) . '.' . $file->getClientOriginalName();
        $destinationPath = public_path('upload/opinions/');
        $file->move($destinationPath, $filename);
          }
        $this->client->add($request, $filename);
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
        $client = $this->client->getById($id);
        return view('admin.opinions.edit', ['client' => $client]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request  $request, $id) {
$this->validate($request, [
           "ar_title" => "required",
            "en_title" => "required",
            "ar_desc" => "required",
            "en_desc" => "required"
        ]);
        $filename = FALSE;
        if ($request->hasFile('image')) {
            $file = $request['image'];
            $filename = Str::random(5) . '.' . $file->getClientOriginalName();
            $destinationPath = public_path('upload/opinions/');
            $file->move($destinationPath, $filename);
        }

        $this->client->edit($id, $request, $filename);
        $message = trans('layout.edit_suc');
        return redirect('admin/opinions')->with(['message' => $message]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
        $this->client->remove($id);
        $message = trans('layout.delete_suc');
        return back()->with(['message' => $message]);
    }

}
