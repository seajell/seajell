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
use Illuminate\Http\Request;
use App\Models\SystemSetting;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class SystemController extends MainController
{
    public function systemView(Request $request)
    {
        $systemSetting = SystemSetting::where('id', 1)->first();

        return view('system.update')->with(['appVersion' => $this->appVersion, 'apiToken' => $this->apiToken, 'appName' => $this->appName, 'systemSetting' => $this->systemSetting]);
    }

    public function systemUpdate(Request $request)
    {
        $validated = $request->validate([
            'system-name' => ['required'],
            'system-language' => ['required'],
            'system-logo' => ['image', 'mimes:png'],
        ]);
        $systemName = $request->input('system-name');
        $systemLanguage = $request->input('system-language');
        $systemLogo = $request->file('system-logo');

        if ($request->hasFile('system-logo')) {
            // Deletes old
            if (!empty($systemSetting = SystemSetting::where('id', 1)->first()->logo)) {
                $oldImage = $systemSetting = SystemSetting::where('id', 1)->first()->logo;
                if (Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
                $systemLogoName = $request->file('system-logo')->getClientOriginalName();
                $systemLogoImage = Image::make($request->file('system-logo'))->resize(300, 300)->encode('png');
                $systemLogoSavePath = '/img/system/logo/' . Carbon::now()->timestamp . '-' . $systemLogoName;
                Storage::disk('public')->put($systemLogoSavePath, $systemLogoImage);
            } else {
                $systemLogoSavePath = $systemSetting = SystemSetting::where('id', 1)->first()->logo;
            }
            $systemLogoName = $request->file('system-logo')->getClientOriginalName();
            $systemLogoImage = Image::make($request->file('system-logo'))->resize(300, 300)->encode('png');
            $systemLogoSavePath = '/img/system/logo/' . Carbon::now()->timestamp . '-' . $systemLogoName;
            Storage::disk('public')->put($systemLogoSavePath, $systemLogoImage);
        } else {
            $systemLogoSavePath = $systemSetting = SystemSetting::where('id', 1)->first()->logo;
        }

        SystemSetting::upsert([
            [
                'id' => 1,
                'name' => strtolower($systemName),
                'logo' => $systemLogoSavePath,
                'language' => $systemLanguage,
            ],
        ], ['id'], ['name', 'logo', 'language']);

        $request->session()->flash('systemSettingSuccess', 'Tetapan sistem berjaya dikemas kini!');

        return back();
    }
}
