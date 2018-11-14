<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInterest extends Model
{
    protected $fillable = [
        'id','user_id', 'Interest_on'
    ];
}
