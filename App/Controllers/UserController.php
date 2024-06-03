<?php

namespace App\Controllers;

use App\Models\User;
use App\traits\ResponseApi;
use Exception;
use Framework\Session;
use Framework\Validation;

class UserController
{
    use ResponseApi;

    /**
     * Load users view
     *
     * @return void
     * @throws Exception
     */
    public function index()
    {
        $users = User::all();

        loadView('users/index',
            ['users' => $users]);
    }

    /**
     * Show the login page
     *
     * @return void
     */
    public function login()
    {
        loadView('users/login');
    }

    /**
     * Show the register page
     *
     * @return void
     */
    public function create()
    {
        loadView('users/create');
    }

    /**
     * Store user in database
     *
     * @return void
     */
    public function store()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordConfirmation = $_POST['password_confirmation'];
        $city = $_POST['city'];
        $state = $_POST['state'];

        $errors = [];

        // Validate email
        if (!Validation::email($email)) {
            $errors['email'] = 'Please enter a valid email address';
        }

        // Validate name
        if (!Validation::string($name, 2, 50)) {
            $errors['name'] = 'Name must be between 2 and 50 characters';
        }

        // Validate password
        if (!Validation::string($password, 6, 50)) {
            $errors['password'] = 'Password must be at least 6 characters';
        }

        if (!Validation::match($password, $passwordConfirmation)) {
            $errors['password'] = 'Password and password confirmation does not match';
        }

        if (!empty($errors)) {
            loadView('users/create', [
                'errors' => $errors,
                'user' => [
                    'name' => $name,
                    'email' => $email,
                    'city' => $city,
                    'state' => $state,
                ]
            ]);
        }

        // Check if email exists
        $user = User::where(['email' => $email]);

        if ($user) {
            $errors['email'] = 'This email is already registered';
            loadView('users/create', [
                'errors' => $errors,
            ]);
        }

        // Create user account
        $newUser = User::create([
            'name' => $name,
            'email' => $email,
            'city' => $city,
            'state' => $state,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ]);

        Session::set('user', $newUser);

        redirect('/');
    }

    /**
     * Logout the user and clear session
     *
     * @return void
     */
    public function logout()
    {
        Session::clearAll();

        $params = session_get_cookie_params();
        setcookie('PHPSESSID', '', time() - 86400, $params['path'], $params['domain']);

        redirect('/');
    }

    /**
     * Authenticate a user with email and password
     *
     * @return void
     * @throws Exception
     */
    public function authenticate()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $errors = [];

        if (!Validation::email($email)) {
            $errors['email'] = 'Please enter a valid email address';
        }

        if (!Validation::string($password, 6, 50)) {
            $errors['password'] = 'Password must be at least 6 characters';
        }

        if (!empty($errors)) {
            loadView('users/login', [
                'errors' => $errors,
                'email' => $email,
                'password' => $password,
            ]);
            exit;
        }

        $user = User::where(['email' => $email]);

        if ($user) {
            $user = $user[0];
            if (password_verify($password, $user->password)) {
                // Set user session
                Session::set('user', $user);
                redirect('/users');
                exit;
            }
        }


        $errors['email'] = 'Incorrect credentials';

        loadView('users/login', [
            'errors' => $errors,
        ]);
        exit;
    }

    /**
     * Load edit user view
     *
     * @param array $params
     * @return void
     * @throws Exception
     */
    public function edit(array $params)
    {
        $id = $params['id'] ?? '';

        $user = User::find($id);

        if (!$user) {
            ErrorController::notFound('User not found');
            return;
        }

        loadView('users/edit', [
            'user' => $user
        ]);

    }

    /**
     * Update user
     *
     * @params array params
     * @return void
     * @throws Exception
     */
    public function update($params)
    {
        $id = $params['id'] ?? '';

        $user = User::find($id);

        // Check if user exists
        if (!$user) {
            ErrorController::notFound('User not found');
        }

        $allowedFields = ['name', 'email', 'city', 'state'];

        $updateValues = array_intersect_key($_POST, array_flip($allowedFields));

        $updateValues = array_map('sanitize', $updateValues);

        $requiredFields = ['name', 'email', 'city', 'state'];

        $errors = [];

        foreach ($requiredFields as $field) {
            if (empty($updateValues[$field]) || !Validation::string($updateValues[$field])) {
                $errors[$field] = ucfirst($field) . ' is required';
            }
        }

        if (!empty($errors)) {
            loadView('users/edit', [
                'user' => $user,
                'errors' => $errors
            ]);
            exit;
        } else {
            // Submit to database
            User::update($user->id, $updateValues);

            // Set flash message
            Session::setFlashMessage('success_message', 'User updated successfully.');

            redirect('/users');
        }

    }


    /**
     * Delete resource
     *
     * @params array $params
     * @reutrn void
     */
    public function destroy(array $params)
    {
        $id = $params['id'] ?? '';

        $user = User::find($id);

        if (!$user) {
            loadView('error', [
                'message' => 'User not found',
            ]);
        }

        if (User::delete($user->id)) {
            Session::setFlashMessage('success_message', 'User has been deleted');
            redirect('/users');
        }

        Session::setFlashMessage('success_message', 'User could not be deleted');
        redirect('/users');
    }
}
