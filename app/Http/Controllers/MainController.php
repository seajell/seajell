<?php
// Copyright (c) 2021 Muhammad Hanis Irfan bin Mohd Zaid

// This file is part of SeaJell.

// SeaJell is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

// SeaJell is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.

// You should have received a copy of the GNU General Public License
// along with SeaJell.  If not, see <https://www.gnu.org/licenses/>.

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
