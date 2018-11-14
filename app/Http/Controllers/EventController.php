<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Event\EventRequest;
use App\Event;
use Illuminate\Support\Facades\Auth;
use Image;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class EventController extends Controller
{
    public function index()
    {
    }

    public function store(EventRequest $request)
    {
 

        $event=new Event;
             if(!empty($request->eventImage)){
            $name=time().'.'. explode('/',explode(':',substr($request->eventImage,0,strpos($request->eventImage,';')))[1])[1];
            Image::make($request->eventImage)->save(public_path('img/event/').$name);
            $request->merge(['eventImage'=>$name]);
            }
        $event->eventImage=$request->eventImage;
        $event->eventType=$request->eventType;
        $event->eventName=$request->eventName;
        $event->eventPlace=$request->eventPlace;
        $event->eventStartDate=$request->eventStartDate;
        $event->eventStartTime=$request->eventStartTime;
        $event->eventEndDate=$request->eventEndDate;
        $event->eventEndTime=$request->eventEndTime;
        $event->eventDescription=$request->eventDescription;
        $event->createdBy=Auth::user('')->id;
        $event->save();
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
    public function update(Request $request, $id)
    {
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
