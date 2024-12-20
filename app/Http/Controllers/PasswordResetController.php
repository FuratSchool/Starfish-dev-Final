<?php

namespace App\Http\Controllers;

use App\Notifications\PasswordReset;
use Illuminate\Http\Request;
use App\Models\PasswordReset as ResetEntry;
use App\Models\User;
use Carbon\Carbon;

/**
 * Class PasswordResetController
 * @package App\Http\Controllers
 */
class PasswordResetController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.passwords.email');
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
                'email' => 'required|email|exists:users,email|unique:password_resets,email'
            ], [
                'email.required' => 'Vul een E-Mail adres in',
                'email.email' => 'Vul een geldig emaildres in',
                'email.unique' => 'Er is al een verzoek naar dit email adres gestuurd',
                'email.exists' => 'Het ingevoerde emailadres komt niet voor in onze gegevens, weetje zeker dat dit het juist email adres is?'
            ]);

            $user  = User::where('email', $request->email)->first();
            $token = str_random(32);

            $reset = ResetEntry::create([
                'email' => $user->email,
                'token' => $token,
                'created_at' => Carbon::now()
                ]);

            $user->notify(new PasswordReset($reset, $user));
            $email = $user->email;
            activity('auth-log')
                ->causedBy($user)
                ->withProperties(['action' => 'forgot-password'])
                ->log('Gebruiker:  '.$user->username.' heeft een verzoek gedaan om zijn wachtwoord te wijzigen');
            return view('auth.passwords.sent', compact('email'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $token
     * @return \Illuminate\Http\Response
     */
    public function edit($token)
    {
        $entry =ResetEntry::where('token', $token)->first();
        $created = Carbon::createFromFormat('Y-m-d H:i:s', $entry->created_at);
        $expiration = Carbon::createFromFormat('Y-m-d H:i:s', $entry->created_at);
        $expiration = $expiration->addDay(1);
        $curtime = Carbon::now();
        if($curtime->between($created, $expiration)) {
            $user = User::where('email', $entry->email)->first();
            return view('auth.passwords.reset', compact('user'));
        } else {
            return view('auth.passwords.expired');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'password' => array(
                'required',
                'confirmed',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/'
            ),
        ], [
            'password.required' => 'Kies een wachtwoord',
            'password.confirmed' => 'De wachtwoorden komen niet overeen',
            'password.regex' => 'Het wachtwoord moet minimaal 1 letter, 1 hoofdletter en 1 cijfer bevatten',
            'password.min' => 'Het wachtwoord is tekort gebruik minimaal 8 tekens',
        ]);
        $user = User::find($id);
        $entry = ResetEntry::where('email', $user->email)->first();
        $entry->delete();
        $user->password = bcrypt($request->password);
        $user->save();
        activity('auth-log')
            ->causedBy($user)
            ->withProperties(['action' => 'reset-password'])
            ->log('Gebruiker:  '.$user->username.' heeft zijn wachtwoord gewijzigd');
        return view('auth.passwords.success');
    }
}
