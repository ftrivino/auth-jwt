<?php

namespace App\Services;

use App\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class Login {

    /**
     *
     * Array with validation rules
     *
     * @var array
     *
     */

    protected static $rules = [
        'name' => 'required',
        'password' => 'required'
    ];


    /**
     * Validation Rules
     *
     * @return array
     */

    static public function getRules() : Array
    {
        return self::$rules;
    }

    public function login($data)
    {
        $user = User::where('name', $data['name'])
                        ->where('password', SELF::bcrypt($data['password']))
                        ->get()
                        ->first();
        return $user;
    }

    public static function bcrypt($password)
    {
        return md5($password);
    }

    public static function JWT($user){
        $token = array(
            'sub' => $user->id,
            'name' => $user->name,
            'iat' => time(),
            'exp' => time() + (7 * 24 * 60 * 60)
        );

        $jwt = JWT::encode($token, getenv('TOKEN_KEY'), 'HS256');
        
        return $jwt;        
    }    
}
