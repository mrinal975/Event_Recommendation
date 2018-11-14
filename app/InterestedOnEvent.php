<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InterestedOnEvent extends Model
{
    //
    protected $fillable = [
        'name', 'email', 'password','photo','phone','image'
    ];
}
