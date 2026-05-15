<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Daily extends Model {

    protected $table = 'dailyorder';

    //
    public function getAll() {
        return $this->orderby('created_at', 'desc')->get();
    }

    public function getById($id) {
        return $this->find($id);
    }

    public function add($data) {
        $this->ar_name = $data['ar_name'];
        $this->en_name = $data['en_name'];
        $this->status = $data['status'];
        $this->room = $data['room'];
        return $this->save();
    }

    public function edit($id, $data) {
        $dept = $this->find($id);
        $dept->ar_name = $data['ar_name'];
        $dept->en_name = $data['en_name'];
        $dept->status = $data['status'];
        $dept->room = $data['room'];
        return $dept->save();
    }

    public function remove($id) {
        $dept = $this->find($id);
        return $dept->delete();
    }

}
