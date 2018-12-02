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
        if(empty($search)){
            if(empty($endDate)){
                $resultData=Event::where('eventStartDate','>=',$startDate)->latest()->paginate(5);
            }else{
                $resultData=Event::whereBetween('eventStartDate',array($startDate,$endDate))->latest()->paginate(5);
            }
        }elseif(!empty($endDate) && !empty($startDate) && !empty($search)){
            $resultData=self::eventSearchWithStartAndEnd($search,$startDate,$endDate);
        }elseif(empty($endDate) && !empty($startDate) && !empty($search)){
            $resultData=self::eventSearchWithOnlyStart($search,$startDate);
        }
        elseif(!empty($search) && empty($startDate) && empty($endDate)){
            $resultData=self::eventSearch($search,$date);
        }
        if(count($resultData)==0){
            $resultData=self::SearchWithFriendName($search,$userId);
        } 
        if(count($resultData)==0){
            $SecondUser=User::where('email','LIKE', '%' . $search . '%')->first();
            if(count( $SecondUser)!=0)
            {
            $friend=Friend::where('hwo', $userId)->where('whom', $SecondUser->id)->first();
            // search With Friend name 
            if(count( $friend)!=0){
                $resultData= DB::table('events')
                        ->join('interested_on_events','events.id','=','interested_on_events.event_id')
                        ->select('events.*')
                        ->where('interested_on_events.user_id','=',$SecondUser->id)
                        ->whereIn('interested_on_events.Interest_type',['1','2'])
                        ->get();
            }
            } 

        }
        if(count($resultData)>0){
            return  EventCollection::collection($resultData); 
        }  
        else{
            return 'Not Found';
        }
    }
    public function SearchWithFriendName($search,$userId){
        $SecondUser=User::where('name','LIKE', '%' . $search . '%')->first();
            if(count( $SecondUser)!=0)
            {
            $friend=Friend::where('hwo', $userId)->where('whom', $SecondUser)->first();
            // search With Friend name 
            if(count( $friend)!=0){
                $resultData= DB::table('events')
                        ->join('interested_on_events','events.id','=','interested_on_events.event_id')
                        ->select('events.*')
                        ->where('interested_on_events.user_id','=',$SecondUser->id)
                        ->whereIn('interested_on_events.Interest_type',['1','2'])
                        ->get();
            }
        }

    }
    public function datecalculate(){
        $dateFrom = date('Y-m-d'); 
        return $dateFrom;
    }
    public function eventSearchWithOnlyStart($search,$startDate){
        $eventName =Event::where('eventName','LIKE', '%' . $search . '%')
                    ->where('eventStartDate','>=',$startDate)
				    ->orderBy('id','DESC')
                    ->latest()->paginate(5);
        $eventPlace= Event::where('eventPlace','LIKE', '%' . $search . '%')
                    ->where('eventStartDate','>=',$startDate)
				    ->orderBy('id','DESC')
                    ->latest()->paginate(5);
        $eventType= Event::where('eventType','LIKE', '%' . $search . '%')
                    ->where('eventStartDate','>=',$startDate)
				    ->orderBy('id','DESC')
                     ->latest()->paginate(5);
        return self::eventCondition($eventName,$eventPlace,$eventType);
    }
    public function eventSearchWithStartAndEnd($search,$startDate,$endDate){
        $eventName =Event::where('eventName','LIKE', '%' . $search . '%')
                    ->whereBetween('eventStartDate',array($startDate,$endDate))
				    ->orderBy('id','DESC')
                    ->latest()->paginate(5);
        $eventPlace= Event::where('eventPlace','LIKE', '%' . $search . '%')
                    ->whereBetween('eventStartDate',array($startDate,$endDate))
				    ->orderBy('id','DESC')
                    ->latest()->paginate(5);
        $eventType= Event::where('eventType','LIKE', '%' . $search . '%')
                    ->whereBetween('eventStartDate',array($startDate,$endDate))
				    ->orderBy('id','DESC')
                     ->latest()->paginate(5);
        return self::eventCondition($eventName,$eventPlace,$eventType);
    }
    public function eventSearch($search,$date){

        $eventName =Event::where('eventStartDate','>=',$date)
                    ->where('eventName','LIKE', '%' . $search . '%')
				    ->orderBy('id','DESC')
                    ->latest()->paginate(5);
        $eventPlace= Event::where('eventStartDate','>=',$date)
                    ->where('eventPlace','LIKE', '%' . $search . '%')
				    ->orderBy('id','DESC')
                    ->latest()->paginate(5);
        $eventType= Event::where('eventStartDate','>=',$date)
                    ->where('eventType','LIKE', '%' . $search . '%')
				    ->orderBy('id','DESC')
                     ->latest()->paginate(5);
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
