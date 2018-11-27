<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\ProfileRequest;
use DB;
use Auth;
use Image;
use App\User;
use App\Friend;
use App\UserInterest;
use App\Http\Resources\Profile\ProfileResource;
use App\Http\Resources\Interest\InterestCollection;
use App\Http\Resources\User\UserCollection;

class ProfileController extends Controller
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
        $user=User::findOrFail($request->body['id']);

        if(empty($request->body['name'])){
            $validator->failed();
        }elseif(empty($request->body['email'])){
            $validator->failed();
        }

        $currentPhoto=$user->image;
        if($request->body['image'] !=$currentPhoto){
            $name=time().'.'. explode('/',explode(':',substr($request->body['image'],0,strpos($request->body['image'],';')))[1])[1];
            Image::make($request->body['image'])->save(public_path('img/profile/').$name);
          
            $userPhoto=public_path('img/profile/').$currentPhoto;
            if(file_exists($userPhoto)){
                @unlink($userPhoto);
            }
            $user->image=$name;
        }
        $user->name=$request->body['name'];
        $user->email=$request->body['email'];
        $user->phone=$request->body['phone'];
        $user->update();
        return 0;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user=User::findOrFail($id);
        return new ProfileResource($user);
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
    public function following($id)
    {
        $data=DB::table('users')
            ->join('friends','users.id','=','friends.whom')
            ->select('users.*')
            ->where(['friends.hwo' => $id])
            ->get();
        return UserCollection::collection($data);
    }
    public function followers($id)
    {
        $data=DB::table('users')
            ->join('friends','users.id','=','friends.hwo')
            ->select('users.*')
            ->where(['friends.whom' => $id])
            ->get();
        return UserCollection::collection($data);
    }

    public function destroy($id)
    {
        // 
    }
    public function interestShow($id){
        $data=UserInterest::where('user_id',$id)->get();
        return InterestCollection::collection($data);
    }
    public function interestStore(ProfileRequest $request){
        $userId=Auth::user('api')->id;
        $checkExist=UserInterest::where('Interest_on','=',$request->Interest_on)->where('user_id','=',$userId)->first();
        if(count($checkExist)!=0){
            $validator->failed();
        }
        $UserInterest=new UserInterest;
        $UserInterest->user_id=$userId;
        $UserInterest->Interest_on=$request->Interest_on;
        $UserInterest->save();
    }
    public function interestUpdate(ProfileRequest $request, $id){
        $userId=Auth::user('api')->id;
        $interest=UserInterest::findOrfail($id);
        $checkExist=UserInterest::where('Interest_on','=',$request->Interest_on)->where('user_id','=',$userId)->first();
        if(count($checkExist)!=0){
            $validator->failed();
        }
        $interest->update($request->all());
    }

    public function profilePicture(Request $request, $id){
        
    }
    public function interestDelete($id){
        $event=UserInterest::findOrFail($id);
        $event->delete();
        return ['message'=>'delete request'];
    }
    public function totalFollowers($id){
        return count(Friend::where('whom','=',$id)->get());
    }
    
    
}
