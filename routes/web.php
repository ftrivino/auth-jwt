<?php
$router->get('/', function () use ($router) {
    return $router->app->version();
});

//Public Routes
$router->group(['prefix' => 'v1'], function () use ($router) {   
    $router->group(['prefix' => 'users'], function () use ($router) {  
        $router->post('/', 'UserController@store'); // TDD OK  
    }); 

    $router->group(['prefix' => 'auth'], function () use ($router) {  
        $router->post('/', 'AuthController@login'); //TDD OK  
    });      
});

//Auth Routes
$router->group(['middleware' => ['jwt.auth'], 'prefix' => 'v1'], function () use ($router) { 
    $router->group(['prefix' => 'users'], function () use ($router) {  
        $router->get('/', 'UserController@index'); // TDD OK
        $router->get('/{id}', 'UserController@show'); // TDD OK
        $router->put('/{id}', 'UserController@update'); // TDD OK
        $router->delete('/{id}', 'UserController@destroy'); // TDD OK   
    });   
});
