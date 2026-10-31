<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Group;
use App\Http\Requests\StoreAdmin;
use App\Http\Requests\UpdateAdmin;
use Illuminate\Support\Arr;

class AdminsController extends Controller {

    //
    function __construct(User $User, Group $Group, \App\Models\Permission $permission) {
        $this->user = $User;
        $this->group = $Group;
        $this->permission = $permission;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
        $admins = $this->user->getType('admin');
        return view('admin.admins.index', ['admins' => $admins]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
        $groups = $this->group->getList();
        $groups =  Arr::add($groups, '', trans('layout.choose_group'));
        $groups = array_reverse($groups, TRUE);

        return view('admin.admins.create', ['groups' => $groups]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdmin $request) {
        $id = $this->user->add_admin($request);

        if (isset($request['permissions'])) {
            $premissions = $request['permissions'];
            foreach ($premissions as $pre) {
                $this->permission->add($pre, $id);
            }
        }

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
        $admin = $this->user->getById($id);

        $groups = $this->group->getList();
        $groups =  Arr::add($groups, '', trans('layout.choose_group'));
        $groups = array_reverse($groups, TRUE);

        return view('admin.admins.edit', ['admin' => $admin, 'groups' => $groups]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdmin $request, $id) {

        $this->user->edit_admin($id, $request);
        $this->permission->delByGroup($id);
        if (isset($request['permissions'])) {
            $premissions = $request['permissions'];
            foreach ($premissions as $pre) {
                $this->permission->add($pre, $id);
            }
        }
        $message = trans('layout.edit_suc');
        return redirect('admin/admins')->with(['message' => $message]);
    }

}
