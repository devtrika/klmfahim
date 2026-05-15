<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Booking;
use App\Http\Requests\UpdateContact;
use Mail;

class BookingController extends Controller {

    //
    function __construct(Booking $Contact) {
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
        return view('admin.booking.index', ['contacts' => $contacts]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
        $contact = $this->contact->getById($id);
        $this->contact->update_seen($id);
        return view('admin.booking.edit', ['contact' => $contact]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContact $request, $id) {
        //
        $contact = $this->contact->getById($id);
        $this->contact->edit($id, $request);
        if ($contact['reply'] != $request['reply']) {
            Mail::send('emails.contact_reply', ['title' => $request['title'], 'reply' => $request['reply'], 'name' => $request['name'], 'email' => $request['email'], 'phone' => $request['phone'], 'messagee' => $request['message']], function ($message) use($request) {
                $message->to($request['email']);
                $message->subject($request['title']);
            });
        }
        $message = trans('layout.send_suc');
        return redirect('admin/booking')->with(['message' => $message]);
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
