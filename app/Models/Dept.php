<?php

namespace App\Models;
use Config;

use Illuminate\Database\Eloquent\Model;


class Dept extends Model {
    use \App\Models\Concerns\HasUuid;


    public function getAll() {
        return $this->all();
    }
  public function getList() {
        $lang = Config::get('app.locale');

        return $this->pluck($lang.'_title', 'id')->toArray();
    }
    public function getById($id) {
        return $this->where('uuid', $id)->firstOrFail();
    }

    public function add($data) {
        $this->position = $data['position'];
        $this->ar_title = $data['ar_title'];
        $this->en_title = $data['en_title'];
        return $this->save();
    }

    public function edit($id, $data) {
        $dept = $this->where('uuid', $id)->firstOrFail();
         $dept->position = $data['position'];
        $dept->ar_title = $data['ar_title'];
        $dept->en_title = $data['en_title'];
        return $dept->save();
    }

    public function remove($id) {
        $dept = $this->where('uuid', $id)->firstOrFail();
        return $dept->delete();
    }

}
