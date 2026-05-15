<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model {

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
        $this->title = $data['title'];
        $this->message = $data['message'];
        $this->reply = "";
        return $this->save();
    }

    public function update_seen($id) {
        $one = $this->find($id);
        $one->seen = 'yes';
        return $one->save();
    }

    public function edit($id, $data) {
        $dept = $this->find($id);
        if ($data['reply'] != "") {
            $dept->reply = $data['reply'];
        } else {
            $dept->reply = "";
        }
        return $dept->save();
    }

    public function remove($id) {
        $dept = $this->find($id);
        return $dept->delete();
    }

}
