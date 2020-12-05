<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{
    protected $casts = [
        'rate' => 'float',
    ];
}
