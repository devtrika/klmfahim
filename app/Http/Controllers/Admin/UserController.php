<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Group;
use App\Http\Requests\StoreUser;
class UserController  extends Controller {
    function __construct(User $user ,Group $Group) {
        $this->user = $user;
        $this->group = $Group;
    }

    public function index() {
        //
        $users = $this->user->getType('user');
        return view('admin.users.index', ['users' => $users]);
    }


    public function destroy($id) {
        $this->user->remove($id);
        $message = trans('layout.delete_suc');
        return back()->with(['message' => $message]);
    }
    public function create() {
        $groups =$this->group->getAll();
        return view('admin.users.create', ['groups' => $groups]);
    }
    public function store(StoreUser $request) {
        $this->user->add($request);
        $message = trans('layout.add_suc');
        return back()->with(['message' => $message]);
    }
    public function show($id) {
    }
    public function edit($id) {
        $user = $this->user->getById($id);
        $groups =$this->group->getAll();
        return view('admin.users.create', ['user' => $user,'groups' => $groups]);
    }
    public function update(Request $request, $id) {
        $arr=[
            'name' => "required|unique:users,name,$id",
            'username' => "required|unique:users,username,$id",
            'email' => "required|email|unique:users,email,$id",
            'group' => "required",
            'phone' => "numeric|required|unique:users,phone,$id"];
        if($request['password'])
        $arr +=['password' => "required|confirmed"];
        $this->validate($request,$arr);
        $this->user->edit($id, $request);
        $message = trans('layout.edit_suc');
        return redirect('admin/users')->with(['message' => $message]);
    }
}
