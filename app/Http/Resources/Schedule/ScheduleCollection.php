<?php

namespace App\Http\Resources\Schedule;

use Illuminate\Http\Resources\Json\Resource;

class ScheduleCollection extends Resource
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
            'schedulerName'=>$this->schedulerName,
            'schedulerStartDate'=>$this->schedulerStartDate,
            'schedulerStartTime'=>$this->schedulerStartTime,
            'schedulerEndDate'=>$this->schedulerEndDate,
            'schedulerEndTime'=>$this->schedulerEndTime,
            'eventStartTime'=>$this->eventStartTime,
            'schedulerDescription'=>$this->schedulerDescription,
            'createdBy'=>$this->createdBy,
        ];
    }
}
