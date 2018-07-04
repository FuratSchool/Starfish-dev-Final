<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class GroupController
 * @package App\Http\Controllers
 */
class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $usergroups = Group::withCount('users')->whereIn('id', \Session::get('user.groups'))->paginate("10", ['*'], 'groepen-gebruiker');
        $groups = Group::withCount('users')->paginate("10", ['*'], 'groepen');
        return view('admin.groups.index', compact('groups', 'usergroups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('admin.groups.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'members' => 'array|distinct'
        ]);

        $group = Group::create([
            'name' => $request->name
        ]);

        $group->users()->attach($request->members);
        activity('group-log')
            ->causedBy(auth()->user())
            ->performedOn($group)
            ->withProperties(['action' => 'created'])
            ->log('Groep:  '.$group->naam.' aangamaakt door:'.auth()->user()->username);
        \Session::flash("success", "Groep: ".$group->name." succesvol aangemaakt");
        return redirect()->route('admin.groups.show', $group);

    }

    /**
     * Display the specified resource.
     *
     * @param Group $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        $messages = $group->messages()->latest()->get();
        $tasks = $group->tasks()->latest()->get();
        return view('admin.groups.show', compact('group', 'messages', 'tasks'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        $users = User::all();
        return view('admin.groups.edit', compact('group', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $this->validate($request, [
            'name' => 'required',
            'members' => 'array|distinct'
        ]);

        $group->name = $request->name;
        $group->save();

        $group->users()->sync($request->members);
        activity('group-log')
            ->causedBy(auth()->user())
            ->performedOn($group)
            ->withProperties(['action' => 'updated'])
            ->log('Groep:  '.$group->naam.' bewerkt door:'.auth()->user()->username);
        return redirect()->route('admin.groups.show', $group);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group $group
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Group $group)
    {
        $group->users()->detach();
        $group->delete();
        activity('group-log')
            ->causedBy(auth()->user())
            ->performedOn($group)
            ->withProperties(['action' => 'destroyed'])
            ->log('Groep:  '.$group->naam.' verwijderd door:'.auth()->user()->username);
        return redirect()->route('admin.groups.index');
    }

}
