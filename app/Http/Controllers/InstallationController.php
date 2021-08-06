<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\InstituteSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

class InstallationController extends Controller
{
    public function installView(Request $request){
        // If user table exist, redirect to success page.
        if(Schema::hasTable('users')){
            return redirect()->route('install.success');
        }else{
            // If admin user not exist, render install main page.
            if(Schema::hasTable('users')){
                if(!User::where('username', 'admin')->first()){
                    return view('install.main');
                }else{
                    return redirect()->route('install.success');
                }
            }else{
                return view('install.main');
            }
        }
    }
    public function installConfigView(Request $request){
        // If user table exist, redirect to success page.
        if(Schema::hasTable('users')){
            return redirect()->route('install.success');
        }else{
            // If admin user not exist, render install main page.
            if(Schema::hasTable('users')){
                if(!User::where('username', 'admin')->first()){
                    return view('install.config');
                }else{
                    return redirect()->route('install.success');
                }
            }else{
                return view('install.config');
            }
        }
    }
    public function installSuccessView(Request $request){
        return view('install.success');
    }
    public function install(Request $request){
        $validated = $request->validate([
            'adminFullName' => 'required',
            'adminEmailAddress' => 'required|email',
            'password' => 'required|confirmed'
        ]);
        $adminFullname = $request->adminFullName;
        $adminEmailAddress = $request->adminEmailAddress;
        $password = $request->password;
        // Create admin user and migrate the database.
        Artisan::call('install', [
            'password' => $password, 'fullname' => $adminFullname, 'email' => $adminEmailAddress
        ]);
        // Return to installation success page.
        return redirect()->route('install.success');
    }
}
