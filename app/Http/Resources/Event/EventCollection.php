<?php

namespace App\Http\Resources\Event;

use Illuminate\Http\Resources\Json\Resource;
use Auth;
use App\User;
use App\InterestedOnEvent;
class EventCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'eventImage'=>$this->eventImage,
            'eventType'=>$this->eventType,
            'eventName'=>$this->eventName,
            'eventPlace'=>$this->eventPlace,
            'eventStartDate'=>$this->eventStartDate,
            'eventStartTime'=>$this->eventStartTime,
            'eventEndDate'=>$this->eventEndDate,
            'eventEndTime'=>$this->eventEndTime,
            'createdBy'=>$this->createdBy,
            'intereststatus'=>InterestedOnEvent::where('user_id',Auth::user('api')->id)
                                                ->where('event_id',$this->id)
                                                ->where('Interest_type',2)->first() ? 
                                                "Not interested":"Interested",
            'goingstatus'=>InterestedOnEvent::where('user_id',Auth::user('api')->id)
                                                ->where('event_id',$this->id)
                                                ->where('Interest_type',1)->first() ? 
                                                "Not going":"Going",
        ];
    }
}
