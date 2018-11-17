<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\InterestedOnEvent;
class InterestedOnEventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function insterestupdate($id)
    {
    $userId=Auth::user('api')->id;
    $data=InterestedOnEvent::where('user_id', $userId)->where('event_id', $id)->where('Interest_type',2)->first();
    $previous=InterestedOnEvent::where('user_id', $userId)->where('event_id', $id)->where('previous_interst',$id)->first();
    if($data==null && $previous==null){
        $InterestedOnEvent=new InterestedOnEvent;
        $InterestedOnEvent->user_id=$userId;
        $InterestedOnEvent->event_id=$id;
        $InterestedOnEvent->Interest_type=2;
        $InterestedOnEvent->previous_interst=$id;
        $InterestedOnEvent->save();
        return "Not interested";
        }
    elseif($data==null && $previous!=null){
        $previous->Interest_type=2;
        $previous->update();
        return "Not interested";
    }
    else{
        $data->Interest_type=0;
        $data->update();
        return "Interested";
       }
    }
    public function goingupdate($id)
    {
    //    return $id;
    $userId=Auth::user('api')->id;
    $data=InterestedOnEvent::where('user_id', $userId)->where('event_id', $id)->where('Interest_type',1)->first();
    $previous=InterestedOnEvent::where('user_id', $userId)->where('event_id', $id)->where('previous_going',$id)->first();
    if($data==null && $previous==null){
        $InterestedOnEvent=new InterestedOnEvent;
        $InterestedOnEvent->user_id=$userId;
        $InterestedOnEvent->event_id=$id;
        $InterestedOnEvent->Interest_type=1;
        $InterestedOnEvent->previous_going=$id;
        $InterestedOnEvent->save();
        return "Not going";
        }
    elseif($data==null && $previous!=null){
        $previous->Interest_type=1;
        $previous->update();
        return "Not going";
    }
    else{
        $data->Interest_type=0;
        $data->update();
        return "Going";
       }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
