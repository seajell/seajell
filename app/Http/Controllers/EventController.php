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
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\MainController;

class EventController extends MainController
{
    public function eventListView(Request $request){
        // id
        // name
        // date
        // location
        // organiser-name
        // organiser-logo
        // institute-name
        // institute-logo
        // visibility
        $events = Event::paginate(7);
        return view('event.list')->with(['events' => $events, 'appVersion' => $this->appVersion, 'apiToken' => $this->apiToken, 'appName' => $this->appName, 'orgName' => $this->orgName]);
    }

    public function addEventView(Request $request){
        return view('event.add')->with(['appVersion' => $this->appVersion, 'apiToken' => $this->apiToken, 'appName' => $this->appName, 'orgName' => $this->orgName]);
    }

    public function updateEventView(Request $request, $id){
        if(Event::where('id', $id)->first()){
            // Only admins can update event info
            if(Gate::allows('authAdmin')){
                $data = Event::where('id', $id)->first();
                    return view('event.update')->with(['appVersion' => $this->appVersion, 'apiToken' => $this->apiToken, 'appName' => $this->appName, 'orgName' => $this->orgName, 'data' => $data]);
            }else{
                abort(403, 'Anda tidak boleh mengakses laman ini.');
            }
        }else{
            abort(404, 'Acara tidak dijumpai.');
        }
    }

    public function addEvent(Request $request){
        $validated = $request->validate([
            'event-name' => ['required'],
            'event-date' => ['required', 'date'],
            'event-location' => ['required'],
            'organiser-name' => ['required'],
            'organiser-logo' => ['required', 'mimes:png'],
            'visibility' => ['required'],
            'institute-name' => [],
            'institute-logo' => ['image', 'mimes:png'],
            'verifier-name' => ['required'],
            'verifier-position' => ['required'],
            'verifier-signature' => ['required'],
            'background-image' => ['image', 'mimes:png'],
            'border' => ['required'],
        ]);
        $eventName = $request->input('event-name');
        $eventDate = $request->input('event-date');
        $eventLocation = $request->input('event-location');
        $organiserName = $request->input('organiser-name');
        $organiserLogo = $request->file('organiser-logo');
        $visibility = $request->input('visibility');
        $verifierName = $request->input('verifier-name');
        $verifierPosition = $request->input('verifier-position');
        $verifierSignature = $request->file('verifier-signature');
        $borderStatus = $request->input('border');
        $borderColor = $request->input('border-color');

        // Check if border is needed
        switch ($borderStatus) {
            case 'available':
                // Check if border color have been set
                if($borderColor != '' && $borderColor != NULL){
                    $borderColor = $borderColor;
                }else{
                    $borderColor = '';
                }
                break;
            case 'unavailable':
                $borderColor = '';
                break;
            default:
                break;
        }

        // Check if institute logo is uploaded (since it's not required)
        if($request->hasFile('institute-logo')){
            $instituteLogoName = $request->file('institute-logo')->getClientOriginalName();
            $instituteLogoImage = Image::make($request->file('institute-logo'))->resize(300, 300)->encode('png');
            $instituteLogoSavePath = '/img/institute/'. Carbon::now()->timestamp . '-' . $instituteLogoName;
            Storage::disk('public')->put($instituteLogoSavePath, $instituteLogoImage);
        }else{
            $instituteLogoSavePath = '';
        }

        if(!empty($request->input('institute-name'))){
            $instituteName = $request->input('institute-name');
        }else{
            $instituteName = '';
        }

        $organiserLogoName = $request->file('organiser-logo')->getClientOriginalName();
        $organiserLogoImage = Image::make($organiserLogo)->resize(300, 300)->encode('png');
        $organiserLogoSavePath = '/img/organiser/'. Carbon::now()->timestamp . '-' . $organiserLogoName;
        Storage::disk('public')->put($organiserLogoSavePath, $organiserLogoImage);

        $verifierSignatureName =$verifierSignature->getClientOriginalName();
        $verifierSignatureImage = Image::make($verifierSignature)->resize(300, 100)->encode('png');
        $verifierSignatureSavePath = '/img/signature/'. Carbon::now()->timestamp . '-' . $verifierSignatureName;
        Storage::disk('public')->put($verifierSignatureSavePath, $verifierSignatureImage);

        // Check if background image is uploaded (since it's not required)
        if($request->hasFile('background-image')){
            $backgroundImageName = $request->file('background-image')->getClientOriginalName();
            $backgroundImageImage = Image::make($request->file('background-image'))->resize(794, 1123)->encode('png');
            $backgroundImageSavePath = '/img/background_image/'. Carbon::now()->timestamp . '-' . $backgroundImageName;
            Storage::disk('public')->put($backgroundImageSavePath, $backgroundImageImage);
        }else{
            $backgroundImageSavePath = '';
        }

        Event::create([
            'name' => strtolower($eventName),
            'date' => $eventDate,
            'location' => strtolower($eventLocation),
            'organiser_name' => strtolower($organiserName),
            'organiser_logo' => $organiserLogoSavePath,
            'institute_name' => $instituteName,
            'institute_logo' => $instituteLogoSavePath,
            'visibility' => strtolower($visibility),
            'verifier_signature' => $verifierSignatureSavePath,
            'verifier_name' => strtolower($verifierName),
            'verifier_position' => strtolower($verifierPosition),
            'background_image' => $backgroundImageSavePath,
            'border' => $borderStatus,
            'border_color' => $borderColor,
        ]);

        $request->session()->flash('addEventSuccess', 'Acara berjaya ditambah!');
        return back();
    }

    public function removeEvent(Request $request){
        $id = $request->input('event-id');
        $event = Event::where('id', $id);
        $event->delete();
        $request->session()->flash('removeEventSuccess', 'Acara berjaya dibuang!');
        return back();
    }

    public function updateEvent(Request $request, $id){
        $validated = $request->validate([
            'event-name' => ['required'],
            'event-date' => ['required', 'date'],
            'event-location' => ['required'],
            'organiser-name' => ['required'],
            // 'organiser-logo' => ['required', 'mimes:png'],
            'visibility' => ['required'],
            'institute-logo' => ['image', 'mimes:png'],
            'verifier-name' => ['required'],
            'verifier-position' => ['required'],
            'background-image' => ['image', 'mimes:png'],
            'border' => ['required'],
        ]);
        $eventName = $request->input('event-name');
        $eventDate = $request->input('event-date');
        $eventLocation = $request->input('event-location');
        $organiserName = $request->input('organiser-name');
        $organiserLogo = $request->file('organiser-logo');
        $visibility = $request->input('visibility');
        $verifierName = $request->input('verifier-name');
        $verifierPosition = $request->input('verifier-position');
        $verifierSignature = $request->file('verifier-signature');
        $borderStatus = $request->input('border');
        $borderColor = $request->input('border-color');

        // Check if border is needed
        switch ($borderStatus) {
            case 'available':
                // Check if border color have been set
                if($borderColor != '' && $borderColor != NULL){
                    $borderColor = $borderColor;
                }else{
                    $borderColor = '';
                }
                break;
            case 'unavailable':
                $borderColor = '';
                break;
            default:
                break;
        }
        
        // Check if institute logo is uploaded (since it's not required)
        if($request->hasFile('institute-logo')){
            $instituteLogoName = $request->file('institute-logo')->getClientOriginalName();
            $instituteLogoImage = Image::make($request->file('institute-logo'))->resize(300, 300)->encode('png');
            $instituteLogoSavePath = '/img/institute/'. Carbon::now()->timestamp . '-' . $instituteLogoName;
            Storage::disk('public')->put($instituteLogoSavePath, $instituteLogoImage);
        }else{
            // Get path from database
            $instituteLogoSavePath = Event::where('id', $id)->first()->institute_logo;
        }

        if(!empty($request->input('institute-name'))){
            $instituteName = $request->input('institute-name');
        }elseif(empty($request->input('institute-name'))){
            $instituteName = Event::where('id', $id)->first()->institute_name;
        }else{
            $instituteName = '';
        }

        // Check if organiser is uploaded (since it's not required)
        if($request->hasFile('organiser-logo')){
            $validated = $request->validate([
                'organiser-logo' => ['required', 'mimes:png']
            ]);
            $organiserLogoName = $request->file('organiser-logo')->getClientOriginalName();
            $organiserLogoImage = Image::make($organiserLogo)->resize(300, 300)->encode('png');
            $organiserLogoSavePath = '/img/organiser/'. Carbon::now()->timestamp . '-' . $organiserLogoName;
            Storage::disk('public')->put($organiserLogoSavePath, $organiserLogoImage);
        }else{
            // Get path from database
            $organiserLogoSavePath = Event::where('id', $id)->first()->organiser_logo;
        }
        
        // Check if verifier signature is uploaded (since it's not required)
        if($request->hasFile('verifier-signature')){
            $validated = $request->validate([
                'verifier-signature' => ['required', 'mimes:png']
            ]);
            $verifierSignatureName = $verifierSignature->getClientOriginalName();
            $verifierSignatureImage = Image::make($verifierSignature)->resize(300, 100)->encode('png');
            $verifierSignatureSavePath = '/img/signature/'. Carbon::now()->timestamp . '-' . $verifierSignatureName;
            Storage::disk('public')->put($verifierSignatureSavePath, $verifierSignatureImage);
        }else{
            // Get path from database
            $verifierSignatureSavePath = Event::where('id', $id)->first()->verifier_signature;
        }

        // Check if background image is uploaded (since it's not required)
        if($request->hasFile('background-image')){
            $backgroundImageName = $request->file('background-image')->getClientOriginalName();
            $backgroundImageImage = Image::make($request->file('background-image'))->resize(794, 1123)->encode('png');
            $backgroundImageSavePath = '/img/background_image/'. Carbon::now()->timestamp . '-' . $backgroundImageName;
            Storage::disk('public')->put($backgroundImageSavePath, $backgroundImageImage);
        }else{
            // Get path from database
            $backgroundImageSavePath = Event::where('id', $id)->first()->background_image;
        }

        Event::updateOrCreate(
            ['id' => $id],
            [
                'name' => strtolower($eventName),
                'date' => $eventDate,
                'location' => strtolower($eventLocation),
                'organiser_name' => strtolower($organiserName),
                'organiser_logo' => $organiserLogoSavePath,
                'institute_name' => $instituteName,
                'institute_logo' => $instituteLogoSavePath,
                'visibility' => strtolower($visibility),
                'verifier_signature' => $verifierSignatureSavePath,
                'verifier_name' => strtolower($verifierName),
                'verifier_position' => strtolower($verifierPosition),
                'background_image' => $backgroundImageSavePath,
                'border' => $borderStatus,
                'border_color' => $borderColor,
            ]
        );

        $request->session()->flash('updateEventSuccess', 'Acara berjaya dikemas kini!');
        return back();
    }
}
