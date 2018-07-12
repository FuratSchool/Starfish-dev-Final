<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class receptController extends Controller
{
    public function index(){
        $recipes= Recipe::paginate(12);
        return View('recipes.recipes', compact('recipes'));
    }
    /**
     * Display the specified resource.
     *
     * @param $name
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $recipe = Recipe::where('name', $id)->firstOrFail();
        return view('recipes.recipe', compact('recipe'));
    }
}
