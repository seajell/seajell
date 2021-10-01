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

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function getUserByUsername(Request $request, $username)
    {
        if ('empty-value' == $username) {
            return response()->json([
                'Empty_Err' => 'Empty username given!',
            ]);
        } else {
            $user = User::select('fullname', 'identification_number')->where('username', $username)->first();
            if ($user) {
                return response()->json([
                    'fullname' => $user->fullname,
                    'identification_number' => $user->identification_number,
                ]);
            } else {
                return response()->json([
                    'NotFound_Err' => 'User not found!',
                ]);
            }
        }
    }
}
