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
use App\Models\EventFont;
use App\Models\Certificate;
use App\Models\EventLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class EventController extends MainController
{
    public function eventListView(Request $request)
    {
        $pagination = 15;
        $events = Event::paginate($pagination)->withQueryString();
        // Check for filters and search
        if ($request->filled('sort_by') and $request->filled('sort_order') and $request->has('search')) {
            $sortBy = $request->sort_by;
            $sortOrder = $request->sort_order;
            $search = $request->search;
            if (!empty($search)) {
                $events = Event::where('id', 'LIKE', "%{$search}%")->orWhere('name', 'LIKE', "%{$search}%")->orWhere('date', 'LIKE', "%{$search}%")->orWhere('location', 'LIKE', "%{$search}%")->orWhere('organiser_name', 'LIKE', "%{$search}%")->orWhere('visibility', 'LIKE', "%{$search}%")->orderBy($sortBy, $sortOrder)->paginate($pagination)->withQueryString();
            } else {
                $events = Event::orderBy($sortBy, $sortOrder)->paginate($pagination)->withQueryString();
            }
            $sortAndSearch = [
                'sortBy' => $sortBy,
                'sortOrder' => $sortOrder,
                'search' => $search,
            ];

            return view('event.list')->with(['sortAndSearch' => $sortAndSearch, 'events' => $events, 'appVersion' => $this->appVersion, 'apiToken' => $this->apiToken, 'appName' => $this->appName, 'systemSetting' => $this->systemSetting]);
        } else {
            return view('event.list')->with(['events' => $events, 'appVersion' => $this->appVersion, 'apiToken' => $this->apiToken, 'appName' => $this->appName, 'systemSetting' => $this->systemSetting]);
        }
    }

    public function addEventView(Request $request)
    {
        return view('event.add')->with(['appVersion' => $this->appVersion, 'apiToken' => $this->apiToken, 'appName' => $this->appName, 'systemSetting' => $this->systemSetting]);
    }

    public function updateEventView(Request $request, $id)
    {
        if (Event::where('id', $id)->first()) {
            // Only admins can update event info
            if (Gate::allows('authAdmin')) {
                $data = Event::where('id', $id)->first();
                $eventFontData = EventFont::where('event_id', $id)->first();

                return view('event.update')->with(['appVersion' => $this->appVersion, 'apiToken' => $this->apiToken, 'appName' => $this->appName, 'systemSetting' => $this->systemSetting, 'data' => $data, 'eventFontData' => $eventFontData]);
            } else {
                abort(403, 'Anda tidak boleh mengakses laman ini.');
            }
        } else {
            abort(404, 'Acara tidak dijumpai.');
        }
    }

    public function layoutView(Request $request, $id)
    {
        if (Event::where('id', $id)->first()) {
            // Only admins can update event info
            if (Gate::allows('authAdmin')) {
                $eventData = Event::where('id', $id)->first();
                $eventFontData = EventFont::where('event_id', $id)->first();
                $eventLayoutData = EventLayout::where('event_id', $id)->first();

                $eventFontImages = [
                    'backgroundImage' => $this->cacheDataURLImage($eventData->background_image, 1050, 1485),
                    'logoFirst' => $this->cacheDataURLImage($eventData->logo_first, 300, 300),
                    'logoSecond' => $this->cacheDataURLImage($eventData->logo_second, 300, 300),
                    'logoThird' => $this->cacheDataURLImage($eventData->logo_third, 300, 300),
                    'signatureFirst' => $this->cacheDataURLImage($eventData->signature_first, 300, 100),
                    'signatureSecond' => $this->cacheDataURLImage($eventData->signature_second, 300, 100),
                    'signatureThird' => $this->cacheDataURLImage($eventData->signature_third, 300, 100),
                ];

                return view('event.layout')->with(['appVersion' => $this->appVersion, 'apiToken' => $this->apiToken, 'appName' => $this->appName, 'systemSetting' => $this->systemSetting, 'eventData' => $eventData, 'eventFontData' => $eventFontData, 'eventLayoutData' => $eventLayoutData, 'eventFontImages' => $eventFontImages]);
            } else {
                abort(403, 'Anda tidak boleh mengakses laman ini.');
            }
        } else {
            abort(404, 'Acara tidak dijumpai.');
        }
    }

    public function layoutSave(Request $request, $id)
    {
        if (Event::where('id', $id)->first()) {
            // Only admins can update event certificate layout
            if (Gate::allows('authAdmin')) {
                EventLayout::upsert(
                    [
                        [
                            'event_id' => $id,
                            'logo_first_input_width' => $request->input('logo-first-input-width'),
                            'logo_first_input_height' => $request->input('logo-first-input-height'),
                            'logo_first_input_translate' => $request->input('logo-first-input-translate'),
                            'logo_second_input_width' => $request->input('logo-second-input-width'),
                            'logo_second_input_height' => $request->input('logo-second-input-height'),
                            'logo_second_input_translate' => $request->input('logo-second-input-translate'),
                            'logo_third_input_width' => $request->input('logo-third-input-width'),
                            'logo_third_input_height' => $request->input('logo-third-input-height'),
                            'logo_third_input_translate' => $request->input('logo-third-input-translate'),
                            'details_input_width' => $request->input('details-input-width'),
                            'details_input_height' => $request->input('details-input-height'),
                            'details_input_translate' => $request->input('details-input-translate'),
                            'signature_first_input_width' => $request->input('signature-first-input-width'),
                            'signature_first_input_height' => $request->input('signature-first-input-height'),
                            'signature_first_input_translate' => $request->input('signature-first-input-translate'),
                            'signature_second_input_width' => $request->input('signature-second-input-width'),
                            'signature_second_input_height' => $request->input('signature-second-input-height'),
                            'signature_second_input_translate' => $request->input('signature-second-input-translate'),
                            'signature_third_input_width' => $request->input('signature-third-input-width'),
                            'signature_third_input_height' => $request->input('signature-third-input-height'),
                            'signature_third_input_translate' => $request->input('signature-third-input-translate'),
                            'qr_code_input_translate' => $request->input('qr-code-input-translate'),
                        ],
                    ],
                    ['event_id'],
                    [
                        'logo_first_input_width',
                        'logo_first_input_height',
                        'logo_first_input_translate',
                        'logo_second_input_width',
                        'logo_second_input_height',
                        'logo_second_input_translate',
                        'logo_third_input_width',
                        'logo_third_input_height',
                        'logo_third_input_translate',
                        'details_input_width',
                        'details_input_height',
                        'details_input_translate',
                        'signature_first_input_width',
                        'signature_first_input_height',
                        'signature_first_input_translate',
                        'signature_second_input_width',
                        'signature_second_input_height',
                        'signature_second_input_translate',
                        'signature_third_input_width',
                        'signature_third_input_height',
                        'signature_third_input_translate',
                        'qr_code_input_translate',
                    ]
                );

                $request->session()->flash('updateEventLayoutSuccess', 'Susun atur sijil berjaya dikemas kini!');

                return back();
            } else {
                abort(403, 'Anda tidak boleh mengakses laman ini.');
            }
        } else {
            abort(404, 'Acara tidak dijumpai.');
        }
    }

    public function addEvent(Request $request)
    {
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
            'certificate-orientation' => ['required'],
            'type-text-font' => ['required'],
            'type-text-size' => ['required', 'numeric'],
            'type-text-color' => ['required'],
            'first-text-font' => ['required'],
            'first-text-size' => ['required', 'numeric'],
            'first-text-color' => ['required'],
            'second-text-font' => ['required'],
            'second-text-size' => ['required', 'numeric'],
            'second-text-color' => ['required'],
            'verifier-text-font' => ['required'],
            'verifier-text-size' => ['required', 'numeric'],
            'verifier-text-color' => ['required'],
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
        $certificateOrientation = $request->input('certificate-orientation');

        /**
         * Logos
         * Make sure if logo name is added, the other inputs like the logo and position is also added for non-required logo.
         */
        $logoFirstName = $logoFirst->getClientOriginalName();
        $logoFirstImage = Image::make($logoFirst)->resize(300, 300)->encode('png');
        $logoFirstSavePath = '/img/logo/' . Carbon::now()->timestamp . '-' . $logoFirstName;
        Storage::disk('public')->put($logoFirstSavePath, $logoFirstImage);

        // If only one of the second or third logo is added, it will be uploaded as second logo.
        // If both is added, it will occupied their own column

        if ($request->hasFile('logo-second') && $request->hasFile('logo-third')) {
            // Check if both files uploaded
            $logoSecondName = $request->file('logo-second')->getClientOriginalName();
            $logoSecondImage = Image::make($request->file('logo-second'))->resize(300, 300)->encode('png');
            $logoSecondSavePath = '/img/logo/' . Carbon::now()->timestamp . '-' . $logoSecondName;
            Storage::disk('public')->put($logoSecondSavePath, $logoSecondImage);

            $logoThirdName = $request->file('logo-third')->getClientOriginalName();
            $logoThirdImage = Image::make($request->file('logo-third'))->resize(300, 300)->encode('png');
            $logoThirdSavePath = '/img/logo/' . Carbon::now()->timestamp . '-' . $logoThirdName;
            Storage::disk('public')->put($logoThirdSavePath, $logoThirdImage);
        } elseif ($request->hasFile('logo-second')) {
            // Check if only second logo added. The data will be added to the second logo column.
            $logoSecondName = $request->file('logo-second')->getClientOriginalName();
            $logoSecondImage = Image::make($request->file('logo-second'))->resize(300, 300)->encode('png');
            $logoSecondSavePath = '/img/logo/' . Carbon::now()->timestamp . '-' . $logoSecondName;
            Storage::disk('public')->put($logoSecondSavePath, $logoSecondImage);
            $logoThirdSavePath = '';
        } elseif ($request->hasFile('logo-third')) {
            // Check if only third logo is added. The data will be added to the second logo column.
            $logoThirdName = $request->file('logo-third')->getClientOriginalName();
            $logoThirdImage = Image::make($request->file('logo-third'))->resize(300, 300)->encode('png');
            $logoSecondSavePath = '/img/logo/' . Carbon::now()->timestamp . '-' . $logoThirdName;
            Storage::disk('public')->put($logoSecondSavePath, $logoThirdImage);
            $logoThirdSavePath = '';
        } else {
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
        $signatureFirstSavePath = '/img/signature/' . Carbon::now()->timestamp . '-' . $signatureFirstImageName;
        Storage::disk('public')->put($signatureFirstSavePath, $signatureFirstImage);

        // Check if one of the inputs of signature second and third is added, then required the others (name, position, image)
        if (!empty($request->input('signature-second-name')) || !empty($request->input('signature-second-name')) || $request->hasFile('signature-second')) {
            $validated = $request->validate([
                'signature-second' => ['required', 'image', 'mimes:png'],
                'signature-second-name' => ['required'],
                'signature-second-position' => ['required'],
            ]);
        }

        if (!empty($request->input('signature-third-name')) || !empty($request->input('signature-third-name')) || $request->hasFile('signature-third')) {
            $validated = $request->validate([
                'signature-third' => ['required', 'image', 'mimes:png'],
                'signature-third-name' => ['required'],
                'signature-third-position' => ['required'],
            ]);
        }

        if ($request->hasFile('signature-second') && $request->hasFile('signature-third')) {
            $signatureSecondName = $request->file('signature-second')->getClientOriginalName();
            $signatureSecondImage = Image::make($request->file('signature-second'))->resize(300, 100)->encode('png');
            $signatureSecondSavePath = '/img/signature/' . Carbon::now()->timestamp . '-' . $signatureSecondName;
            Storage::disk('public')->put($signatureSecondSavePath, $signatureSecondImage);

            $signatureThirdName = $request->file('signature-third')->getClientOriginalName();
            $signatureThirdImage = Image::make($request->file('signature-third'))->resize(300, 100)->encode('png');
            $signatureThirdSavePath = '/img/signature/' . Carbon::now()->timestamp . '-' . $signatureThirdName;
            Storage::disk('public')->put($signatureThirdSavePath, $signatureThirdImage);

            $signatureSecondMainName = $request->input('signature-second-name');
            $signatureSecondMainPosition = $request->input('signature-second-position');

            $signatureThirdMainName = $request->input('signature-third-name');
            $signatureThirdMainPosition = $request->input('signature-third-position');
        } elseif ($request->hasFile('signature-second')) {
            // Check if second signature is uploaded (since it's not required)
            $signatureSecondName = $request->file('signature-second')->getClientOriginalName();
            $signatureSecondImage = Image::make($request->file('signature-second'))->resize(300, 100)->encode('png');
            $signatureSecondSavePath = '/img/signature/' . Carbon::now()->timestamp . '-' . $signatureSecondName;
            Storage::disk('public')->put($signatureSecondSavePath, $signatureSecondImage);
            $signatureThirdSavePath = '';

            $signatureSecondMainName = $request->input('signature-second-name');
            $signatureSecondMainPosition = $request->input('signature-second-position');

            $signatureThirdMainName = '';
            $signatureThirdMainPosition = '';
        } elseif ($request->hasFile('signature-third')) {
            // Check if third signature is uploaded (since it's not required)
            $signatureThirdName = $request->file('signature-third')->getClientOriginalName();
            $signatureThirdImage = Image::make($request->file('signature-third'))->resize(300, 100)->encode('png');
            $signatureSecondSavePath = '/img/signature/' . Carbon::now()->timestamp . '-' . $signatureThirdName;
            Storage::disk('public')->put($signatureSecondSavePath, $signatureThirdImage);
            $signatureThirdSavePath = '';

            $signatureSecondMainName = $request->input('signature-third-name');
            $signatureSecondMainPosition = $request->input('signature-third-position');

            $signatureThirdMainName = '';
            $signatureThirdMainPosition = '';
        } else {
            $signatureSecondSavePath = '';
            $signatureThirdSavePath = '';

            $signatureSecondMainName = '';
            $signatureSecondMainPosition = '';

            $signatureThirdMainName = '';
            $signatureThirdMainPosition = '';
        }

        // Background image

        // Check if background image is uploaded (since it's not required)
        if ($request->hasFile('background-image')) {
            $backgroundImageName = $request->file('background-image')->getClientOriginalName();
            $backgroundImageImage = Image::make($request->file('background-image'))->resize(794, 1123)->encode('png');
            $backgroundImageSavePath = '/img/background_image/' . Carbon::now()->timestamp . '-' . $backgroundImageName;
            Storage::disk('public')->put($backgroundImageSavePath, $backgroundImageImage);
        } else {
            $backgroundImageSavePath = '';
        }

        $createdEventID = Event::create([
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
            'orientation' => $certificateOrientation,
        ])->id;

        EventFont::create([
            'event_id' => $createdEventID,
            'certificate_type_text_size' => $request->input('type-text-size'),
            'certificate_type_text_color' => $request->input('type-text-color'),
            'certificate_type_text_font' => $request->input('type-text-font'),
            'first_text_size' => $request->input('first-text-size'),
            'first_text_color' => $request->input('first-text-color'),
            'first_text_font' => $request->input('first-text-font'),
            'second_text_size' => $request->input('second-text-size'),
            'second_text_color' => $request->input('second-text-color'),
            'second_text_font' => $request->input('second-text-font'),
            'verifier_text_size' => $request->input('verifier-text-size'),
            'verifier_text_color' => $request->input('verifier-text-color'),
            'verifier_text_font' => $request->input('verifier-text-font'),
        ]);

        $request->session()->flash('addEventSuccess', 'Acara berjaya ditambah!');

        return back();
    }

    public function removeEvent(Request $request)
    {
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

    public function updateEvent(Request $request, $id)
    {
        $validated = $request->validate([
            'event-name' => ['required'],
            'event-date' => ['required', 'date'],
            'event-location' => ['required'],
            'organiser-name' => ['required'],
            'signature-first-name' => ['required'],
            'signature-first-position' => ['required'],
            'background-image' => ['image', 'mimes:png'],
            'certificate-orientation' => ['required'],
            'type-text-font' => ['required'],
            'type-text-size' => ['required', 'numeric'],
            'type-text-color' => ['required'],
            'first-text-font' => ['required'],
            'first-text-size' => ['required', 'numeric'],
            'first-text-color' => ['required'],
            'second-text-font' => ['required'],
            'second-text-size' => ['required', 'numeric'],
            'second-text-color' => ['required'],
            'verifier-text-font' => ['required'],
            'verifier-text-size' => ['required', 'numeric'],
            'verifier-text-color' => ['required'],
        ]);
        $eventName = $request->input('event-name');
        $eventDate = $request->input('event-date');
        $eventLocation = $request->input('event-location');
        $organiserName = $request->input('organiser-name');
        $visibility = $request->input('visibility');
        $certificateOrientation = $request->input('certificate-orientation');

        /*
         * Logos
         * Make sure if logo name is added, the other inputs like the logo and position is also added for non-required logo
         */

        if ($request->hasFile('logo-first')) {
            $logoFirst = $request->file('logo-first');
            $logoFirstName = $logoFirst->getClientOriginalName();
            $logoFirstImage = Image::make($logoFirst)->resize(300, 300)->encode('png');
            $logoFirstSavePath = '/img/logo/' . Carbon::now()->timestamp . '-' . $logoFirstName;
            // Deletes old image
            if (!empty(Event::where('id', $id)->first()->logo_first)) {
                $oldImage = Event::where('id', $id)->first()->logo_first;
                if (Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            Storage::disk('public')->put($logoFirstSavePath, $logoFirstImage);
        } else {
            if (!empty(Event::where('id', $id)->first()->logo_first)) {
                $logoFirstSavePath = Event::where('id', $id)->first()->logo_first;
            }
        }

        // If only one of the second or third logo is added, it will be uploaded as second logo.
        // If both is added, it will occupied their own column

        // Check if the checkbox is checked
        if (!empty($request->input('logo-second-check')) && !empty($request->input('logo-third-check'))) {
            // Check if both files uploaded. If not just use old data.
            if ($request->hasFile('logo-second')) {
                $logoSecondName = $request->file('logo-second')->getClientOriginalName();
                $logoSecondImage = Image::make($request->file('logo-second'))->resize(300, 300)->encode('png');
                $logoSecondSavePath = '/img/logo/' . Carbon::now()->timestamp . '-' . $logoSecondName;
                // Deletes old image
                if (!empty(Event::where('id', $id)->first()->logo_second)) {
                    $oldImage = Event::where('id', $id)->first()->logo_second;
                    if (Storage::disk('public')->exists($oldImage)) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
                Storage::disk('public')->put($logoSecondSavePath, $logoSecondImage);
            } else {
                if (!empty(Event::where('id', $id)->first()->logo_second)) {
                    $logoSecondSavePath = Event::where('id', $id)->first()->logo_second;
                }
            }

            if ($request->hasFile('logo-third')) {
                $logoThirdName = $request->file('logo-third')->getClientOriginalName();
                $logoThirdImage = Image::make($request->file('logo-third'))->resize(300, 300)->encode('png');
                $logoThirdSavePath = '/img/logo/' . Carbon::now()->timestamp . '-' . $logoThirdName;
                // Deletes old image
                if (!empty(Event::where('id', $id)->first()->logo_third)) {
                    $oldImage = Event::where('id', $id)->first()->logo_third;
                    if (Storage::disk('public')->exists($oldImage)) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
                Storage::disk('public')->put($logoThirdSavePath, $logoThirdImage);
            } else {
                if (!empty(Event::where('id', $id)->first()->logo_third)) {
                    $logoThirdSavePath = Event::where('id', $id)->first()->logo_third;
                }
            }
        } elseif (!empty($request->input('logo-second-check'))) {
            // Check if only second logo added. The data will be added to the second logo column.
            if ($request->hasFile('logo-second')) {
                $logoSecondName = $request->file('logo-second')->getClientOriginalName();
                $logoSecondImage = Image::make($request->file('logo-second'))->resize(300, 300)->encode('png');
                $logoSecondSavePath = '/img/logo/' . Carbon::now()->timestamp . '-' . $logoSecondName;
                // Deletes old image
                if (!empty(Event::where('id', $id)->first()->logo_second)) {
                    $oldImage = Event::where('id', $id)->first()->logo_second;
                    if (Storage::disk('public')->exists($oldImage)) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
                Storage::disk('public')->put($logoSecondSavePath, $logoSecondImage);
            } else {
                if (!empty(Event::where('id', $id)->first()->logo_second)) {
                    $logoSecondSavePath = Event::where('id', $id)->first()->logo_second;
                }
            }

            // Remove the third logo since it's left unchecked.
            $logoThirdSavePath = '';
            // Deletes old image
            if (!empty(Event::where('id', $id)->first()->logo_third)) {
                $oldImage = Event::where('id', $id)->first()->logo_third;
                if (Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
        } elseif (!empty($request->input('logo-third-check'))) {
            // Inserts the data to second column since the second logo is unchecked.
            if ($request->hasFile('logo-third')) {
                if (empty(Event::where('id', $id)->first()->logo_second)) {
                    $logoThirdName = $request->file('logo-third')->getClientOriginalName();
                    $logoThirdImage = Image::make($request->file('logo-third'))->resize(300, 300)->encode('png');
                    $logoSecondSavePath = '/img/logo/' . Carbon::now()->timestamp . '-' . $logoThirdName;
                    // Deletes old image
                    if (!empty(Event::where('id', $id)->first()->logo_second)) {
                        $oldImage = Event::where('id', $id)->first()->logo_second;
                        if (Storage::disk('public')->exists($oldImage)) {
                            Storage::disk('public')->delete($oldImage);
                        }
                    }
                    Storage::disk('public')->put($logoSecondSavePath, $logoThirdImage);
                }
            } else {
                // Insert all third column data if available
                if (!empty(Event::where('id', $id)->first()->logo_second)) {
                    $logoSecondSavePath = Event::where('id', $id)->first()->logo_second;
                } else {
                    $logoSecondSavePath = '';
                }
            }
        } else {
            // Remove both logo since both are left unchecked.
            $logoSecondSavePath = '';
            // Deletes old image
            if (!empty(Event::where('id', $id)->first()->logo_second)) {
                $oldImage = Event::where('id', $id)->first()->logo_second;
                if (Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            $logoThirdSavePath = '';
            // Deletes old image
            if (!empty(Event::where('id', $id)->first()->logo_third)) {
                $oldImage = Event::where('id', $id)->first()->logo_third;
                if (Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
        }

        /*
         * Signatures
         * Same as above with the checkbox mechanism.
         */

        // Checks if signature-first-name is exist and have data in it.
        if ($request->filled('signature-first-name')) {
            $signatureFirstName = $request->input('signature-first-name');
            $signatureFirstPosition = $request->input('signature-first-position');
            $signatureFirstName = $request->input('signature-first-name');
            $signatureFirstPosition = $request->input('signature-first-position');
            if ($request->hasFile('signature-first')) {
                $signatureFirst = $request->file('signature-first');
                $signatureFirstImageName = $signatureFirst->getClientOriginalName();
                $signatureFirstImage = Image::make($signatureFirst)->resize(300, 100)->encode('png');
                $signatureFirstSavePath = '/img/signature/' . Carbon::now()->timestamp . '-' . $signatureFirstImageName;
                // Deletes old image
                if (!empty(Event::where('id', $id)->first()->signature_first)) {
                    $oldImage = Event::where('id', $id)->first()->signature_first;
                    if (Storage::disk('public')->exists($oldImage)) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
                Storage::disk('public')->put($signatureFirstSavePath, $signatureFirstImage);
            } else {
                if (!empty(Event::where('id', $id)->first()->signature_first)) {
                    $signatureFirstSavePath = Event::where('id', $id)->first()->signature_first;
                } else {
                    $signatureFirstSavePath = '';
                }
            }
        }

        // Check if one of the inputs of signature second and third is added, then required the others (name, position, image)
        if ($request->filled('signature-second-name') || $request->filled('signature-second-name') || $request->hasFile('signature-second')) {
            $validated = $request->validate([
                'signature-second-name' => ['required'],
                'signature-second-position' => ['required'],
            ]);
        }

        if ($request->filled('signature-third-name') || $request->filled('signature-third-name') || $request->hasFile('signature-third')) {
            $validated = $request->validate([
                'signature-third-name' => ['required'],
                'signature-third-position' => ['required'],
            ]);
        }

        // Same as above, make sure checkbox is checked.
        if (!empty($request->input('signature-second-check')) && !empty($request->input('signature-third-check'))) {
            if ($request->hasFile('signature-second')) {
                $signatureSecondName = $request->file('signature-second')->getClientOriginalName();
                $signatureSecondImage = Image::make($request->file('signature-second'))->resize(300, 100)->encode('png');
                $signatureSecondSavePath = '/img/signature/' . Carbon::now()->timestamp . '-' . $signatureSecondName;
                // Deletes old image
                if (!empty(Event::where('id', $id)->first()->signature_second)) {
                    $oldImage = Event::where('id', $id)->first()->signature_second;
                    if (Storage::disk('public')->exists($oldImage)) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
                Storage::disk('public')->put($signatureSecondSavePath, $signatureSecondImage);
            } else {
                if (!empty(Event::where('id', $id)->first()->signature_second)) {
                    $signatureSecondSavePath = Event::where('id', $id)->first()->signature_second;
                } else {
                    $signatureSecondSavePath = '';
                }
            }

            if ($request->hasFile('signature-third')) {
                $signatureThirdName = $request->file('signature-third')->getClientOriginalName();
                $signatureThirdImage = Image::make($request->file('signature-third'))->resize(300, 100)->encode('png');
                $signatureThirdSavePath = '/img/signature/' . Carbon::now()->timestamp . '-' . $signatureThirdName;
                // Deletes old image
                if (!empty(Event::where('id', $id)->first()->signature_third)) {
                    $oldImage = Event::where('id', $id)->first()->signature_third;
                    if (Storage::disk('public')->exists($oldImage)) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
                Storage::disk('public')->put($signatureThirdSavePath, $signatureThirdImage);
            } else {
                if (!empty(Event::where('id', $id)->first()->signature_third)) {
                    $signatureThirdSavePath = Event::where('id', $id)->first()->signature_third;
                } else {
                    $signatureThirdSavePath = '';
                }
            }

            $signatureSecondMainName = $request->input('signature-second-name');
            $signatureSecondMainPosition = $request->input('signature-second-position');

            $signatureThirdMainName = $request->input('signature-third-name');
            $signatureThirdMainPosition = $request->input('signature-third-position');
        } elseif (!empty($request->input('signature-second-check'))) {
            // Check if only second signature is uploaded (since it's not required)
            if ($request->hasFile('signature-second')) {
                $signatureSecondName = $request->file('signature-second')->getClientOriginalName();
                $signatureSecondImage = Image::make($request->file('signature-second'))->resize(300, 100)->encode('png');
                $signatureSecondSavePath = '/img/signature/' . Carbon::now()->timestamp . '-' . $signatureSecondName;
                // Deletes old image
                if (!empty(Event::where('id', $id)->first()->signature_second)) {
                    $oldImage = Event::where('id', $id)->first()->signature_second;
                    if (Storage::disk('public')->exists($oldImage)) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
                Storage::disk('public')->put($signatureSecondSavePath, $signatureSecondImage);
            } else {
                if (!empty(Event::where('id', $id)->first()->signature_second)) {
                    $signatureSecondSavePath = Event::where('id', $id)->first()->signature_second;
                } else {
                    $signatureSecondSavePath = '';
                }
            }

            $signatureSecondMainName = $request->input('signature-second-name');
            $signatureSecondMainPosition = $request->input('signature-second-position');

            // Deletes all third data since it's unchecked.
            $signatureThirdMainName = '';
            $signatureThirdMainPosition = '';
            // Deletes old image
            if (!empty(Event::where('id', $id)->first()->signature_third)) {
                $oldImage = Event::where('id', $id)->first()->signature_third;
                if (Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            $signatureThirdSavePath = '';
        } elseif (!empty($request->input('signature-third-check'))) {
            // Check if only third signature is uploaded (since it's not required)

            // Inserts third data into second column and deletes the third column data.
            if ($request->hasFile('logo-third')) {
                $signatureThirdName = $request->file('signature-third')->getClientOriginalName();
                $signatureThirdImage = Image::make($request->file('signature-third'))->resize(300, 100)->encode('png');
                $signatureSecondSavePath = '/img/signature/' . Carbon::now()->timestamp . '-' . $signatureThirdName;
                // Deletes old image
                if (!empty(Event::where('id', $id)->first()->signature_second)) {
                    $oldImage = Event::where('id', $id)->first()->signature_second;
                    if (Storage::disk('public')->exists($oldImage)) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
                Storage::disk('public')->put($signatureSecondSavePath, $signatureThirdImage);
            } else {
                if (!empty(Event::where('id', $id)->first()->signature_second)) {
                    $signatureSecondSavePath = Event::where('id', $id)->first()->signature_second;
                } else {
                    $signatureSecondSavePath = '';
                }
            }
            $signatureSecondMainName = $request->input('signature-third-name');
            $signatureSecondMainPosition = $request->input('signature-third-position');

            // Deletes old data since it's going to be put into second column.
            $signatureThirdMainName = '';
            $signatureThirdMainPosition = '';
            // Deletes old image
            if (!empty(Event::where('id', $id)->first()->signature_third)) {
                $oldImage = Event::where('id', $id)->first()->signature_third;
                if (Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            $signatureThirdSavePath = '';
        } else {
            // Remove both signature since both are left unchecked.
            $signatureSecondMainName = '';
            $signatureSecondMainPosition = '';
            if (!empty(Event::where('id', $id)->first()->signature_second)) {
                $oldImage = Event::where('id', $id)->first()->signature_second;
                if (Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            $signatureSecondSavePath = '';

            $signatureThirdMainName = '';
            $signatureThirdMainPosition = '';
            if (!empty(Event::where('id', $id)->first()->signature_third)) {
                $oldImage = Event::where('id', $id)->first()->signature_third;
                if (Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            $signatureThirdSavePath = '';
        }

        // Background image

        // Check if background image is uploaded (since it's not required)
        if (!empty($request->input('background-image-check'))) {
            if ($request->hasFile('background-image')) {
                $backgroundImageName = $request->file('background-image')->getClientOriginalName();
                $backgroundImageImage = Image::make($request->file('background-image'))->resize(794, 1123)->encode('png');
                $backgroundImageSavePath = '/img/background_image/' . Carbon::now()->timestamp . '-' . $backgroundImageName;
                // Deletes old image
                if (!empty(Event::where('id', $id)->first()->background_image)) {
                    $oldImage = Event::where('id', $id)->first()->background_image;
                    if (Storage::disk('public')->exists($oldImage)) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
                Storage::disk('public')->put($backgroundImageSavePath, $backgroundImageImage);
            } else {
                // Uses old data from db
                if (!empty(Event::where('id', $id)->first()->background_image)) {
                    $backgroundImageSavePath = Event::where('id', $id)->first()->background_image;
                } else {
                    $backgroundImageSavePath = '';
                }
            }
        } else {
            $backgroundImageSavePath = '';
            // Deletes old image
            if (!empty(Event::where('id', $id)->first()->background_image)) {
                $oldImage = Event::where('id', $id)->first()->background_image;
                if (Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
        }

        Event::upsert([
            [
                'id' => $id,
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
                'orientation' => $certificateOrientation,
            ],
        ], ['id'], [
            'name',
            'date',
            'location',
            'organiser_name',
            'logo_first',
            'logo_second',
            'logo_third',
            'signature_first_name',
            'signature_first_position',
            'signature_first',
            'signature_second_name',
            'signature_second_position',
            'signature_second',
            'signature_third_name',
            'signature_third_position',
            'signature_third',
            'visibility',
            'background_image',
            'orientation',
        ]);

        $eventFontID = EventFont::select('id')->where('event_id', $id)->first()->id;

        EventFont::updateOrCreate(
            ['id' => $eventFontID, 'event_id' => $id],
            [
                'certificate_type_text_size' => $request->input('type-text-size'),
                'certificate_type_text_color' => $request->input('type-text-color'),
                'certificate_type_text_font' => $request->input('type-text-font'),
                'first_text_size' => $request->input('first-text-size'),
                'first_text_color' => $request->input('first-text-color'),
                'first_text_font' => $request->input('first-text-font'),
                'second_text_size' => $request->input('second-text-size'),
                'second_text_color' => $request->input('second-text-color'),
                'second_text_font' => $request->input('second-text-font'),
                'verifier_text_size' => $request->input('verifier-text-size'),
                'verifier_text_color' => $request->input('verifier-text-color'),
                'verifier_text_font' => $request->input('verifier-text-font'),
            ]
        );

        $request->session()->flash('updateEventSuccess', 'Acara berjaya dikemas kini!');

        return back();
    }

    public function removeEventCertificate(Request $request, $id)
    {
        // Make sure user is admin although middleware have cover this up
        if ('superadmin' == Auth::user()->role || 'admin' == Auth::user()->role) {
            if (Certificate::where('event_id', $id)->first()) {
                Certificate::where('event_id', $id)->delete();
                $request->session()->flash('removeAllCertificateSuccess', 'Semua sijil acara berjaya dibuang!');

                return back();
            } else {
                return back()->withErrors([
                    'removeAllCertificateEmpty' => 'Tiada sijil untuk acara ini!',
                ]);
            }
        } else {
            abort(403, 'Hanya pentadbir boleh mengakses laman ini!');
        }
    }
}
