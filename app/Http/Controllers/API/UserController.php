<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function getUserByUsername(Request $request, $username){
        if($username == 'empty-value'){
            return response()->json([
                'Empty_Err' => 'Empty username given!'
            ]);
        }else{
            $user = User::select('fullname', 'identification_number')->where('username', $username)->first();
            if($user){
                return response()->json([
                    'fullname' => $user->fullname,
                    'identification_number' => $user->identification_number
                ]);
            }else{
                return response()->json([
                    'NotFound_Err' => 'User not found!'
                ]);
            }
        }
    }
}
