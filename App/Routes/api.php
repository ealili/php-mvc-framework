<?php

use App\Controllers\UserController;
use Framework\Router;

Router::post('/auth/register', UserController::class, 'store', ['guest']);
Router::post('/auth/logout', UserController::class, 'logout', ['auth']);
Router::post('/auth/login', UserController::class, 'authenticate', ['guest']);

Router::delete('/users/{id}', UserController::class, 'destroy', ['auth']);
Router::put('/users/{id}', UserController::class, 'update', ['auth']);
