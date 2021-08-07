<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\MainController;

class HomeController extends MainController
{
    public function view(Request $request){
        return view('home')->with(['apiToken' => $this->apiToken]);
    }
}
