<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\MainController;

class CertificateController extends MainController
{
    public function addCertificateView(Request $request){
        return view('certificate.add')->with(['apiToken' => $this->apiToken]);
    }
}