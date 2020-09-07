<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\User;

class UserTest extends TestCase
{
    //use DatabaseTransactions;
    // With DatabaseTransactions when you run your test, it prepares the transactions, triggers the test and rolls everything back after execution
    use DatabaseMigrations;
    // With DatabaseMigrations triggers php artisan migrate command and before the application is destroyed, it rolls everything back.
    public function testGetAll()
    {
        $init = $this->boilerPlate();
        $user = $init['user'];
        $response = $this->json('GET', '/v1/users', [], ['Authorization' => $user->token]);  
        return $response->assertResponseStatus(200);           
    } 

    public function testGetById()
    {
        $init = $this->boilerPlate();
        $user = $init['user'];
        $response = $this->json('GET', '/v1/users/'. $user->id, [], ['Authorization' => $user->token]);  
        return $response->assertResponseStatus(200);           
    } 

    public function testCreate()
    {
        $data = [
            "name" => "qwerty",
            "password" => "asdf"
        ];
        $response = $this->json('POST', '/v1/users', $data);
        return $response->assertResponseStatus(200);
    }

    public function testUpdate()
    {
        $init = $this->boilerPlate();
        $user = $init['user'];        
        $data = [
            "name" => "qwerty2",
            "password" => "asdf2"
        ];
        $response = $this->json('PUT', '/v1/users/' .$user->id, $data, ['Authorization' => $user->token]);
        return $response->assertResponseStatus(200);
    }

    public function testDelete()
    {
        $init = $this->boilerPlate();
        $user = $init['user'];
        $response = $this->json('DELETE', '/v1/users/' .$user->id, [], ['Authorization' => $user->token]);
        $response->assertResponseStatus(200);
    }

    public function boilerPlate()
    { 
        $data = [
            'name' => 'testUnit',
            'password' => '123456',
            'token' => User::getToken()
        ];                   
        $user = User::create($data);              
        $data = [
            'user' => $user
        ];
        return $data;              
    }     
  
}
