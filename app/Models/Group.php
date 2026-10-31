<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Config;

class Group extends Model {
    use \App\Models\Concerns\HasUuid;


  public function Permissions() {
        return $this->hasMany(Permission::class, 'group_id', 'id');
    }

    public function users() {
        return $this->hasMany(User::class, 'group_id', 'id');
    }

    public function getList() {
        $lang = Config::get('app.locale');

        return $this->pluck($lang.'_name', 'id')->toArray();
    }

    public function getAll() {
        return $this->all();
    }

    public function getById($id) {
        return $this->where('uuid', $id)->firstOrFail();
    }

    public function add($data) {
        $this->ar_name = $data['ar_name'];
        $this->en_name = $data['en_name'];
        $this->save();
        return $this->id;
    }

    public function edit($id, $data) {
        $group = $this->where('uuid', $id)->firstOrFail();
        $group->ar_name = $data['ar_name'];
        $group->en_name = $data['en_name'];
        return $group->save();
    }

    public function remove($id) {
        $group = $this->where('uuid', $id)->firstOrFail();
        return $group->delete();
    }

}
