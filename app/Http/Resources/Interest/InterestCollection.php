<?php

namespace App\Http\Resources\Interest;

use Illuminate\Http\Resources\Json\Resource;

class InterestCollection extends Resource
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
            'Interest_on'=>$this->Interest_on,
            'user_id'=>$this->user_id
        ];
    }
}
