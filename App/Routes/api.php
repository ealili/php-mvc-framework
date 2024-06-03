<?php

use Framework\Router;

Router::post('/auth/register', 'UserController@store', ['guest']);
Router::post('/auth/logout', 'UserController@logout', ['auth']);
Router::post('/auth/login', 'UserController@authenticate', ['guest']);

Router::delete('/users/{id}', 'UserController@destroy', ['auth']);
Router::put('/users/{id}', 'UserController@update', ['auth']);
