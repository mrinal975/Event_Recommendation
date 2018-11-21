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
use App\InterestedOnEvent;
use App\UserInterest;

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
        // $adata=array('');
        // $collection =collect(['']);
        // $userId=Auth::user('api')->id;
        // $userInterest=UserInterest::where('user_id', $userId)->latest()->paginate(3);
        // foreach ($userInterest as  $interest) {
        //      $event=Event::where('eventType','LIKE','%'.strtolower($interest->Interest_on).'%')->get();
        //      foreach ($userInterest as $key => $value) {
        //         $collection->put($key,$value);
        //      }
             
        // }
        // dd($collection->all());
        // // return $adata;
        // // return count($event);
        $data=Event::latest()->paginate(5);
        return  EventCollection::collection($data);
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
