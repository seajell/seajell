<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\MainController;

class HomeController extends MainController
{
    public function view(Request $request){
        return view('home')->with(['apiToken' => $this->apiToken, 'appName' => $this->appName, 'orgName' => $this->orgName]);
    }

    public function signature(Request $request){
        return view('signature')->with(['apiToken' => $this->apiToken, 'appName' => $this->appName, 'orgName' => $this->orgName]);
    }
}
