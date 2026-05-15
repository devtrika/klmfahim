<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Country;

class Newsletter extends Model {

    //
    public function Country() {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function getAll() {
        return $this->all();
    }

    public function remove($id) {
        $dept = $this->find($id);
        return $dept->delete();
    }

    public function delByCountry($id) {
        return $this->where('country_id', $id)->delete();
    }

}
