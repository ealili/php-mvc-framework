<?php

namespace Framework\Middlewares;

use Framework\Session;

class Authorize
{
    /** Check if user is authenticated
     *
     * @return bool
     */
    public function isAuthenticated()
    {
        return Session::has('user');
    }

    /**
     * Handle the user request
     *
     * @param string $role
     * @return void
     */
    public function handle(string $role)
    {
        if ($role === 'guest' && $this->isAuthenticated()) {
            redirect('/');
        } elseif ($role === 'auth' && !$this->isAuthenticated()) {
            redirect('/auth/login');
        }
    }
}
