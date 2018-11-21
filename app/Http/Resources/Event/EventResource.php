<?php

namespace App\Http\Resources\Event;

use Illuminate\Http\Resources\Json\JsonResource;
use Auth;
use App\User;
use App\InterestedOnEvent;
class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'eventName'=>$this->eventName,
            'eventPlace'=>$this->eventPlace,
            'eventImage'=>$this->eventImage,
            'eventStartDate'=>$this->eventStartDate,
            'eventStartTime'=>$this->eventStartTime,
            'eventEndDate'=>$this->eventEndDate,
            'eventEndTime'=>$this->eventEndTime,
            'eventDescription'=>$this->eventDescription,
            'createdBy'=>$this->createdBy,
            'creatorName'=>User::findOrFail($this->createdBy)->name,
            'totalGoing'=>count(InterestedOnEvent::where('Interest_type',1)->where('event_id',$this->id)->get()),
            'totalInterested'=>count(InterestedOnEvent::where('Interest_type',2)->where('event_id',$this->id)->get()),
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
