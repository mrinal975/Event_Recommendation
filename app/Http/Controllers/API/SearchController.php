<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Http\Resources\Event\EventCollection;
use App\Event;
use date;
use DB;
use App\Friend;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function search(Request $request)
    {
        $date=self::datecalculate();
        $userId=Auth::user('api')->id;
        $search =$request->body['searchText'];
        // return $search;
        $startDate =$request->body['startDate'];
        $endDate =$request->body['endDate'];
        if(empty($startDate) && empty($endDate)){
            
            $resultData= self::eventSearch($search,$date);
            if(count($resultData)==0){
            $SecondUser=User::where('name','LIKE', '%' . $search . '%')->first();
                if(count( $SecondUser)!=0)
                {
                    $friend=Friend::where('hwo', $userId)->where('whom', $SecondUser->id)->first();
                    //return $friend;
                    if(count( $friend)!=0){
                        $resultData= DB::table('events')
                                ->join('interested_on_events','events.id','=','interested_on_events.event_id')
                                ->select('events.*')
                                ->where('interested_on_events.user_id','=',$SecondUser->id)
                                ->get();
                    }
                } 
            }
        }
        else{
            if(empty($endDate)){
                $resultData=Event::where('eventStartDate','>=',$startDate)->get();
            }else{
                $resultData=Event::whereBetween('eventStartDate',array($startDate,$endDate))->get();
            }
           
        }
           
    return  EventCollection::collection($resultData); 
    }
    public function datecalculate(){
        $dateFrom = date('Y-m-d'); 
        return $dateFrom;
    }
    public function eventSearch($search,$date){

        $eventName =Event::where('eventStartDate','>=',$date)
                    ->where('eventName','LIKE', '%' . $search . '%')
				    ->orderBy('id','DESC')
                    ->get();
        $eventPlace= Event::where('eventStartDate','>=',$date)
                    ->where('eventPlace','LIKE', '%' . $search . '%')
				    ->orderBy('id','DESC')
                    ->get();
        $eventType= Event::where('eventStartDate','>=',$date)
                    ->where('eventType','LIKE', '%' . $search . '%')
				    ->orderBy('id','DESC')
                     ->get();
        return self::eventCondition($eventName,$eventPlace,$eventType);
    }
    public function eventCondition($eventName,$eventPlace,$eventType){

        if(count($eventName)!=0){
            return $eventName;
        }elseif(count($eventPlace)!=0){
            return $eventPlace;
        }else{
            return $eventType;
        }
    }

}
