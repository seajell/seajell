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

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function getEventByID(Request $request, $id)
    {
        if ('empty-value' == $id) {
            return response()->json([
                'Empty_Err' => 'Empty id given!',
            ]);
        } else {
            $event = Event::select('name', 'date', 'location', 'organiser_name', 'visibility')->where('id', $id)->first();
            if ($event) {
                return response()->json([
                    'name' => $event->name,
                    'date' => $event->date,
                    'location' => $event->location,
                    'organiser_name' => $event->organiser_name,
                    'visibility' => $event->visibility,
                ]);
            } else {
                return response()->json([
                    'NotFound_Err' => 'Event not found!',
                ]);
            }
        }
    }
}
