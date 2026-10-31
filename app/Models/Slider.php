<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use File;

class Slider extends Model {
    use \App\Models\Concerns\HasUuid;


    protected $table = 'slider';

    //

    public function getAll() {
        return $this->all();
    }

    public function getById($id) {
        return $this->where('uuid', $id)->firstOrFail();
    }

    public function add($data, $file) {
        $this->ar_title = $data['ar_title'];
        $this->en_title = $data['en_title'];
        $this->ar_desc = $data['ar_desc'];
        $this->en_desc = $data['en_desc'];
        $this->image = $file;
        return $this->save();
    }

    public function edit($id, $data, $file = false) {
        $dept = $this->where('uuid', $id)->firstOrFail();
        $dept->ar_title = $data['ar_title'];
        $dept->en_title = $data['en_title'];
        $dept->ar_desc = $data['ar_desc'];
        $dept->en_desc = $data['en_desc'];
        if ($file) {
            $path = public_path('upload/slider/');
            $filename = $dept->image;
            File::Delete($path . $filename);
            $dept->image = $file;
        }
        return $dept->save();
    }

    public function remove($id) {
        $dept = $this->where('uuid', $id)->firstOrFail();
        $path = public_path('upload/slider/');
        $filename = $dept['image'];
        File::Delete($path . $filename);
        return $dept->delete();
    }

}
