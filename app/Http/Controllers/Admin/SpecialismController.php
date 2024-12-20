<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Specialism;

/**
 * Class SpecialismController
 * @package App\Http\Controllers\Admin
 */
class SpecialismController extends Controller
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
        $specialisms = Specialism::query();
        $specialisms = $specialisms->select('id', 'name', 'short_description', 'updated_at');
        if(isset($_GET['filter_type']) && isset($_GET['q'])) {
            $filter_type = $_GET['filter_type'];
            $q =  $_GET['q'];
            $specialisms->where($filter_type, "LIKE", "%$q%");
        }
        $specialisms = $specialisms->orderBy($column, $dir)->paginate('10', ['*'], 'specialisms');
        $dir =  $dir == 'asc' ? 'desc' : 'asc';
        foreach ($fdir as $key=>$value) {
            if($key == $column) {
                $fdir[ $key] = $dir;
            } else {
                $fdir[$value] = 'asc';
            }
        }
        return view('admin.specialisms.index', compact('specialisms' , 'fdir', 'column'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        return view('admin.specialisms.create');
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

        $spec = Specialism::create([
            "name" => $request->name,
            "description" => $request->description,
            "short_description" => $request->short_description,
        ]);

        activity('speci-log')
            ->causedBy(auth()->user())
            ->performedOn($spec)
            ->withProperties(['action' => 'created'])
            ->log('Werkgebied:  '.$spec->name.' aangemaakt door:'.auth()->user()->username);
        \Session::flash("success", "Werkgebied: ".$spec->name." succesvol aangemaakt");
        return redirect()->route('admin.specialisms.show', $spec->id);
    }

    /**
     * Display the specified resource.
     *
     * @param Specialism $specialism
     *
     * @return void
     */
    public function show(Specialism $specialism)
    {
        return view("admin.specialisms.show", compact('specialism'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Specialism $specialism
     *
     * @return void
     */
    public function edit(Specialism $specialism)
    {
        return view("admin.specialisms.edit", compact('specialism'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Specialism                $specialism
     *
     * @return void
     */
    public function update(Request $request, Specialism $specialism)
    {
        $this->validate($request, [
            'name' => "required",
            'description' => "required",
            'short_description' => "required",
        ]);

        $specialism->name = $request->name;
        $specialism->description = $request->description;
        $specialism->short_description = $request->short_description;
        $specialism->save();

        activity('speci-log')
            ->causedBy(auth()->user())
            ->performedOn($specialism)
            ->withProperties(['action' => 'updated'])
            ->log('Werkgebied:  '.$specialism->name.' bijgewerkt door:'.auth()->user()->username);
        \Session::flash("success", "Werkgebied: ".$specialism->name." succesvol bijgewerkt");
        return redirect()->route('admin.specialisms.show', $specialism);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Specialism $specialism
     *
     * @return void
     */
    public function destroy(Specialism $specialism)
    {
        $name = $specialism->name;
        try {
            $specialism->delete();
        } catch (\Exception $exception) {
            return redirect()->back()->withException($exception);
        }
        activity('speci-log')
            ->causedBy(auth()->user())
            ->performedOn($specialism)
            ->withProperties(['action' => 'destroyed'])
            ->log('Werkgebied:  '.$name.' verwijderd door: '.auth()->user()->username);
        \Session::flash("success", "Werkgebied: ".$name." succesvol verwijderd");

        return redirect()->route("admin.specialisms.index");
    }
}
