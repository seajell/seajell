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
use App\Models\EmailServiceSettings;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\MainController;

class SystemController extends MainController
{
    public function systemView(Request $request){
        $systemSetting = SystemSetting::where('id', 1)->first();
        if(!empty($this->emailServiceSetting)){
            $emailServiceSetting = $this->emailServiceSetting;
        }else{
            $emailServiceSetting = '';
        }
        return view('system.update')->with(['appVersion' => $this->appVersion, 'apiToken' => $this->apiToken, 'appName' => $this->appName, 'systemSetting' => $this->systemSetting, 'emailServiceSetting' => $emailServiceSetting]);
    }

    public function systemUpdate(Request $request){
        if($request->has('organisation-information')){
            $validated = $request->validate([
                'system-name' => ['required'],
                'system-language' => ['required'],
                'system-logo' => ['image', 'mimes:png']
            ]);
            $systemName = $request->input('system-name');
            $systemLanguage = $request->input('system-language');
            $systemLogo = $request->file('system-logo');

            if($request->hasFile('system-logo')){
                // Deletes old
                if(!empty($systemSetting = SystemSetting::where('id', 1)->first()->logo)){
                    $oldImage = $systemSetting = SystemSetting::where('id', 1)->first()->logo;
                    if(Storage::disk('public')->exists($oldImage)){
                        Storage::disk('public')->delete($oldImage);
                    }
                }
                $systemLogoName = $request->file('system-logo')->getClientOriginalName();
                $systemLogoImage = Image::make($request->file('system-logo'))->resize(300, 300)->encode('png');
                $systemLogoSavePath = '/img/system/logo/'. Carbon::now()->timestamp . '-' . $systemLogoName;
                Storage::disk('public')->put($systemLogoSavePath, $systemLogoImage);
            }else{
                $systemLogoSavePath = $systemSetting = SystemSetting::where('id', 1)->first()->logo;
            }

            SystemSetting::upsert([
                [
                    'id' => 1,
                    'name' => strtolower($systemName),
                    'logo' => $systemLogoSavePath,
                    'language' => $systemLanguage
                ]
            ], ['id'], ['name', 'logo', 'language']);

            $request->session()->flash('systemSettingSuccess', 'Tetapan sistem berjaya dikemas kini!');
            return back();
        }elseif($request->has('email-information')){
            $validated = $request->validate([
                'email-service-host' => ['required'],
                'email-service-port' => ['required'],
                'email-service-username' => ['required'],
                'email-service-password' => ['required']
            ]);

            if(!empty($request->input('email-service-switch'))){
                $emailServiceStatus = 'on';
            }else{
                $emailServiceStatus = 'off';
            }

            if(!empty($request->input('email-service-support-email'))){
                $emailServiceSupportEmail = $request->input('email-service-support-email');
            }else{
                $emailServiceSupportEmail = '';
            }

            EmailServiceSettings::updateOrCreate(
                ['id' => 1],
                [
                    'service_status' => $emailServiceStatus,
                    'service_host' => $request->input('email-service-host'),
                    'service_port' => $request->input('email-service-port'),
                    'account_username' => $request->input('email-service-username'),
                    'account_password' => $request->input('email-service-password'),
                    'support_email' => $emailServiceSupportEmail
                ]
            );

            $request->session()->flash('updateEmailServiceSuccess', 'Tetapan servis e-mel berjaya dikemas kini!');
            return back();
        }else{
            return route('home');
        }
    }
}
