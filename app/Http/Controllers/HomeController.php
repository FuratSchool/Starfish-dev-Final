<?php

namespace App\Http\Controllers;

use App\Models\Specialist;
use App\Models\Article;




/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function landing(){
        $articles = Article::paginate(12);
        $specs = Specialist::paginate(2);

        return view('landing', compact('articles', 'specs'));

    }
}
