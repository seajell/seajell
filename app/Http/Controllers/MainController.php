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
use App\Models\SystemSetting;
use App\Models\EmailServiceSettings;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Schema;

class MainController extends Controller
{
    protected $apiToken;
    protected $appName;
    protected $appVersion;
    protected $systemSetting;
    protected $emailServiceSetting;

    public function __construct()
    {
        // Check if system is properly installed. If not redirect to /install route.
        $this->middleware(function ($request, $next) {
            // Check if users table exist
            if (Schema::hasTable('users')) {
                // Check if admin user not exist
                if (!User::where('username', 'admin')->first()) {
                    return redirect()->route('install.view');
                } else {
                    if ($request->session()->has('bearerAPIToken')) {
                        $this->apiToken = $request->session()->get('bearerAPIToken');
                    } else {
                        $this->apiToken = null;
                    }
                    $this->appName = env('APP_NAME', 'SeaJell');
                    $this->appVersion = env('APP_VERSION', 'v2.0.0');
                    $this->systemSetting = SystemSetting::select('id', 'name', 'logo', 'language')->where('id', 1)->first();
                    if (EmailServiceSettings::where('id', 1)->first()) {
                        $this->emailServiceSetting = EmailServiceSettings::where('id', 1)->first();
                    } else {
                        $this->emailServiceSetting = '';
                    }

                    return $next($request);
                }
            } else {
                return redirect()->route('install.view');
            }
        });
    }

    /**
     * Returns an image data URL that's cached.
     *
     * @param string $imagePath
     * @param int $width
     * @param int $height
     *
     * @return mixed
     */
    protected function cacheDataURLImage($imagePath, $width = 300, $height = 300)
    {
        // Check whether a path string is given and not empty
        if (!empty($imagePath)) {
            $imageStoragePath = storage_path('app/public' . $imagePath);
            $dataURLImageCached = Image::cache(function ($image) use ($imageStoragePath, $width, $height) {
                $image->make($imageStoragePath)->resize($width, $height)->encode('data-url');
            }, 10);
        } else {
            $dataURLImageCached = '';
        }

        return $dataURLImageCached;
    }
}
