<?php

namespace App\Http\Controllers\admin;

use App\Models\Wellness;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class wellnessController extends Controller
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
        $wellness = Wellness::query();
        $wellness = $wellness->select('id', 'name', 'short_description', 'updated_at');
        if (isset($_GET['filter_type']) && isset($_GET['q'])) {
            $filter_type = $_GET['filter_type'];
            $q = $_GET['q'];
            $wellness->where($filter_type, "LIKE", "%$q%");
        }
        $wellness = $wellness->orderBy($column, $dir)->paginate('10', ['*'], ' wellness');
        $dir = $dir == 'asc' ? 'desc' : 'asc';
        foreach ($fdir as $key => $value) {
            if ($key == $column) {
                $fdir[$key] = $dir;
            } else {
                $fdir[$value] = 'asc';
            }
        }
        return view('admin.wellness.index', compact('wellness', 'fdir', 'column'));;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        return view('admin.wellness.create');

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

        $wellness = Wellness::create($input);
        return redirect()->route('admin.wellness.show', $wellness->id);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Wellness $wellness
     *
     * @return void
     */
    public function edit(Wellness $wellness)
    {
        return view("admin.wellness.edit", compact('wellness'));
    }

    /**
     * Display the specified resource.
     *
     * @param Wellness $wellness
     *
     * @return void
     */
    public function show(Wellness $wellness)
    {
        return view("admin.wellness.show", compact('wellness'));
    }

    public function update(Request $request, Wellness $wellness)
    {


        $input = array(
            'name' => $request->name,
            'description' => $request->description,
            'short_description' => $request->short_description,
        );

        $wellness->name = $request->name;
        $wellness->description = $request->description;
        $wellness->short_description = $request->short_description;

        $wellness->save();


        \Session::flash("success", "Wellness: " . $wellness->name . " succesvol bijgewerkt");
        return redirect()->route('admin.wellness.show', $wellness);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Wellness $wellness
     *
     * @return void
     */
    public function destroy(Wellness $wellness)
    {
        $name = $wellness->name;
        try {
            $wellness->delete();
        } catch (\Exception $exception) {
            return redirect()->back()->withException($exception);
        }
        activity('comp-log')
            ->causedBy(auth()->user())
            ->performedOn($wellness)
            ->withProperties(['action' => 'destroyed'])
            ->log('Wellness:  ' . $name . ' verwijderd door: ' . auth()->user()->username);
        \Session::flash("success", "Wellness: " . $name . " succesvol verwijderd");

        return redirect()->route("admin.wellness.index");
    }
}
