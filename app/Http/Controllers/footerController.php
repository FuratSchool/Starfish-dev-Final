<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class footerController extends Controller
{
    public function registerventure(){
        return View('footer.registerventure');
    }

    public function legal(){
        return view('footer.legal');
    }

    public function faqs(){
        return view('footer.faqs');
    }

    public function partnerhelpcentre(){
        return view('footer.helpcentre');
    }
}
