<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Event extends Model
{
    protected $fillable = [
        'id','eventImage', 'eventType', 'eventName','eventPlace','eventStartDate',
        'eventStartTime','eventEndDate','eventEndTime','eventDescription','createdBy',
    ];
    public function users(){
        return $this->belongsToMany('App\User','interested_on_events','event_id','user_id');
    }
}
