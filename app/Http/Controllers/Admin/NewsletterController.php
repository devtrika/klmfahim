<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Newsletter;
use App\Http\Requests\UpdateNewsletter;
use Mail;

class NewsletterController extends Controller {

    //
    function __construct(Newsletter $Newsletter) {
        $this->newsletter = $Newsletter;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
        $newsletter = $this->newsletter->getAll();
        return view('admin.newsletter.index', ['newsletter' => $newsletter]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $newsletters = $this->newsletter->getAll();
        return view('admin.newsletter.create', ['newsletter' => $newsletters]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpdateNewsletter $request) {
        $emails = $request['emails'];
        foreach ($emails as $email) {
            Mail::send('emails.newsletter', ['title' => $request['title'], 'content' => $request['message']], function ($message) use($email, $request) {
                $message->to($email);
                $message->subject($request['title']);
            });
        }
        $message = trans('layout.send_suc');
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
        $this->newsletter->remove($id);
        $message = trans('layout.delete_suc');
        return back()->with(['message' => $message]);
    }

}
