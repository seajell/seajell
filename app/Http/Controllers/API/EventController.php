<?php

namespace App\Http\Controllers\API;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function getEventByID(Request $request, $id){
        if($id == 'empty-value'){
            return response()->json([
                'Empty_Err' => 'Empty id given!'
            ]);
        }else{
            $event = Event::select('name', 'date', 'location', 'institute_name', 'organiser_name', 'visibility')->where('id', $id)->first();
            if($event){
                return response()->json([
                    'name' => $event->name,
                    'date' => $event->date,
                    'location' => $event->location,
                    'organiser_name' => $event->organiser_name,
                    'institute_name' => $event->institute_name,
                    'visibility' => $event->visibility
                ]);
            }else{
                return response()->json([
                    'NotFound_Err' => 'Event not found!'
                ]);
            }
        }
    }
}
