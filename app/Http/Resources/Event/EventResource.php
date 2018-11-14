<?php

namespace App\Http\Resources\Event;

use Illuminate\Http\Resources\Json\JsonResource;
use Auth;
use App\User;

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
        ];
    }
}
