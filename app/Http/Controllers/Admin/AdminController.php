<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller {

    //

    public function getLogin() {
        if (Auth::Check()) {
            return redirect('admin');
        }
        return view('admin.home.login');
    }

    public function postLogin() {
        $inputs = Request()->all();

        $remember = FALSE;
        if (isset($inputs['remember'])) {
            $remember = TRUE;
        }
        if (Auth::attempt(['username' => $inputs['username'], 'password' => $inputs['password']], $remember)) {
            $active = Auth::user()->active;
            $type = Auth::user()->type;

            if ($active == 'yes' && $type == "admin") {
                return redirect()->intended('admin');
            } else {
                Auth::logout();
                return back()->withInput()->withError(trans('layout.not_allow'));
            }
        } else {
            return back()->withInput()->withError(trans('layout.wrong_login'));
        }
    }

    public function logout() {
        Auth::logout();
        return redirect('admin/login');
    }

    public function index() {
        if (!Auth::Check()) {
            return redirect('admin/login');
        }
        return view('admin.home.index');
    }

    public function not_allow() {
        return view('admin.home.deny');
    }
}
