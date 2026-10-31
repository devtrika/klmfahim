<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model {
    use \App\Models\Concerns\HasUuid;


    public function getAll() {
        return $this->all();
    }

    public function getById($id) {
        return $this->where('uuid', $id)->firstOrFail();
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
        $dept = $this->where('uuid', $id)->firstOrFail();
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
        $dept = $this->where('uuid', $id)->firstOrFail();
        return $dept->delete();
    }

}
