<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model {
    use \App\Models\Concerns\HasUuid;


    //
    public function Country() {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function getAll() {
        return $this->all();
    }

    public function remove($id) {
        $dept = $this->where('uuid', $id)->firstOrFail();
        return $dept->delete();
    }

    public function delByCountry($id) {
        return $this->where('country_id', $id)->delete();
    }

}
