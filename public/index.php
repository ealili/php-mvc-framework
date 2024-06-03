<?php

require __DIR__ . '/../vendor/autoload.php';

use Framework\Router;
use Framework\Session;

require('../helpers.php');

Session::start();

// Load routes
$routes = require basePath('App/Routes/web.php');
$routes = require basePath('App/Routes/api.php');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

Router::route($uri);
