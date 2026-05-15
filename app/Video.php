<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model {

    public function getAll() {
        return $this->all();
    }

    public function getById($id) {
        return $this->find($id);
    }

    public function add($data) {
        $this->ar_title = $data['ar_title'];
        $this->en_title = $data['en_title'];
        $this->ar_desc = $data['ar_desc'];
        $this->en_desc = $data['en_desc'];
        $this->inslide = $data['inslide'];
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $data['link'], $match);

        $this->link = $match[1];

        return $this->save();
    }

    public function edit($id, $data) {
        $dept = $this->find($id);
        $dept->ar_title = $data['ar_title'];
        $dept->en_title = $data['en_title'];
        $dept->ar_desc = $data['ar_desc'];
        $dept->en_desc = $data['en_desc'];
        $dept->inslide = $data['inslide'];
         preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $data['link'], $match);

        $dept->link = $match[1];

        return $dept->save();
    }

    public function remove($id) {
        $dept = $this->find($id);
        return $dept->delete();
    }

}
