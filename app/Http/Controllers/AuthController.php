<?php

namespace App\Http\Controllers;

use App\Models\user;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use InternalIterator;


class AuthController extends Controller
{
    function regis()
    {
        return view('Auth.register');
    }

    function valiregis(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:Users,email',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'

        ]);

        $user = new user([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),

        ]);
        $user->save();

        return redirect()->route('login')->with('success', 'Registration success. Please login!');
    }
    function login()
    {
        return view('Auth.login');
    }

    function valilogin(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
         If ($request->user()->roles_id==1){
             return redirect()->intended('dashboard');
        }
        If ($request->user()->roles_id==2){
            return redirect()->intended('dashboard');
       }
        If ($request->user()->roles_id==3){
             return redirect()->intended('dashboard');
        }
        }
        return back()->withErrors([
            'email' => 'email dan password salah',
        ])->onlyInput('email');
    }
    function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
    function forgot(){
        return view ('Auth.forgotpassword');
    }
    function forgotpassword(Request $request){
        $request->validate(['email' => 'required|email']);

        $status =Password::SendResetLink(
            $request->only('email')
        );
        return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
    }
    function showresetpassword(Request $request){
        return view('Auth.resetpassword', data:['request' => $request]);
    }
    function resetpassword(Request $request){
        $request->validate([
            'token'=>'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed'
        ]);

        $status = Password::reset
        ($request->only('email', 'password', 'password_confirmation', 'token'),
    function ($user) use ($request) {
        $user->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ])->save();
                event(new PasswordReset($user));

        });
        return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
    }
}

