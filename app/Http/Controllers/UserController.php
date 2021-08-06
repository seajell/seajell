<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MainController;

class UserController extends MainController
{
    public function loginView(Request $request){
        return view('login');
    }
    public function createUserView(Request $request){
        return view('user.create');
    }
    public function login(Request $request){
        if(User::where('username', '=', $request->username)->first()){
            $credentials = $request->validate([
                'username' => ['required'],
                'password' => ['required'],
            ]);
    
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended('');
            }
    
            return back()->withInput()->withErrors([
                'password' => 'Kata laluan salah.',
            ]);
        }else{
            return back()->withInput()->withErrors([
                'username' => 'Pengguna tidak wujud.'
            ]);
        }
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
