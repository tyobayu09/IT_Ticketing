<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = ['title' => 'Welcome to IT Ticketing'];
        return view('welcome', $data);
    }
}