<?php

namespace App\Controllers;

class PagesController
{
    /**
     * Show the home page.
     */
    public function home()
    {
        return view('index');
    }

    /**
     * Show the about page.
     */
    public function about()
    {
        $me = 'developer';

        return view('about', ['developer' => $me]);
    }

    /**
     * Show the contact page.
     */
    public function contact()
    {
        return view('contact');
    }
}
