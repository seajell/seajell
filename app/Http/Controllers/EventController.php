<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Event;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\MainController;

class EventController extends MainController
{
    public function eventListView(Request $request){
        $events = Event::paginate(7);
        return view('event.list')->with(['events' => $events]);
    }

    public function addEventView(Request $request){
        return view('event.add');
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
            'institute-logo' => ['image', 'mimes:png']
        ]);
        $eventName = $request->input('event-name');
        $eventDate = $request->input('event-date');
        $eventLocation = $request->input('event-location');
        $organiserName = $request->input('organiser-name');
        $organiserLogo = $request->file('organiser-logo');
        $visibility = $request->input('visibility');
        
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
        Event::create([
            'name' => strtolower($eventName),
            'date' => $eventDate,
            'location' => strtolower($eventLocation),
            'organiser_name' => strtolower($organiserName),
            'organiser_logo' => $organiserLogoSavePath,
            'institute_name' => $instituteName,
            'institute_logo' => $instituteLogoSavePath,
            'visibility' => strtolower($visibility),
        ]);
        $request->session()->flash('addEventSuccess', 'Acara berjaya ditambah!');
        return back();




        // if(!User::select('username')->where('username', $request->username)->first()){
        //     User::updateOrCreate(
        //         ['username' => strtolower($request->username)],
        //         ['fullname' => strtolower($request->fullname), 'email' => strtolower($request->email), 'password' => Hash::make($request->password), 'identification_number' => $request->identification_number, 'role' => strtolower($request->role)]
        //     );
        //     $request->session()->flash('addUserSuccess', 'Pengguna berjaya ditambah!');
        //     return back();
        // }else{
        //     return back()->withErrors([
        //         'userExisted' => 'Pengguna telah wujud!',
        //     ]);return back();
        // }
    }
}
