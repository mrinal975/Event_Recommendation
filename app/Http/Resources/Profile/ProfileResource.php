<?php

namespace App\Http\Resources\Profile;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Friend;

class ProfileResource extends JsonResource
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
            'name'=>$this->name,
            'email'=>$this->email,
            'phone'=>$this->phone,
            'image'=>$this->image,
            'profileType'=> $this->status==0 ? 'Public':'Private',
            'following'=>count(Friend::where('hwo','=',$this->id)
                                    ->where('whom','!=','0')->get()),
            'followers'=>count(Friend::where('whom','=',$this->id)
                                        ->where('hwo','!=','0')->get()),
        ];
    }
}
