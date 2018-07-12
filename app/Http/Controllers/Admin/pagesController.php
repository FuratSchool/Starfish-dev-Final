<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Pages;
use Illuminate\Http\Request;

class pagesController extends Controller {

    public function index(){
        $fdir = [
            'id' => 'asc',
            'title' => 'asc',
            'short_description' => 'asc',
            'body' => 'asc',
            'updated_at' => 'asc'
        ];
        $column = isset($_GET['order']) ? $_GET['order'] : "id";
        if (isset($_GET['dir'])) {
            $dir = $_GET['dir'];
        } else {
            $dir = 'asc';
        }
        $pages = Pages::query();
        $pages = $pages->select('id', 'title', 'short_description', 'body', 'updated_at');
        if (isset($_GET['filter_type']) && isset($_GET['q'])) {
            $filter_type = $_GET['filter_type'];
            $q = $_GET['q'];
            $pages->where($filter_type, "LIKE", "%$q%");
        }
        $pages = $pages->orderBy($column, $dir)->paginate('10', ['*'], 'pages');
        $dir = $dir == 'asc' ? 'desc' : 'asc';
        foreach ($fdir as $key => $value) {
            if ($key == $column) {
                $fdir[$key] = $dir;
            } else {
                $fdir[$value] = 'asc';
            }
        }
        return view('admin.pages.index', compact('pages', 'fdir', 'column'));;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        return view('admin.pages.create');

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function store(Request $request)
    {

        $input = array(
            'title' => $request->title,
            'short_description' => $request->short_description,
            'body' => $request->body,
        );

        $pages = Pages::create($input);

        return redirect()->route('admin.pages.show', $pages->id);
    }

    /**
     * Display the specified resource.
     *
     * @param Pages $pages
     * @return void
     */
    public function show(Pages $pages)
    {
        return view("admin.pages.show", compact('pages'));

    }
}
