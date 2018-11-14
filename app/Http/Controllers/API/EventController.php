<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Event\EventCollection;
use App\Http\Resources\Event\EventResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Event\EventRequest;
use App\Event;
use Image;
use Gate;
use Auth;
use App\User;
use App\EventDescription;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return Event::latest()->paginate(5);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
        $event->createdBy=Auth::user('api')->id;
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
        $Event=Event::findOrFail($id);
        return new EventResource($Event);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EventRequest $request, $id)
    {
        $event=Event::findOrFail($id);
        $currentPhoto=$event->eventImage;
        if( $request->eventImage !=$currentPhoto){
            $name=time().'.'. explode('/',explode(':',substr($request->eventImage,0,strpos($request->eventImage,';')))[1])[1];
            Image::make($request->eventImage)->save(public_path('img/event/').$name);
            $request->merge(['eventImage'=>$name]);
            $userPhoto=public_path('img/event/').$currentPhoto;
            if(file_exists($userPhoto)){
                @unlink($userPhoto);
            }
        }
        $event->update($request->all());
        // return ['message'=>$id];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event=Event::findOrFail($id);
        $event->delete();
        return ['message'=>'delete request'];
    }
    public function eventshow($id){
        $event=Event::findOrFail($id);
        return $event;
    }
}
