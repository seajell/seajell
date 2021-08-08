<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\MainController;

class UserController extends MainController
{
    public function loginView(Request $request){
        return view('login');
    }
    public function userListView(Request $request){
        $users = User::select('id', 'username', 'fullname', 'email', 'role')->paginate(7);
        return view('user.list')->with(['users' => $users, 'apiToken' => $this->apiToken, 'appName' => $this->appName, 'orgName' => $this->orgName]);
    }
    public function addUserView(Request $request){
        return view('user.add')->with(['apiToken' => $this->apiToken, 'appName' => $this->appName, 'orgName' => $this->orgName]);
    }
    public function login(Request $request){
        $username = strtolower($request->username);
        if(User::where('username', '=', $request->username)->first()){
            $credentials = $request->validate([
                'username' => ['required'],
                'password' => ['required'],
            ]);
    
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                $id = User::select('id')->where('username', '=', $username)->first()->id;
                $user = User::find($id);
                $token = $user->createToken('apitoken');
                // Add Bearer API Token to session
                $request->session()->put('bearerAPIToken', $token->plainTextToken);
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
        if(auth()->user()->tokens() != NULL){
            auth()->user()->tokens()->delete();
        }
        // Remove Bearer API Token from session
        if ($request->session()->has('bearerAPIToken')) {
            $request->session()->forget('bearerAPIToken');
        }
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function addUser(Request $request){
        $validated = $request->validate([
            'username' => ['required'],
            'fullname' => ['required'],
            'email' => ['required', 'email:rfc'],
            'password' => ['required', 'confirmed'],
            'identification_number' => ['required', 'numeric'],
            'role' => ['required']
        ]);
        if(!User::select('username')->where('username', $request->username)->first()){
            User::updateOrCreate(
                ['username' => strtolower($request->username)],
                ['fullname' => strtolower($request->fullname), 'email' => strtolower($request->email), 'password' => Hash::make($request->password), 'identification_number' => $request->identification_number, 'role' => strtolower($request->role)]
            );
            $request->session()->flash('addUserSuccess', 'Pengguna berjaya ditambah!');
            return back();
        }else{
            return back()->withErrors([
                'userExisted' => 'Pengguna telah wujud!',
            ]);return back();
        }
    }
}
