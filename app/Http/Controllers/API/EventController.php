<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Event\EventCollection;
use App\Http\Resources\Profile\UserListCollection;
use App\Http\Resources\Event\EventResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Event\EventRequest;
use App\Event;
use date;
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

        $interst=[];
        $dateToday=date('Y-m-d');
        $count=0;
        $userId=Auth::user('api')->id;
        //fetching if your have gone on some event
        $datas=User::find($userId)->events()->wherePivotIn('Interest_type',[1,2])->latest()->paginate(5);
        if(!empty($datas) && $datas!=null){
            foreach ($datas as $data) {
                $interst[]=$data->eventType;
                $count++;
                }           
            }
            //fetching three interested thing
            //return $count;
        if($count==0){ 
            $userInterest=UserInterest::where('user_id', $userId)->latest()->paginate(5);
            if($userInterest){
                foreach ($userInterest as $data) {
                    $interst[]=$data->Interest_on;
                    $count++;
                }if($count==0){
                    //user created event from next days
                    $eventData=Event::where('eventStartDate','>=',$dateToday)
                    ->where('createdBy','=',$userId)
                    ->latest()->paginate(5);
                }
            } 
            //return 1;   
        }
        //checking data range
        if($count==2){
             $eventData=Event::whereIn('eventType',[$interst[0],$interst[1]])
                    ->whereDate('eventStartDate','>=',$dateToday)->latest()->paginate(5);
        }
        elseif($count==1){
             $eventData=Event::whereIn('eventType',[$interst[0]])
                    ->whereDate('eventStartDate','>=',$dateToday)->latest()->paginate(5);
                    
        }
        elseif($count==3){
             $eventData=Event::whereIn('eventType',[$interst[0],$interst[1],$interst[2]])
                    ->whereDate('eventStartDate','>=',$dateToday)->latest()->paginate(5);
        }
        return EventCollection::collection($eventData);
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
    public function userList(){
        $userId=Auth::user('api')->id;
        $User=User::where('status','=','0')->where('id','!=',$userId)->latest()->paginate(5);
        return UserListCollection::collection($User);
    }
    public function eventWithType($data){
        $dateToday=date('Y-m-d');
         $eventData=Event::where('eventType','=',$data)
                    ->whereDate('eventStartDate','>=',$dateToday)->latest()->paginate(5);
        return EventCollection::collection($eventData);
    }
}
