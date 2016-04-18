<?php

namespace App\Http\Controllers;

use App\Homepage;
use App\Http\Requests;

class WelcomeController extends Controller
{
    public function index()
    {
        $homepage = new Homepage();
        return view('welcome', ['homepage' => $homepage]);
    }
}
