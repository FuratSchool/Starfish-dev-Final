<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class healthController extends Controller
{
    public function index(){
        return view('health.health');
    }
}
