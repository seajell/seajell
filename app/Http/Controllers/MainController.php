<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class MainController extends Controller
{
    protected $apiToken;
    protected $appName;
    protected $appVersion;
    protected $orgName;
    public function __construct()
    {
        // Check if system is properly installed. If not redirect to /install route.
        $this->middleware(function ($request, $next) {
            $this->appName = env('APP_NAME', 'SeaJell');
            $this->appVersion = env('APP_VERSION', 'v1.0.0');
            $this->orgName = env('ORG_NAME', 'SeaJell');
            // Check if users table exist
            if(Schema::hasTable('users')){
                // Check if admin user not exist
                if(!User::where('username', 'admin')->first()){
                    return redirect()->route('install.view');
                }else{       
                    if ($request->session()->has('bearerAPIToken')) {

                        $this->apiToken = $request->session()->get('bearerAPIToken');
                    }else{
                        $this->apiToken = NULL;
                    }
                    return $next($request);
                }
            }else{
                return redirect()->route('install.view');
            }
        });
    }
}
