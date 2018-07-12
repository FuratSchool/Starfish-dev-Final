<?php

namespace App\Http\Controllers;

use App\Models\Therapy;

use Illuminate\Http\Request;

class therapycontroller extends Controller
{
    public function index()
    {
        $therapies = Therapy::paginate(12);
        return view('therapies.therapies', compact('therapies'));
    }
    /**
     * @param $name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function show($name)
    {
        $therapy = Therapy::where('name', $name)->firstOrFail();
        return view('therapies.therapy', compact('therapy'));
    }

}
