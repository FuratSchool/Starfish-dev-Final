<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(){
        $articles= Article::paginate(12);
        return View('articles.articles', compact('articles'));
    }
    /**
     * Display the specified resource.
     *
     * @param $name
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::where('name', $id)->firstOrFail();
        return view('articles.article', compact('article'));
    }

}
