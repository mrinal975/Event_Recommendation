<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use date;
use DB;
use App\Event;
use App\User;
use App\Scheduler;
use App\Http\Resources\DailySedule\DailyEventConllection;
use App\Http\Resources\Schedule\ScheduleCollection;
class DailyScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function DailyEvent()
    {
        $dateToday=self::today();
        $data=DB::table('events')
            ->join('interested_on_events', 'events.id', '=', 'interested_on_events.event_id')
            ->where('interested_on_events.user_id','=',Auth::user('api')->id)
            ->where('interested_on_events.Interest_type','=','1')
            ->whereDate('eventStartDate','=',$dateToday)
            ->select('events.*')
            ->get();
        return  DailyEventConllection::collection($data);
        //return $dateToday;
    }

    public function DailySchedulet()
    {   
        $dateToday=date('Y-m-d');
        $data=Scheduler::where('createdBy','=',Auth::user('api')->id)
                        ->whereDate('schedulerStartDate','=',$dateToday)
                        ->latest()->paginate(3);
        return  ScheduleCollection::collection($data);
        //return $dateToday;
    }

    public function today(){
        $date = date('Y-m-d');
        return $date;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
