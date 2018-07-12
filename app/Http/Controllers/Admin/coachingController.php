<?php

namespace App\Http\Controllers\admin;

use App\Models\Coaching;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class coachingController extends Controller
{
    public function index(){
        $fdir = [
            'id' => 'asc',
            'name' => 'asc',
            'short_description' => 'asc',
            'updated_at' => 'asc'
        ];
        $column = isset($_GET['order']) ? $_GET['order'] : "id";
        if (isset($_GET['dir'])) {
            $dir = $_GET['dir'];
        } else {
            $dir = 'asc';
        }
        $coaching = Coaching::query();
        $coaching = $coaching->select('id', 'name', 'short_description', 'updated_at');
        if (isset($_GET['filter_type']) && isset($_GET['q'])) {
            $filter_type = $_GET['filter_type'];
            $q = $_GET['q'];
            $coaching->where($filter_type, "LIKE", "%$q%");
        }
        $coaching = $coaching->orderBy($column, $dir)->paginate('10', ['*'], 'coaching');
        $dir = $dir == 'asc' ? 'desc' : 'asc';
        foreach ($fdir as $key => $value) {
            if ($key == $column) {
                $fdir[$key] = $dir;
            } else {
                $fdir[$value] = 'asc';
            }
        }
        return view('admin.coaching.index', compact('coaching', 'fdir', 'column'));;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        return view('admin.coaching.create');

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
            'name' => $request->name,
            'description' => $request->description,
            'short_description' => $request->short_description,
        );

        $coaching = Coaching::create($input);
        return redirect()->route('admin.coaching.show', $coaching->id);
    }

    /**
     * Display the specified resource.
     *
     * @param Complaint $complaint
     *
     * @return void
     */
    public function show(Coaching $coaching)
    {
        return view("admin.coaching.show", compact('coaching'));

    }
}
