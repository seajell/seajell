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
            'logo-first' => ['required', 'image', 'mimes:png'],
            'logo-second' => ['image', 'mimes:png'],
            'logo-third' => ['image', 'mimes:png'],
            'signature-first' => ['required', 'image', 'mimes:png'],
            'signature-first-name' => ['required'],
            'signature-first-position' => ['required'],
            'signature-second' => ['image', 'mimes:png'],
            'signature-third' => ['image', 'mimes:png'],
            'background-image' => ['image', 'mimes:png'],
            'text-color' => ['required'],
            'border' => ['required'],
        ]);
        $eventName = $request->input('event-name');
        $eventDate = $request->input('event-date');
        $eventLocation = $request->input('event-location');
        $organiserName = $request->input('organiser-name');
        $logoFirst = $request->file('logo-first');
        $signatureFirst = $request->file('signature-first');
        $signatureFirstName = $request->input('signature-first-name');
        $signatureFirstPosition = $request->input('signature-first-position');
        $visibility = $request->input('visibility');
        $borderStatus = $request->input('border');
        $borderColor = $request->input('border-color');
        $textColor = $request->input('text-color');
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

        /**
         * Logos
         * Make sure if logo name is added, the other inputs like the logo and position is also added for non-required logo
         */

        $logoFirstName = $logoFirst->getClientOriginalName();
        $logoFirstImage = Image::make($logoFirst)->resize(300, 300)->encode('png');
        $logoFirstSavePath = '/img/logo/'. Carbon::now()->timestamp . '-' . $logoFirstName;
        Storage::disk('public')->put($logoFirstSavePath, $logoFirstImage);

        // If only one of the second or third logo is added, it will be uploaded as second logo.
        // If both is added, it will occupied their own column

        if($request->hasFile('logo-second') && $request->hasFile('logo-third')){
            // Check if both files uploaded
            $logoSecondName = $request->file('logo-second')->getClientOriginalName();
            $logoSecondImage = Image::make($request->file('logo-second'))->resize(300, 300)->encode('png');
            $logoSecondSavePath = '/img/logo/'. Carbon::now()->timestamp . '-' . $logoSecondName;
            Storage::disk('public')->put($logoSecondSavePath, $logoSecondImage);

            $logoThirdName = $request->file('logo-third')->getClientOriginalName();
            $logoThirdImage = Image::make($request->file('logo-third'))->resize(300, 300)->encode('png');
            $logoThirdSavePath = '/img/logo/'. Carbon::now()->timestamp . '-' . $logoThirdName;
            Storage::disk('public')->put($logoThirdSavePath, $logoThirdImage);
        }elseif($request->hasFile('logo-second')){
            // Check if only second logo added. The data will be added to the second logo column.
            $logoSecondName = $request->file('logo-second')->getClientOriginalName();
            $logoSecondImage = Image::make($request->file('logo-second'))->resize(300, 300)->encode('png');
            $logoSecondSavePath = '/img/logo/'. Carbon::now()->timestamp . '-' . $logoSecondName;
            Storage::disk('public')->put($logoSecondSavePath, $logoSecondImage);
            $logoThirdSavePath = '';
        }elseif($request->hasFile('logo-third')){
            // Check if only third logo is added. The data will be added to the second logo column.
            $logoThirdName = $request->file('logo-third')->getClientOriginalName();
            $logoThirdImage = Image::make($request->file('logo-third'))->resize(300, 300)->encode('png');
            $logoSecondSavePath = '/img/logo/'. Carbon::now()->timestamp . '-' . $logoThirdName;
            Storage::disk('public')->put($logoSecondSavePath, $logoThirdImage);
            $logoThirdSavePath = '';
        }else{
            // Fallback in case both second and third logo is not added.
            $logoSecondSavePath = '';
            $logoThirdSavePath = '';
        }

        /**
         * Signatures
         * Somewhat same as above.
         */

        $signatureFirstName = $request->input('signature-first-name');
        $signatureFirstPosition = $request->input('signature-first-position');
        
        $signatureFirstImageName = $signatureFirst->getClientOriginalName();
        $signatureFirstImage = Image::make($signatureFirst)->resize(300, 100)->encode('png');
        $signatureFirstSavePath = '/img/signature/'. Carbon::now()->timestamp . '-' . $signatureFirstImageName;
        Storage::disk('public')->put($signatureFirstSavePath, $signatureFirstImage);

        // Check if one of the inputs of signature second and third is added, then required the others (name, position, image)
        if(!empty($request->input('signature-second-name')) || !empty($request->input('signature-second-name')) || $request->hasFile('signature-second')){
            $validated = $request->validate([
                'signature-second' => ['required', 'image', 'mimes:png'],
                'signature-second-name' => ['required'],
                'signature-second-position' => ['required']
            ]);
        }

        if(!empty($request->input('signature-third-name')) || !empty($request->input('signature-third-name')) || $request->hasFile('signature-third')){
            $validated = $request->validate([
                'signature-third' => ['required', 'image', 'mimes:png'],
                'signature-third-name' => ['required'],
                'signature-third-position' => ['required']
            ]);
        }

        if($request->hasFile('signature-second') && $request->hasFile('signature-third')){
            $signatureSecondName = $request->file('signature-second')->getClientOriginalName();
            $signatureSecondImage = Image::make($request->file('signature-second'))->resize(300, 100)->encode('png');
            $signatureSecondSavePath = '/img/signature/'. Carbon::now()->timestamp . '-' . $signatureSecondName;
            Storage::disk('public')->put($signatureSecondSavePath, $signatureSecondImage);

            $signatureThirdName = $request->file('signature-third')->getClientOriginalName();
            $signatureThirdImage = Image::make($request->file('signature-third'))->resize(300, 100)->encode('png');
            $signatureThirdSavePath = '/img/signature/'. Carbon::now()->timestamp . '-' . $signatureThirdName;
            Storage::disk('public')->put($signatureThirdSavePath, $signatureThirdImage);

            $signatureSecondMainName = $request->input('signature-second-name');
            $signatureSecondMainPosition = $request->input('signature-second-position');

            $signatureThirdMainName = $request->input('signature-third-name');
            $signatureThirdMainPosition = $request->input('signature-third-position');
        }elseif($request->hasFile('signature-second')){
            // Check if second signature is uploaded (since it's not required)
            $signatureSecondName = $request->file('signature-second')->getClientOriginalName();
            $signatureSecondImage = Image::make($request->file('signature-second'))->resize(300, 100)->encode('png');
            $signatureSecondSavePath = '/img/signature/'. Carbon::now()->timestamp . '-' . $signatureSecondName;
            Storage::disk('public')->put($signatureSecondSavePath, $signatureSecondImage);
            $signatureThirdSavePath = '';

            $signatureSecondMainName = $request->input('signature-second-name');
            $signatureSecondMainPosition = $request->input('signature-second-position');

            $signatureThirdMainName = '';
            $signatureThirdMainPosition = '';
        }elseif($request->hasFile('signature-third')){
            // Check if third signature is uploaded (since it's not required)
            $signatureThirdName = $request->file('signature-third')->getClientOriginalName();
            $signatureThirdImage = Image::make($request->file('signature-third'))->resize(300, 100)->encode('png');
            $signatureSecondSavePath = '/img/signature/'. Carbon::now()->timestamp . '-' . $signatureThirdName;
            Storage::disk('public')->put($signatureSecondSavePath, $signatureThirdImage);
            $signatureThirdSavePath = '';

            $signatureSecondMainName = $request->input('signature-third-name');
            $signatureSecondMainPosition = $request->input('signature-third-position');

            $signatureThirdMainName = '';
            $signatureThirdMainPosition = '';
        }else{
            $signatureSecondSavePath = '';
            $signatureThirdSavePath = '';

            $signatureSecondMainName = '';
            $signatureSecondMainPosition = '';

            $signatureThirdMainName = '';
            $signatureThirdMainPosition = '';
        }

         /**
          * Background image
          */

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
            'logo_first' => $logoFirstSavePath,
            'logo_second' => $logoSecondSavePath,
            'logo_third' => $logoThirdSavePath,
            'signature_first_name' => strtolower($signatureFirstName),
            'signature_first_position' => $signatureFirstPosition,
            'signature_first' => $signatureFirstSavePath,
            'signature_second_name' => strtolower($signatureSecondMainName),
            'signature_second_position' => strtolower($signatureSecondMainPosition),
            'signature_second' => $signatureSecondSavePath,
            'signature_third_name' => strtolower($signatureThirdMainName),
            'signature_third_position' => strtolower($signatureThirdMainPosition),
            'signature_third' => $signatureThirdSavePath,
            'visibility' => strtolower($visibility),
            'background_image' => $backgroundImageSavePath,
            'text_color' => $textColor,
            'border' => $borderStatus,
            'border_color' => $borderColor,
        ]);

        $request->session()->flash('addEventSuccess', 'Acara berjaya ditambah!');
        return back();
    }

    public function removeEvent(Request $request){
        $id = $request->input('event-id');
        $event = Event::where('id', $id)->first();
        $firstLogo = $event->logo_first;
        $secondLogo = $event->logo_second;
        $thirdLogo = $event->logo_third;
        $firstSignature = $event->signature_first;
        $secondSignature = $event->signature_second;
        $thirdSignature = $event->signature_third;
        // Deletes the images
        if (Storage::disk('public')->exists($firstLogo)) {
            Storage::disk('public')->delete($firstLogo);
        }
        if (Storage::disk('public')->exists($secondLogo)) {
            Storage::disk('public')->delete($secondLogo);
        }
        if (Storage::disk('public')->exists($thirdLogo)) {
            Storage::disk('public')->delete($thirdLogo);
        }
        if (Storage::disk('public')->exists($firstSignature)) {
            Storage::disk('public')->delete($firstSignature);
        }
        if (Storage::disk('public')->exists($secondSignature)) {
            Storage::disk('public')->delete($secondSignature);
        }
        if (Storage::disk('public')->exists($thirdSignature)) {
            Storage::disk('public')->delete($thirdSignature);
        }
        $event->delete();
        $request->session()->flash('removeEventSuccess', 'Acara berjaya dibuang!');
        return back();
    }

    public function updateEvent(Request $request, $id){
        $eventName = $request->input('event-name');
        $eventDate = $request->input('event-date');
        $eventLocation = $request->input('event-location');
        $organiserName = $request->input('organiser-name');
        $logoFirst = $request->file('logo-first');
        $signatureFirst = $request->file('signature-first');
        $signatureFirstName = $request->input('signature-first-name');
        $signatureFirstPosition = $request->input('signature-first-position');
        $visibility = $request->input('visibility');
        $borderStatus = $request->input('border');
        $borderColor = $request->input('border-color');
        $textColor = $request->input('text-color');
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

        /**
         * Logos
         * Make sure if logo name is added, the other inputs like the logo and position is also added for non-required logo
         */

        if($request->hasFile('logo-first')){
            $logoFirstName = $logoFirst->getClientOriginalName();
            $logoFirstImage = Image::make($logoFirst)->resize(300, 300)->encode('png');
            $logoFirstSavePath = '/img/logo/'. Carbon::now()->timestamp . '-' . $logoFirstName;
            Storage::disk('public')->put($logoFirstSavePath, $logoFirstImage);
        }else{
            if(!empty(Event::where('id', $id)->first()->logo_first)){
                $logoFirstSavePath = Event::where('id', $id)->first()->logo_first;
            }
        }

        // If only one of the second or third logo is added, it will be uploaded as second logo.
        // If both is added, it will occupied their own column

        if($request->hasFile('logo-second') && $request->hasFile('logo-third')){
            // Check if both files uploaded
            $logoSecondName = $request->file('logo-second')->getClientOriginalName();
            $logoSecondImage = Image::make($request->file('logo-second'))->resize(300, 300)->encode('png');
            $logoSecondSavePath = '/img/logo/'. Carbon::now()->timestamp . '-' . $logoSecondName;
            Storage::disk('public')->put($logoSecondSavePath, $logoSecondImage);

            $logoThirdName = $request->file('logo-third')->getClientOriginalName();
            $logoThirdImage = Image::make($request->file('logo-third'))->resize(300, 300)->encode('png');
            $logoThirdSavePath = '/img/logo/'. Carbon::now()->timestamp . '-' . $logoThirdName;
            Storage::disk('public')->put($logoThirdSavePath, $logoThirdImage);
        }elseif($request->hasFile('logo-second')){
            // Check if only second logo added. The data will be added to the second logo column.
            $logoSecondName = $request->file('logo-second')->getClientOriginalName();
            $logoSecondImage = Image::make($request->file('logo-second'))->resize(300, 300)->encode('png');
            $logoSecondSavePath = '/img/logo/'. Carbon::now()->timestamp . '-' . $logoSecondName;
            Storage::disk('public')->put($logoSecondSavePath, $logoSecondImage);

            if(!empty(Event::where('id', $id)->first()->logo_third)){
                $logoThirdSavePath = Event::where('id', $id)->first()->logo_third;
            }else{
                $logoThirdSavePath = '';
            }
        }elseif($request->hasFile('logo-third')){
            // First check if there's data in second column, if not insert the data there. If have, insert in third column.
            if(empty(Event::where('id', $id)->first()->logo_second)){
                $logoThirdName = $request->file('logo-third')->getClientOriginalName();
                $logoThirdImage = Image::make($request->file('logo-third'))->resize(300, 300)->encode('png');
                $logoSecondSavePath = '/img/logo/'. Carbon::now()->timestamp . '-' . $logoThirdName;
                Storage::disk('public')->put($logoSecondSavePath, $logoThirdImage);

                // Insert all third column data if available
                if(!empty(Event::where('id', $id)->first()->logo_third)){
                    $logoThirdSavePath = Event::where('id', $id)->first()->logo_third;
                }else{
                    $logoThirdSavePath = '';
                }
            }else{
                $logoThirdName = $request->file('logo-third')->getClientOriginalName();
                $logoThirdImage = Image::make($request->file('logo-third'))->resize(300, 300)->encode('png');
                $logoThirdSavePath = '/img/logo/'. Carbon::now()->timestamp . '-' . $logoThirdName;
                Storage::disk('public')->put($logoThirdSavePath, $logoThirdImage);

                // Insert all second column data if available
                if(!empty(Event::where('id', $id)->first()->logo_second)){
                    $logoSecondSavePath = Event::where('id', $id)->first()->logo_second;
                }else{
                    $logoSecondSavePath = '';
                }
            }
            
        }else{
            // Fallback in case both second and third logo is not added.
            if(!empty(Event::where('id', $id)->first()->logo_second)){
                $logoSecondSavePath = Event::where('id', $id)->first()->logo_second;
            }else{
                $logoSecondSavePath = '';
            }

            if(!empty(Event::where('id', $id)->first()->logo_third)){
                $logoThirdSavePath = Event::where('id', $id)->first()->logo_third;
            }else{
                $logoThirdSavePath = '';
            }
        }

        /**
         * Signatures
         * Somewhat same as above.
         * 
         * To Do
         */

        $signatureFirstName = $request->input('signature-first-name');
        $signatureFirstPosition = $request->input('signature-first-position');
        
        $signatureFirstImageName = $signatureFirst->getClientOriginalName();
        $signatureFirstImage = Image::make($signatureFirst)->resize(300, 100)->encode('png');
        $signatureFirstSavePath = '/img/signature/'. Carbon::now()->timestamp . '-' . $signatureFirstImageName;
        Storage::disk('public')->put($signatureFirstSavePath, $signatureFirstImage);

        // Check if one of the inputs of signature second and third is added, then required the others (name, position, image)
        if(!empty($request->input('signature-second-name')) || !empty($request->input('signature-second-name')) || $request->hasFile('signature-second')){
            $validated = $request->validate([
                'signature-second' => ['required', 'image', 'mimes:png'],
                'signature-second-name' => ['required'],
                'signature-second-position' => ['required']
            ]);
        }

        if(!empty($request->input('signature-third-name')) || !empty($request->input('signature-third-name')) || $request->hasFile('signature-third')){
            $validated = $request->validate([
                'signature-third' => ['required', 'image', 'mimes:png'],
                'signature-third-name' => ['required'],
                'signature-third-position' => ['required']
            ]);
        }

        if($request->hasFile('signature-second') && $request->hasFile('signature-third')){
            $signatureSecondName = $request->file('signature-second')->getClientOriginalName();
            $signatureSecondImage = Image::make($request->file('signature-second'))->resize(300, 100)->encode('png');
            $signatureSecondSavePath = '/img/signature/'. Carbon::now()->timestamp . '-' . $signatureSecondName;
            Storage::disk('public')->put($signatureSecondSavePath, $signatureSecondImage);

            $signatureThirdName = $request->file('signature-third')->getClientOriginalName();
            $signatureThirdImage = Image::make($request->file('signature-third'))->resize(300, 100)->encode('png');
            $signatureThirdSavePath = '/img/signature/'. Carbon::now()->timestamp . '-' . $signatureThirdName;
            Storage::disk('public')->put($signatureThirdSavePath, $signatureThirdImage);

            $signatureSecondMainName = $request->input('signature-second-name');
            $signatureSecondMainPosition = $request->input('signature-second-position');

            $signatureThirdMainName = $request->input('signature-third-name');
            $signatureThirdMainPosition = $request->input('signature-third-position');
        }elseif($request->hasFile('signature-second')){
            // Check if second signature is uploaded (since it's not required)
            $signatureSecondName = $request->file('signature-second')->getClientOriginalName();
            $signatureSecondImage = Image::make($request->file('signature-second'))->resize(300, 100)->encode('png');
            $signatureSecondSavePath = '/img/signature/'. Carbon::now()->timestamp . '-' . $signatureSecondName;
            Storage::disk('public')->put($signatureSecondSavePath, $signatureSecondImage);
            $signatureThirdSavePath = '';

            $signatureSecondMainName = $request->input('signature-second-name');
            $signatureSecondMainPosition = $request->input('signature-second-position');

            $signatureThirdMainName = '';
            $signatureThirdMainPosition = '';
        }elseif($request->hasFile('signature-third')){
            // Check if third signature is uploaded (since it's not required)
            $signatureThirdName = $request->file('signature-third')->getClientOriginalName();
            $signatureThirdImage = Image::make($request->file('signature-third'))->resize(300, 100)->encode('png');
            $signatureSecondSavePath = '/img/signature/'. Carbon::now()->timestamp . '-' . $signatureThirdName;
            Storage::disk('public')->put($signatureSecondSavePath, $signatureThirdImage);
            $signatureThirdSavePath = '';

            $signatureSecondMainName = $request->input('signature-third-name');
            $signatureSecondMainPosition = $request->input('signature-third-position');

            $signatureThirdMainName = '';
            $signatureThirdMainPosition = '';
        }else{
            $signatureSecondSavePath = '';
            $signatureThirdSavePath = '';

            $signatureSecondMainName = '';
            $signatureSecondMainPosition = '';

            $signatureThirdMainName = '';
            $signatureThirdMainPosition = '';
        }

         /**
          * Background image
          */

        // Check if background image is uploaded (since it's not required)
        if($request->hasFile('background-image')){
            $backgroundImageName = $request->file('background-image')->getClientOriginalName();
            $backgroundImageImage = Image::make($request->file('background-image'))->resize(794, 1123)->encode('png');
            $backgroundImageSavePath = '/img/background_image/'. Carbon::now()->timestamp . '-' . $backgroundImageName;
            Storage::disk('public')->put($backgroundImageSavePath, $backgroundImageImage);
        }else{
            $backgroundImageSavePath = '';
        }

        $flight = Flight::updateOrCreate(
            ['id', $id],
            [
                'name' => strtolower($eventName),
                'date' => $eventDate,
                'location' => strtolower($eventLocation),
                'organiser_name' => strtolower($organiserName),
                'logo_first' => $logoFirstSavePath,
                'logo_second' => $logoSecondSavePath,
                'logo_third' => $logoThirdSavePath,
                'signature_first_name' => strtolower($signatureFirstName),
                'signature_first_position' => $signatureFirstPosition,
                'signature_first' => $signatureFirstSavePath,
                'signature_second_name' => strtolower($signatureSecondMainName),
                'signature_second_position' => strtolower($signatureSecondMainPosition),
                'signature_second' => $signatureSecondSavePath,
                'signature_third_name' => strtolower($signatureThirdMainName),
                'signature_third_position' => strtolower($signatureThirdMainPosition),
                'signature_third' => $signatureThirdSavePath,
                'visibility' => strtolower($visibility),
                'background_image' => $backgroundImageSavePath,
                'text_color' => $textColor,
                'border' => $borderStatus,
                'border_color' => $borderColor,
            ]
        );

        $request->session()->flash('updateEventSuccess', 'Acara berjaya dikemas kini!');
        return back();
    }
}
