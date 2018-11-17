<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Friend;
use Auth;
use App\User;
class FriendController extends Controller
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
        // 
    }
    public function followStaus($id)
    {   
        $userId=Auth::user('api')->id;
        $data=Friend::where('hwo', $userId)->where('whom', $id)->first();
        return count($data)>0 ? "Unfollow" :"Follow";     
    }
    
    public function followOrNot($id)
    {    
    $userId=Auth::user('api')->id;
    $data=Friend::where('hwo', $userId)->where('whom', $id)->first();
    $previous=Friend::where('hwo', $userId)->where('previous_friend', $id)->first();
    if($data==null && $previous==null){
        $friend=new Friend;
        $friend->hwo=$userId;
        $friend->whom=$id;
        $friend->previous_friend=$id;
        $friend->save();
        return "Unfollow";
        }
    elseif($data==null && $previous!=null){
        $previous->whom=$id;
        $previous->update();
        return "Unfollow";
    }
    else{
        $data->whom=0;
        $data->update();
        return "Follow";
       }

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
