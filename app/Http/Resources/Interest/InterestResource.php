<?php

namespace App\Http\Resources\Interest;

use Illuminate\Http\Resources\Json\JsonResource;

class InterestResource extends JsonResource
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
            'Interest_on'=>$this->Interest_on,
        ];
    }
}
