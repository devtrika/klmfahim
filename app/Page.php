<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
Use File;

class Page extends Model {

    public function getAll() {
        return $this->all();
    }

    public function getById($id) {
        return $this->find($id);
    }

    public function add($data, $file) {
        $this->dept = $data['dept'];
        $this->ar_title = $data['ar_title'];
        $this->en_title = $data['en_title'];
        $this->ar_desc = $data['ar_desc'];
        $this->en_desc = $data['en_desc'];
        $this->image = $file;
        return $this->save();
    }

    public function edit($id, $data, $file = false) {
        $dept = $this->find($id);
        $dept->dept = $data['dept'];
        $dept->ar_title = $data['ar_title'];
        $dept->en_title = $data['en_title'];
        $dept->ar_desc = $data['ar_desc'];
        $dept->en_desc = $data['en_desc'];
        if ($file) {
            $path = public_path('upload/pages/');
            $filename = $dept->image;
            File::Delete($path . $filename);
            $dept->image = $file;
        }
        return $dept->save();
    }

    public function remove($id) {
        $dept = $this->find($id);
        $path = public_path('upload/pages/');
        $filename = $dept['image'];
        File::Delete($path . $filename);
        return $dept->delete();
    }
}
