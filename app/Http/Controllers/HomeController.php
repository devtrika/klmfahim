<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Newsletter;
use App\Page;
use Illuminate\Http\Request;
use Config;
use Mail;
use Cookie;

class HomeController extends Controller {

    function __construct(Contact $Contact) {
        $this->contact = $Contact;
    }

    public function index() {
        return view('interface.index');
    }

    public function services() {
        return view('interface.services');
    }

    public function html() {
        return view('interface.html');
    }

    public function allnews($seo) {
        return view('interface.allnews');
    }

    public function allservices($seo) {
        return view('interface.allservices');
    }

    public function slide($id) {
        $blog = \App\Slider::where('id', $id)->first();
        return view('interface.single', ['page' => $blog, 'type' => 'slider']);
    }

    public function service($id) {
        $blog = \App\Service::where('id', $id)->first();
        return view('interface.single', ['page' => $blog, 'type' => 'services']);
    }

    public function project($id) {
        $blog = \App\Project::where('id', $id)->first();
        return view('interface.single', ['page' => $blog, 'type' => 'projects']);
    }

    public function page($id, $seo) {
        $blog = \App\Page::where('id', $id)->first();
        return view('interface.single', ['page' => $blog, 'type' => 'pages']);
    }

    public function client($id) {
        $blog = \App\Client::where('id', $id)->first();
        return view('interface.single', ['page' => $blog, 'type' => 'clients']);
    }

    public function news($id) {
        $blog = \App\Blog::where('id', $id)->first();
        $blog->increment('views');
        return view('interface.single', ['page' => $blog, 'type' => 'news']);
    }

    public function projects() {
        return view('interface.projects');
    }

    public function contactus() {
        return view('interface.contact');
    }

    public function contact(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'title' => 'required',
            'captcha' => 'required|captcha',
            'message' => 'required',
        ]);
        $req = $request->only('name', 'phone', 'email', 'title', 'message');
        $this->contact->add($req);
        $message = trans('layout.send_suc');
        return back()->with(['message' => $message]);
    }

    public function reloadCaptcha() {
        return response()->json(['captcha' => captcha_img()]);
    }

//    public function subscribe(Request $request) {
//        $this->validate($request, [
//            'email' => 'required|email',
//        ]);
//
//        $Newsletter = new Newsletter();
//        $Newsletter->email =$request['email'];
//        $Newsletter->save();
//        return    response()->json(trans('interface.subscribe_msg'));
//    }
    public function subscribe($id) {
        $News = Newsletter::where('email', $id)->first();
        if ($News)
            return response()->json(['msg' => trans('layout.subscribe_msg_fail')]);
        $Newsletter = new Newsletter();
        $Newsletter->email = $id;
        $Newsletter->save();
        return response()->json(['msg' => trans('layout.subscribe_msg')]);
    }

    public function cost($id) {
        $price = ShipPrices::where('country_id', $id)->with('country')->first();
        return response()->json($price);
    }
}
