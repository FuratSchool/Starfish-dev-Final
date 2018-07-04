<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Specialist;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

/**
 * Class SpecialistController
 * @package App\Http\Controllers
 */
class SpecialistController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showListPage(){
        $categories = Category::whereNull('parent')->get();
        return view('specialists', compact('categories'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
    $specs = Specialist::paginate(12);
    return view('search.specialistList', compact('specs'));
}

    /**
     * @param $name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function show($name)
    {
        try {
            $spec = Specialist::where('is_anonymous', '0')->where('url_name', $name)->firstOrFail();
            return view('specialists.specialist', compact('spec'), array('title' => 'Starfish - '.$spec->name));
        } catch(ModelNotFoundException $e){
            return redirect(route('listSpecialists'));
        }
    }
}
