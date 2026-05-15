<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
Use File;

class Opinon extends Model {
 protected $table = 'opinions';
    //
    public function getAll() {
        return $this->all();
    }

    public function getById($id) {
        return $this->find($id);
    }

    public function add($data, $file) {
        $this->ar_title = $data['ar_title'];
        $this->en_title = $data['en_title'];
        $this->ar_desc = $data['ar_desc'];
        $this->en_desc = $data['en_desc'];
        if ($file)
            $this->image = $file;
        return $this->save();
    }

    public function edit($id, $data, $file = false) {
        $dept = $this->find($id);
        $dept->ar_title = $data['ar_title'];
        $dept->en_title = $data['en_title'];
        $dept->ar_desc = $data['ar_desc'];
        $dept->en_desc = $data['en_desc'];
        if ($file) {
            $path = public_path('upload/opinions/');
            $filename = $dept->image;
            File::Delete($path . $filename);
            $dept->image = $file;
        }
        return $dept->save();
    }

    public function remove($id) {
        $dept = $this->find($id);
        $path = public_path('upload/opinions/');
        $filename = $dept['image'];
        File::Delete($path . $filename);
        return $dept->delete();
    }

}
