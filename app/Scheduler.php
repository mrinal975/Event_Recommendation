<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scheduler extends Model
{
    protected $fillable = [
        'schedulerName', 'schedulerStartDate', 'schedulerStartTime','schedulerEndDate',
        'schedulerEndTime','schedulerDescription','createdBy'
    ];
}
