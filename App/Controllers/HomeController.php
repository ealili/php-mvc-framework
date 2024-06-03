<?php

namespace App\Controllers;

use Exception;
use Framework\Database;

class HomeController
{
    public function index()
    {
        loadView('home');
    }
}
