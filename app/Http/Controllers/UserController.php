<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\Login;
use App\User;

class UserController extends Controller
{   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all(); 
        if ($user->count()) {
            return $this->responseSuccess($user);
        }
        return $this->responseFail();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
           return $this->responseSuccess($user);
        }    
        return $this->responseFail();   
    }
        
    /**
     * Store and validate newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $this->validate($request, User::getRules());
    //     $data = $request->all();   
    //     $token = array("token" => User::getToken());
    //     $data = array_replace($data, $token);            
    //     $user = User::create($data);      
    //     if ($user) {
    //         return $this->responseSuccess($user);
    //     }    
    //     return $this->responseFail();
    // }
    public function store(Request $request)
    {
        $this->validate($request, User::getRules());        
        $user = User::create($request->all());      
        if ($user) {
            $user->update(['token' => Login::JWT($user)]);
            return $this->responseSuccess($user);
        }    
        return $this->responseFail();
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
        $user = User::find($id);
        $this->validate($request, User::getRules());
        if ($user) {
            $user->update($request->all());
            return $this->responseSuccess($user);
        }
        return $this->responseFail();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            $user->delete();
            return $this->responseSuccess($user);
        }
        return $this->responseFail();
    }
}
