<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model {

    protected $table = 'patients';

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
        $this->age = $data['age'];
        $this->address = $data['address'];
        $this->phone = $data['phone'];
        $this->save();
        return $this->id;
    }

    public function edit($id, $data) {
        $dept = $this->find($id);
        $dept->ar_name = $data['ar_name'];
        $dept->en_name = $data['en_name'];
        $dept->age = $data['age'];
        $dept->address = $data['address'];
        $dept->phone = $data['phone'];
        return $dept->save();
    }

    public function remove($id) {
        $dept = $this->find($id);
        return $dept->delete();
    }

}
