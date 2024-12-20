<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;


/**
 * Class AdminController
 * @package App\Http\Controllers\Admin
 */
class AdminController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(){
        return view('admin.home');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function settings() {
        return view('admin.settings');
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function storeSettings(Request $request) {
        $user = User::findOrFail(Auth::user()->id);
        $validator = Validator::make($request->all(), [
            'oldPassword' => 'required_with:newPassword|min:8',
            'newPassword' => array(
                'required',
                'confirmed',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/'
            ),
        ]);
        if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
        } else {
                if (Hash::check($request->oldPassword, $user->password)) {
                    try {
                        $user->fill([
                            'password' => Hash::make($request->newPassword)
                        ])->save();
                        \Session::flash('message', "Wachtwoord succesvol gewijzigd");
                        return redirect()->route("logout");
                    } catch(\Exception $exception) {
                        echo $exception->getMessage();
                    }
                } else {
                    \Session::flash('error', 'Uw huidige wachtwoord is onjuist');
                    return redirect()->back();
                }
        }
    }
}
