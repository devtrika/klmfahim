<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use \App\Models\Concerns\HasUuid;

    protected $fillable = ['ar_title', 'en_title', 'sort'];
}
