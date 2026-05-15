<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Config;

class Group extends Model {

  public function Permissions() {
        return $this->hasMany(Permission::class, 'group_id', 'id');
    }

    public function getList() {
        $lang = Config::get('app.locale');

        return $this->pluck($lang.'_name', 'id')->toArray();
    }

    public function getAll() {
        return $this->all();
    }

    public function getById($id) {
        return $this->find($id);
    }

    public function add($data) {
        $this->ar_name = $data['ar_name'];
        $this->en_name = $data['en_name'];
        $this->save();
        return $this->id;
    }

    public function edit($id, $data) {
        $group = $this->find($id);
        $group->ar_name = $data['ar_name'];
        $group->en_name = $data['en_name'];
        return $group->save();
    }

    public function remove($id) {
        $group = $this->find($id);
        return $group->delete();
    }

}
