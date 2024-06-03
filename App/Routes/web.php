<?php


use Framework\Router;

Router::get('/', 'HomeController@index');
Router::get('/users', 'UserController@index', ['auth']);
Router::get('/users/edit/{id}', 'UserController@edit', ['auth']);
Router::get('/auth/register', 'UserController@create', ['guest']);
Router::get('/auth/login', 'UserController@login', ['guest']);
