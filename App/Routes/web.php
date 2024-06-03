<?php


use App\Controllers\HomeController;
use App\Controllers\UserController;
use Framework\Router;

Router::get('/', HomeController::class, 'index');
Router::get('/users', UserController::class, 'index', ['auth']);
Router::get('/users/edit/{id}', UserController::class, 'edit', ['auth']);
Router::get('/auth/register', UserController::class, 'create', ['guest']);
Router::get('/auth/login', UserController::class, 'login', ['guest']);
