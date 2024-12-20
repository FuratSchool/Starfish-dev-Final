<?php

namespace App\Http\Controllers\Admin;

use App\Models\Therapy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class TherapyController
 * @package App\Http\Controllers\Admin
 */
class TherapyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        $fdir = [
            'id' =>  'asc',
            'name' => 'asc',
            'short_description' => 'asc',
            'updated_at' => 'asc',
        ];
        $column = isset($_GET['order']) ? $_GET['order'] : "id";
        if(isset($_GET['dir'])) {
            $dir = $_GET['dir'];
        } else {
            $dir = 'asc';
        }
        $therapies = Therapy::query();
        $therapies = $therapies->select('id', 'name', 'short_description', 'updated_at');
        if(isset($_GET['filter_type']) && isset($_GET['q'])) {
            $filter_type = $_GET['filter_type'];
            $q =  $_GET['q'];
            $therapies->where($filter_type, "LIKE", "%$q%");
        }
        $therapies = $therapies->orderBy($column, $dir)->paginate('10', ['*'], 'therapies');
        $dir =  $dir == 'asc' ? 'desc' : 'asc';
        foreach ($fdir as $key=>$value) {
            if($key == $column) {
                $fdir[ $key] = $dir;
            } else {
                $fdir[$value] = 'asc';
            }
        }
        return view('admin.therapies.index', compact('therapies' , 'fdir', 'column'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        return view('admin.therapies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => "required",
            'description' => "required",
            'short_description' => "required",
        ]);

        $therapy = Therapy::create([
            "name" => $request->name,
            "description" => $request->description,
            "short_description" => $request->short_description,
        ]);

        activity('ther-log')
            ->causedBy(auth()->user())
            ->performedOn($therapy)
            ->withProperties(['action' => 'created'])
            ->log('Therapie:  '.$therapy->name.' aangemaakt door:'.auth()->user()->username);
        \Session::flash("success", "Therapie: ".$therapy->name." succesvol aangemaakt");
        return redirect()->route('admin.therapies.show', $therapy->id);
    }

    /**
     * Display the specified resource.
     *
     * @param Therapy $therapy
     *
     * @return void
     */
    public function show(Therapy $therapy)
    {
        return view("admin.therapies.show", compact('therapy'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Therapy $therapy
     *
     * @return void
     */
    public function edit(Therapy $therapy)
    {
        return view("admin.therapies.edit", compact('therapy'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Therapy                   $therapy
     *
     * @return void
     */
    public function update(Request $request, Therapy $therapy)
    {
        $this->validate($request, [
            'name' => "required",
            'description' => "required",
            'short_description' => "required",
        ]);

        $therapy->name = $request->name;
        $therapy->description = $request->description;
        $therapy->short_description = $request->short_description;
        $therapy->save();

        activity('ther-log')
            ->causedBy(auth()->user())
            ->performedOn($therapy)
            ->withProperties(['action' => 'updated'])
            ->log('Therapie:  '.$therapy->name.' bijgewerkt door:'.auth()->user()->username);
        \Session::flash("success", "Therapie: ".$therapy->name." succesvol bijgewerkt");
        return redirect()->route('admin.therapies.show', $therapy);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Therapy $therapy
     *
     * @return void
     */
    public function destroy(Therapy $therapy)
    {
        $name = $therapy->name;
        try {
            $therapy->delete();
        } catch (\Exception $exception) {
            return redirect()->back()->withException($exception);
        }
        activity('ther-log')
            ->causedBy(auth()->user())
            ->performedOn($therapy)
            ->withProperties(['action' => 'destroyed'])
            ->log('Therapie:  '.$name.' verwijderd door: '.auth()->user()->username);
        \Session::flash("success", "Therapie: ".$name." succesvol verwijderd");

        return redirect()->route("admin.therapies.index");
    }
}
