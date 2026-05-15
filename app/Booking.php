<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model {

    protected $table = 'booking';

    //
    public function getAll() {
        return $this->all();
    }

    public function getById($id) {
        return $this->find($id);
    }

    public function add($data) {
        $this->name = $data['name'];
        $this->phone = $data['phone'];
        $this->email = $data['email'];
        return $this->save();
    }

    public function update_seen($id) {
        $one = $this->find($id);
        $one->seen = 'yes';
        return $one->save();
    }

    public function remove($id) {
        $dept = $this->find($id);
        return $dept->delete();
    }

}
