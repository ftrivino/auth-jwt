<?php

namespace App\Http\Controllers;

use App\Services\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * User Login.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validate($request, Login::getRules());
        $service = new Login();
        $user = $service->login($request->all());
        if ($user) {
            return $this->responseSuccess($user);
        }    
        return $this->responseFail(); 
    }

}
