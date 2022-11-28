<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getHome()
    {
        return view('user/dashboard');
    }

    public function getCanvas()
    {
        return view('user/canvas');
    }

    public function getHistory()
    {
        return view('user/history');
    }
} 
