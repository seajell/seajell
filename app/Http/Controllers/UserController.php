<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\MainController;

class UserController extends MainController
{
    public function loginView(Request $request){
        return view('login')->with(['appVersion' => $this->appVersion, 'apiToken' => $this->apiToken, 'appName' => $this->appName, 'orgName' => $this->orgName]);
    }
    public function userListView(Request $request){
        $users = User::select('id', 'username', 'fullname', 'email', 'role')->paginate(7);
        return view('user.list')->with(['users' => $users, 'appVersion' => $this->appVersion, 'apiToken' => $this->apiToken, 'appName' => $this->appName, 'orgName' => $this->orgName]);
    }
    public function addUserView(Request $request){
        return view('user.add')->with(['appVersion' => $this->appVersion, 'apiToken' => $this->apiToken, 'appName' => $this->appName, 'orgName' => $this->orgName]);
    }
    public function updateUserView(Request $request, $username){
        if(User::where('username', $username)->first()){
            // Only admins or the user that logged in themselves can update their info
            if(Gate::allows('authAdmin') || strtolower($username) == Auth::user()->username){
                // Only the user 'admin' can update their info. Other admins can't update the 'admin' user.
                if($username == 'admin' && Auth::user()->username == 'admin'){
                    $data = User::where('username', $username)->first();
                    return view('user.update')->with(['appVersion' => $this->appVersion, 'apiToken' => $this->apiToken, 'appName' => $this->appName, 'orgName' => $this->orgName, 'data' => $data]);
                }else{
                    abort(403, 'Anda tidak boleh mengakses laman ini.');
                }
            }else{
                abort(403, 'Anda tidak boleh mengakses laman ini.');
            }
        }else{
            abort(404, 'Pengguna tidak dijumpai.');
        }
    }
    /**
     * Login and Logout
     */
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
            ]);
        }
    }

    public function removeUser(Request $request){
        $username = $request->username;
        if($username == 'admin'){
            return back()->withErrors([
                'removeUserError' => 'Pengguna tersebut tidak boleh dibuang!',
            ]);
        }else{
            $user = User::where('username', $username);
            $user->delete();
            $request->session()->flash('removeUserSuccess', 'Pengguna berjaya dibuang!');
            return back();
        }
    }

    public function updateUser(Request $request, $username){
        // Check whether update info or password
        if($request->has('info')){
            $validated = $request->validate([
                'fullname' => ['required'],
                'email' => ['required', 'email:rfc'],
                'identification_number' => ['required', 'numeric'],
                'role' => ['required']
            ]);
            if(User::select('username')->where('username', $request->username)->first()){
                User::updateOrCreate(
                    ['username' => strtolower($request->username)],
                    ['fullname' => strtolower($request->fullname), 'email' => strtolower($request->email), 'identification_number' => $request->identification_number, 'role' => strtolower($request->role)]
                );
                $request->session()->flash('updateUserSuccess', 'Pengguna berjaya dikemas kini!');
                return back();
            }else{
                return back()->withErrors([
                    'userNotExisted' => 'Pengguna tidak dijumpai!',
                ]);
            }
        }elseif($request->has('password-update')){
            $validated = $request->validate([
                'password' => ['required', 'confirmed']
            ]);
            if(User::select('username')->where('username', $request->username)->first()){
                User::updateOrCreate(
                    ['username' => strtolower($request->username)],
                    ['password' => Hash::make($request->password)]
                );
                $request->session()->flash('updateUserPasswordSuccess', 'Kata laluan pengguna berjaya dikemas kini!');
                return back();
            }else{
                return back()->withErrors([
                    'userNotExisted' => 'Pengguna tidak dijumpai!',
                ]);
            }
        }else{
            return back();
        }
        
    }
}
