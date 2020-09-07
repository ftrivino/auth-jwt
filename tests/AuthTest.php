<?php

use App\User;
use App\Services\Login;
use Laravel\Lumen\Testing\DatabaseMigrations;

class AuthTest extends TestCase
{
    use DatabaseMigrations;

    public function testLogin()
    {
        $login = new Login();
        User::create([
            'name' => 'cesar',
            'password' => 123456,
            'token' => User::getToken()
        ]);
        $data = [
            'name' => 'cesar',
            'password' => '123456'
        ];
        $user = $login->login($data);
        return $this->assertEquals('cesar', $user->name);
    }

}
