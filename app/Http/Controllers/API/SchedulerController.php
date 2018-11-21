<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Scheduler;
use App\Http\Resources\Schedule\ScheduleCollection;
use App\Http\Requests\Schedule\ScheduleRequest;

class SchedulerController extends Controller
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
        $data=Scheduler::where('createdBy',Auth::user('api')->id)->latest()->paginate(3);
        return  ScheduleCollection::collection($data);
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
    public function store(ScheduleRequest $request)
    {
        //return $request->all();
        $Scheduler=new Scheduler;
        $Scheduler->schedulerName=$request->schedulerName;
        $Scheduler->schedulerStartDate=$request->schedulerStartDate;
        $Scheduler->schedulerStartTime=$request->schedulerStartTime;
        $Scheduler->schedulerEndDate=$request->schedulerEndDate;
        $Scheduler->schedulerEndTime=$request->schedulerEndTime;
        $Scheduler->schedulerDescription=$request->schedulerDescription;
        $Scheduler->createdBy=Auth::user('api')->id;
        $Scheduler->save();
        return 1;
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
    public function update(ScheduleRequest $request, $id)
    {
        $Scheduler=Scheduler::findOrFail($id);
        $Scheduler->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Scheduler=Scheduler::findOrFail($id);
        $Scheduler->delete();
        return ['message'=>'delete request'];
    }
}
