<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model {
    use \App\Models\Concerns\HasUuid;


    protected $table = 'booking';

    //
    public function getAll() {
        return $this->all();
    }

    public function getById($id) {
        return $this->where('uuid', $id)->firstOrFail();
    }

    public function add($data) {
        $this->name = $data['name'];
        $this->phone = $data['phone'];
        $this->email = $data['email'];
        return $this->save();
    }

    public function update_seen($id) {
        $one = $this->where('uuid', $id)->firstOrFail();
        $one->seen = 'yes';
        return $one->save();
    }

    public function remove($id) {
        $dept = $this->where('uuid', $id)->firstOrFail();
        return $dept->delete();
    }

}
