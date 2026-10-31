<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalculatorItem extends Model
{
    use \App\Models\Concerns\HasUuid;

    public const GROUPS = ['jurisdiction', 'activity', 'office', 'visa', 'shareholder', 'extra'];

    protected $fillable = ['group', 'ar_title', 'en_title', 'ar_hint', 'en_hint', 'price', 'sort'];

    protected $casts = ['price' => 'integer'];
}
