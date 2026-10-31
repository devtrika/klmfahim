<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Daily;
use Mail;

class DailyController  extends Controller {

    //
    function __construct(Daily $Contact) {
        $this->contact = $Contact;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
       \App\Models\Daily::where('created_at', '<', date('y-m-d'))->delete();
       
        $contacts = $this->contact->getAll();
        return view('admin.daily.index', ['contacts' => $contacts]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
      public function create() {

        return view('admin.daily.create');
    }
    public function edit($id) {
        //
        $contact = $this->contact->getById($id);
        return view('admin.daily.edit', ['page' => $contact]);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'ar_name' => 'required',
            'en_name' => 'required',
        ]);
        $this->contact->add($request);
        $message = trans('layout.add_suc');
        return back()->with(['message' => $message]);
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'ar_name' => 'required',
            'en_name' => 'required',
        ]);
        $this->contact->edit($id, $request);
        $message = trans('layout.send_suc');
        return redirect('admin/daily')->with(['message' => $message]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
        $this->contact->remove($id);
        $message = trans('layout.delete_suc');
        return back()->with(['message' => $message]);
    }

}
