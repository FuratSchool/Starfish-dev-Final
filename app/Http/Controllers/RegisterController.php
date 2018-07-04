<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

/**
 * Class RegisterController
 * @package App\Http\Controllers
 */
class RegisterController extends Controller
{
    public function __construct(){
        $this->middleware('guest');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() {
        return view('register');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
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
            'is_admin' => 'required'
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
            'is_admin' => $request->is_admin
        ]);
        \Session::flash('success', 'Gebruiker aangemaakt');
        return redirect()->route('admin.umgmt.index');
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
     * @param  int $id
     * @return void
     */
    public function destroy($id)
    {
        //
    }
}
