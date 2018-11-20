<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InterestedOnEvent extends Model
{
    //
    protected $fillable = [
        'user_id', 'Interest_type','previous_interst','previous_going'
    ];
}
