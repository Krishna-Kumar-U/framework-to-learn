<?php

namespace App\Controllers;

use App\Core\App;

class UsersController
{
    /**
     * Show all users.
     */
    public function index()
    {
        $users = App::get('database')->selectAll('users');

        return view('users', compact('users'));
    }

    /**
     * Store a new user in the database.
     */
    public function store()
    {

        App::get('database')->insert('users', [
            'firstname' => $_POST['firstname'],
            'lastname'  => $_POST['lastname'],
            'email'     => $_POST['email'],
            'password'  => password_hash($_POST['password'], PASSWORD_DEFAULT),
        ]);

        return redirect('users');
    }

    public function show($value='')
    {
        dd('here');
    }
}
