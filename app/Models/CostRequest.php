<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CostRequest extends Model
{
    use \App\Models\Concerns\HasUuid;

    protected $fillable = ['name', 'phone', 'email', 'selections', 'estimate', 'seen'];

    protected $casts = [
        'selections' => 'array',
        'estimate' => 'integer',
        'seen' => 'boolean',
    ];
}
