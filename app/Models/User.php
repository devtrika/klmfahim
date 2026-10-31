<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Group;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable {
    use \App\Models\Concerns\HasUuid;


    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getAll() {
        return $this->all();
    }
  public function Permissions() {
        return $this->hasMany(Permission::class, 'group_id', 'id');
    }

    public function Group() {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }

    public function getType($type) {
        return $this->where('type', $type)->get();
    }

    public function getById($id) {
        return $this->where('uuid', $id)->firstOrFail();
    }

    public function add($data) {
        $this->name = $data['name'];
        $this->username = $data['username'];
        $this->phone = $data['phone'];
        $this->email = $data['email'];
        $this->active = $data['active'];
        $this->group_id = $data['group'];
        $this->password = Hash::make($data['password']);
        $this->type = 'user';
        return $this->save();
    }

    public function edit($id, $data) {
        $user = $this->where('uuid', $id)->firstOrFail();
        $user->active = $data['active'];
        $user->name = $data['name'];
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        if ($data['password'] != "") {
            $user->password = Hash::make($data['password']);
        }
        return $user->save();
    }

    public function edit_seen($id) {
        $user = $this->where('uuid', $id)->firstOrFail();
        $user->seen = 'yes';
        return $user->save();
    }

    public function add_admin($data) {
        //    $this->group_id = $data['group_id'];
        $this->name = $data['name'];
        $this->username = $data['username'];
        $this->email = $data['email'];
        $this->phone = $data['phone'];
        $this->password = Hash::make($data['password']);
        $this->type = 'admin';
        $this->save();
        return $this->id;
    }

    public function edit_admin($id, $data) {
        $user = $this->where('uuid', $id)->firstOrFail();
        $user->active = $data['active'];
        // $user->group_id = $data['group_id'];
        $user->name = $data['name'];
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        if ($data['password'] != "") {
            $user->password = Hash::make($data['password']);
        }
        return $user->save();
    }
}
