<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class philosophyController extends Controller
{
    public function index(){
        return view('philosophy.philosophy');
    }
}
