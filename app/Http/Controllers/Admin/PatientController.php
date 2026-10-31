<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;

class PatientController extends Controller {

    //
    function __construct(\App\Models\Patient $Contact) {
        $this->contact = $Contact;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
        $contacts = $this->contact->getAll();
        return view('admin.patient.index', ['contacts' => $contacts]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create() {

        return view('admin.patient.create');
    }

    public function edit($id) {
        //
        $contact = $this->contact->getById($id);
        return view('admin.patient.edit', ['page' => $contact]);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'ar_name' => 'required',
            'en_name' => 'required',
        ]);
        $id = $this->contact->add($request);
        if ($request['money'] && $request['status'] && $request['dates']) {
            $pp = new \App\Models\Patient_status();
            $pp->money = $request['money'];
            $pp->status = $request['status'];
            $pp->user = $id;
            $pp->dates = $request['dates'];
            $pp->save();
        }

        $message = trans('layout.add_suc');
        return back()->with(['message' => $message]);
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'ar_name' => 'required',
            'en_name' => 'required',
        ]);
        $this->contact->edit($id, $request);
        if ($request['money'] && $request['status'] && $request['dates']) {
            $pp = new \App\Models\Patient_status();
            $pp->money = $request['money'];
            $pp->status = $request['status'];
            $pp->user = $id;
            $pp->dates = $request['dates'];
            $pp->save();
        }
        $message = trans('layout.send_suc');
        return redirect('trika/patient')->with(['message' => $message]);
    }

    public function removethis($id) {
        \App\Models\Patient_status::where('id', $id)->delete();
        $message = trans('layout.delete_suc');
        return back()->with(['message' => $message]);
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
