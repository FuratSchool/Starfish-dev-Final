<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Task;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

/**
 * Class UserController
 * @package App\Http\Controllers\Admin
 */
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
                $fdir = [
                    'id' =>  'asc',
                    'username' => 'asc',
                    'first_name' => 'asc',
                    'sur_name' => 'asc',
                    'email' => 'asc',
                    'status' => 'asc',
                    'LOA' => 'asc',
                    'updated_at' => 'asc',
             ];
            $column = isset($_GET['order']) ? $_GET['order'] : "id";
            if(isset($_GET['dir'])) {
                $dir = $_GET['dir'];
            } else {
                $dir = 'asc';
            }
        $users = User::query();
        $users = $users->select('id', 'username', 'first_name', 'sur_name', 'email', 'is_active AS status' ,'is_admin AS LOA' , 'is_online', 'last_login', 'notice')->where('deleted_at', "=", null);
        if(isset($_GET['filter_type']) && isset($_GET['q'])) {
                $filter_type = $_GET['filter_type'];
                $q =  $_GET['q'];
                switch ($filter_type) {
                    case 'status':
                        $filter_type = 'is_active';
                        break;
                    case 'LOA':
                        $filter_type = 'is_admin';
                        break;
                    case 'online':
                        $filter_type = 'is_online';
                        break;
                }
                $users->where($filter_type, $q);
        }
        $users = $users->orderBy($column, $dir)->paginate('10', ['*'], 'users');
        $dir =  $dir == 'asc' ? 'desc' : 'asc';
        foreach ($fdir as $key=>$value) {
                if($key == $column) {
                   $fdir[ $key] = $dir;
                } else {
                    $fdir[$value] = 'asc';
                }
            }
         $deletedUsers = User::onlyTrashed()->select('id', 'username', 'first_name', 'sur_name', 'email', 'is_active AS status' ,'is_admin AS LOA' , 'notice', 'deleted_at')->orderBy('deleted_at', 'desc')->paginate('10',['*'], 'deletedUsers');
        return view('admin.users.index', compact('users', 'deletedUsers', 'fdir', 'column'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'username' => 'required|min:3|max:32|unique:users',
            'password' => array(
                'required',
                'confirmed',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/'
            ),
            'email' => 'required|email|unique:users',
            'first_name' => 'required' ,
            'sur_name' => 'required',
        ], [
            'username.required' => 'Vul een gebruikersnaam in',
            'username.unique' => 'Deze gebruikersnaam is bezet',
            'username.min' => 'Gebruikersnaam is de kort, gebruik minimaal 3 tekens',
            'username.max' => 'Gebruikersnaam mag maximaal 32 tekens bevatten',
            'password.required' => 'Kies een wachtwoord',
            'password.confirmed' => 'De wachtwoorden komen niet overeen',
            'password.regex' => 'Het wachtwoord moet minimaal 1 letter, 1 hoofdletter en 1 cijfer bevatten',
            'password.min' => 'Het wachtwoord is tekort gebruik minimaal 8 tekens',
            'email.required' => 'Vul een E-Mail adres in',
            'email.email' => 'Vul een geldig emaildres in',
            'email.unique' => 'Email is al in gebruik',
            'first_name.required' => 'Vul een voornaam in',
            'last_name.required' => 'Vul een achternaam in',
        ]);
        $user = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'first_name' => $request->first_name,
            'sur_name' => $request->sur_name,
            'email' => $request->email,
            'is_admin' => $request->is_admin,
            'notice' => $request->notice,
        ]);

        $user->attachDefaults();

        activity('user-log')
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->withProperties(['action' => 'created'])
            ->log('Gebruiker:  '.$user->username.' aangemaakt door:'.auth()->user()->username);
        \Session::flash('success', "Gebruiker $user->username is aangemaakt, vergeet niet de <a href='".route("admin.umgmt.access", $user->id)."'>Toegang</a> in te stellen");
        return redirect()->route('admin.umgmt.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $userlog = Activity::CausedBy($user)->orWhere('subject_id' , $user->id)->where('subject_type', 'users')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users.show', compact("user", "userlog"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->first_name = $request->first_name ?: $user->first_name;
        $user->sur_name = $request->sur_name ?: $user->sur_name;
        $user->is_admin = $request->is_admin ?: $user->is_admin;
        $user->notice = $request->notice ?: $user->notice;
        if($user->save()) {
            activity('user-log')
                ->causedBy(auth()->user())
                ->performedOn($user)
                ->withProperties(['action' => 'updated'])
                ->log('Gebruiker:  '.$user->username.' bewerkt door: '.auth()->user()->username);
            \Session::flash('success', 'Gebruiker succesvol bewerkt');
            return redirect()->route('admin.umgmt.show', $id);
        } else {
            \Session::flash('error', 'Gebruiker niet bewerkt');
            return redirect()->back()->withInput();
        }



    }

    /**
     * Destroy the specified resource
     *
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        activity('user-log')
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->withProperties(['action' => 'destroyed'])
            ->log('Gebruiker:  '.$user->username.' verwijderd door: '.auth()->user()->username);
        try {
            $user->delete();
        } catch (\Exception $exception) {
            return redirect()->back()->withException($exception);
        }
        \Session::flash('success', 'Gebruiker: '.$user->username.' verwijderd');
        return redirect()->back();
    }

    /**
     * Restore a delete user to it's former glory
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id) {
        $user = User::withTrashed()->find($id);
        $user->restore();
        activity('user-log')
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->withProperties(['action' => 'restored'])
            ->log('Gebruiker:  '.$user->username.' hersteld door: '.auth()->user()->username);
        \Session::flash('success', 'Gebruiker: '.$user->username.' hersteld');
        return redirect()->back();
    }

    /**
     * Access the view where the users access can be edited
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public  function access(User $user) {
        return view('admin.users.access', compact('user'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAccess(Request $request, User $user) {
        $access = $request->access;
        if($user->access()->sync($access)) {
            activity('access-log')
                ->causedBy(auth()->user())
                ->performedOn($user)
                ->withProperties(['action' => 'changed'])
                ->log('Toegang voor:  '.$user->username.' gewijzigd door: '.auth()->user()->username);
            \Session::flash('succes', 'Toegang voor gebruik bewerkt');
            return redirect()->route('admin.umgmt.show', $user);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activate(User $user) {
        $user->is_active = 1;
        $user->save();
        activity('user-log')
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->withProperties(['action' => 'activated'])
            ->log('Gebruiker:  '.$user->username.' geactiveerd door: '.auth()->user()->username);
        \Session::flash('success', 'Gebruiker geactiveerd');
        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deactivate(User $user) {
        $user->is_active = 0;
        $user->save();
        activity('user-log')
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->withProperties(['action' => 'deactivated'])
            ->log('Gebruiker:  '.$user->username.' gede-activeerd door: '.auth()->user()->username);
        \Session::flash('success', 'Gebruiker gede-activeerd');
        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forget($id) {
        $user = User::withTrashed()->find($id);
        $user->messages_sent()->forceDelete();
        $user->messages_recieved()->forceDelete();
        $user->tasks()->delete();
        $user->access()->detach();
        $user->groups()->detach();

        $user->forceDelete();

        activity('user-log')
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->withProperties(['action' => 'forgotten'])
            ->log('Gebruiker:  '.$user->username.' permanent verwijderd door: '.auth()->user()->username);
        \Session::flash('success', 'Gebruiker vergeten');
        return redirect()->route('admin.umgmt.index');
    }
}
