<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\CalculatorItem;
use App\Models\Client;
use App\Models\Contact;
use App\Models\Feature;
use App\Models\Opinon;
use App\Models\Page;
use App\Models\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('front.home', [
            'jurisdictions' => CalculatorItem::where('group', 'jurisdiction')->orderBy('sort')->get(),
            'visaPrice' => (int) CalculatorItem::where('group', 'visa')->value('price'),
            'partners' => Client::orderBy('id')->get(),
            'features' => Feature::orderBy('sort')->get(),
            'government' => Service::where('category', 'government')->orderBy('sort')->limit(8)->get(),
            'services' => Service::where('category', '!=', 'government')->orderBy('sort')->get(),
            'opinions' => Opinon::latest()->limit(3)->get(),
            'posts' => Blog::where('active', 'yes')->latest()->limit(3)->get(),
        ]);
    }

    public function services()
    {
        return view('front.services', [
            'services' => Service::orderBy('sort')->get(),
            'features' => Feature::orderBy('sort')->get(),
        ]);
    }

    public function government()
    {
        return view('front.government', [
            'services' => Service::where('category', 'government')->orderBy('sort')->get(),
        ]);
    }

    public function service(string $uuid)
    {
        $service = Service::findByUuid($uuid);

        return view('front.service', [
            'service' => $service,
            'related' => Service::whereKeyNot($service->id)->where('category', $service->category)->orderBy('sort')->limit(3)->get(),
        ]);
    }

    public function news()
    {
        return view('front.news', [
            'posts' => Blog::where('active', 'yes')->latest()->paginate(9),
        ]);
    }

    public function post(string $uuid)
    {
        $post = Blog::where('active', 'yes')->where('uuid', $uuid)->firstOrFail();
        $post->increment('views');

        return view('front.article', ['item' => $post, 'kind' => 'news']);
    }

    public function page(string $uuid)
    {
        return view('front.article', ['item' => Page::findByUuid($uuid), 'kind' => 'page']);
    }

    public function contactus()
    {
        return view('front.contact');
    }

    public function contact(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:40',
            'email' => 'required|email|max:150',
            'title' => 'required|string|max:150',
            'message' => 'required|string|max:5000',
            'captcha' => 'required|captcha',
        ]);

        (new Contact)->add($data);

        return back()->with('message', __('front.sent_ok'));
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha' => captcha_img()]);
    }
}
