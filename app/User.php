<?php

namespace App;

use App\Services\Login;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Support\Str;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;
 
    protected $table = "users";
    protected $primaryKey = "id";

    public $timestamps = true;

    protected $fillable = [
        'name', 'password', 'token'
    ];

    protected $hidden = [
        'password',
        'created_at',
        'updated_at'
    ];
    
    protected static $rules = [
        'name' => ['required', 'unique:users'],
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

    static public function getToken()
    {
        $token = Str::random(40);
        return $token;
    } 

    // Mutator to encrypt password
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Login::bcrypt($value);
    }
    
}
