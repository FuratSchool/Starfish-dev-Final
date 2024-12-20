<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\MessageBag;
use Carbon\Carbon;

/**
 * Class LoginController
 * @package App\Http\Controllers
 */
class LoginController extends Controller {
public function __construct() {
    $this->middleware('guest', ['except' => 'destroy']);
}

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $errors = new MessageBag();
        $username = Input::get('username');
        $password =  Input::get('password');
        $remember = Input::get('remember');
        if(Auth::attempt(['username' => $username, 'password' => $password], $remember)) {
            if(auth()->user()->is_active == 1) {
                activity('auth-log')
                    ->causedBy(auth()->user())
                    ->withProperties(['action' => 'logged in'])
                    ->log('Gebruiker:  '.auth()->user()->username." is ingelogd");

                $groups = auth()->user()->groups()->get(['id']);
                $i = 0;
                foreach ($groups as $group) {
                    if($i === 0) {
                        $request->session()->put('user.groups', [$group->id]);
                        $i = null;
                    } else {
                        $request->session()->push('user.groups', $group->id);
                    }
                }
                $accesses = auth()->user()->access()->get(['route']);
                $i = 0;
                foreach ($accesses as $access) {
                    if($i === 0) {
                        $request->session()->put('user.access', [$access->route]);
                        $i = null;
                    } else {
                        $request->session()->push('user.access', $access->route);
                    }
                }
                return redirect()->intended("/admin");
            } else {
                activity('auth-log')
                    ->causedBy(auth()->user())
                    ->withProperties(['action' => 'login denied'])
                    ->log('Gebruiker:  '.auth()->user()->username." probeerde in te loggen, maar is nog niet geactiveerd");
                $errors->add('unactivated', 'U bent nog niet geactiveerd en heeft nog geen toegang tot het portaal');
                return redirect()->back()->withErrors($errors)->withInput(Input::except('password'));
            }
        }
        $errors->add('password', 'Onbekende combinatie van gebruikersnaam/wachtwoord');
        return redirect()->back()->withErrors($errors)->withInput(Input::except('password'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return void
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $user = User::findOrFail(auth()->user()->id);
        $user->is_online = false;
        $user->save();
        activity('auth-log')
            ->causedBy(auth()->user())
            ->withProperties(['action' => 'logged out'])
            ->log('Gebruiker:  '.auth()->user()->username." is uitgelogd (duur: ". Carbon::now()->diffInMinutes(auth()->user()->last_login)." minuten)");
        auth()->logout();
        $request->session()->flush();
        if(\Session::has('message')) {
            \Session::flash('message', \Session::get('message'));
        }
        return redirect()->route("login");
    }
}
