<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
use Gate;
use Auth;
use Image;
class UserController extends Controller
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
        if($this->authorize('isAdmin') || $this->authorize('isAuthor')){
            return User::latest()->paginate(5);
        }
        //return ;
        //$this->authorize('isAdmin');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
           'name'=>'required|string|max:191',
           'email'=>'required|string|email|max:191|unique:users',
           'password'=>'required|string|min:3', 
        ]);

        return User::create([
            'name'=>$request['name'],
            'email'=>$request['email'],
            'type'=>$request['type'],
            'bio'=>$request['bio'],
            'photo'=>$request['photo'],
            'password'=>Hash::make($request['password']),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        $user=auth('api')->user();
        $currentPhoto=$user->photo;
        $this->validate($request,[
           'name'=>'required|string|max:191',
           'email'=>'required|string|email|max:191|unique:users,email,'.$user->id,
           'password'=>'sometimes|string|min:3', 
        ]);

        if(!empty($request->password)){
            $request->merge(['password'=>Hash::make($request['password'])]);
        }
        if( $request->photo !=$currentPhoto){
            $name=time().'.'. explode('/',explode(':',substr($request->photo,0,strpos($request->photo,';')))[1])[1];
            Image::make($request->photo)->save(public_path('img/profile/').$name);
            $request->merge(['photo'=>$name]);
            $userPhoto=public_path('img/profile/').$currentPhoto;
            if(file_exists($userPhoto)){
                @unlink($userPhoto);
            }
        }
        $user->update($request->all());
        return ['message'=>'Success'];
        
    }

    public function profile()
    {
        return auth('api')->user();
    }
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Respons $request->photoe{
     * }
     */
    public function update(Request $request, $id)
    {
        $user=User::findOrFail($id);

         $this->validate($request,[
           'name'=>'required|string|max:191',
           'email'=>'required|string|email|max:191|unique:users,email,'.$user->id,
        ]);
        if(!empty($request->password)){
            $request->merge(['password'=>Hash::make($request['password'])]);
        }

        $user->update($request->all());
        return ['message'=>'Update user info'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id 
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::findOrFail($id);
        $this->authorize('isAdmin');
        $user->delete();
        return ['message'=>'deleted successfully'];
    }
    public function search(Request $request)
    { 
       if ($search = $request['q']) {
            $users = User::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%")
                        ->orWhere('email','LIKE',"%$search%")
                        ->orWhere('type','LIKE',"%$search%");
            })->paginate(20);
        }else{
            $users = User::latest()->paginate(5);
        }
        return $users;
    }
    public function babaloknath(){
        return auth('api')->user();
     }
}
