<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {

    //
    public function add($data, $id) {
        $new = new Permission();
        $new->permission = $data;
        $new->group_id = $id;
        return $new->save();
    }

    public function delByGroup($id) {
        return $this->where('group_id', $id)->delete();
    }

}
