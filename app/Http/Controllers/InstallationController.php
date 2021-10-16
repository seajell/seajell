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

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\SystemSetting;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class InstallationController extends Controller
{
    public function installView()
    {
        // If user table exist, redirect to success page.
        if (Schema::hasTable('users')) {
            return redirect()->route('install.success');
        } else {
            // If admin user not exist, render install main page.
            if (Schema::hasTable('users')) {
                if (!User::where('username', 'admin')->first()) {
                    return view('install.main');
                } else {
                    return redirect()->route('install.success');
                }
            } else {
                return view('install.main');
            }
        }
    }

    public function installConfigView()
    {
        // If user table exist, redirect to success page.
        if (Schema::hasTable('users')) {
            return redirect()->route('install.success');
        } else {
            // If admin user not exist, render install main page.
            if (Schema::hasTable('users')) {
                if (!User::where('username', 'admin')->first()) {
                    return view('install.config');
                } else {
                    return redirect()->route('install.success');
                }
            } else {
                return view('install.config');
            }
        }
    }

    public function installSuccessView()
    {
        return view('install.success');
    }

    public function install(Request $request)
    {
        $validated = $request->validate([
            'adminFullName' => 'required',
            'adminEmailAddress' => 'required|email',
            'password' => 'required|confirmed',
            'system-name' => ['required'],
            'system-language' => ['required'],
            'system-logo' => ['required', 'image', 'mimes:png'],
        ]);
        $adminFullname = $request->adminFullName;
        $adminEmailAddress = $request->adminEmailAddress;
        $password = $request->password;
        $systemName = $request->input('system-name');
        $systemLanguage = $request->input('system-language');
        $systemLogo = $request->file('system-logo');

        if ($request->hasFile('system-logo')) {
            $systemLogoName = $request->file('system-logo')->getClientOriginalName();
            $systemLogoImage = Image::make($request->file('system-logo'))->resize(300, 300)->encode('png');
            $systemLogoSavePath = '/img/system/logo/' . Carbon::now()->timestamp . '-' . $systemLogoName;
            Storage::disk('public')->put($systemLogoSavePath, $systemLogoImage);
        } else {
            $systemLogoSavePath = $systemSetting = SystemSetting::where('id', 1)->first()->logo;
        }

        // Create admin user and migrate the database.
        Artisan::call('install', [
            'password' => $password, 'fullname' => $adminFullname, 'email' => $adminEmailAddress,
        ]);

        SystemSetting::upsert([
            [
                'id' => 1,
                'name' => strtolower($systemName),
                'logo' => $systemLogoSavePath,
                'language' => $systemLanguage,
            ],
        ], ['id'], ['name', 'logo', 'language']);

        // Return to installation success page.
        return redirect()->route('install.success');
    }
}
