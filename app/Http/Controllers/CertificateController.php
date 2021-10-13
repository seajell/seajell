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

use PDF;
use ZipArchive;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Event;
use App\Models\EventFont;
use Endroid\QrCode\QrCode;
use App\Models\Certificate;
use App\Models\EventLayout;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Color\Color;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Endroid\QrCode\Encoding\Encoding;
use App\Models\CertificateViewActivity;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\CertificateCollectionHistory;
use App\Models\CertificateCollectionDeletionSchedule;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use PhpOffice\PhpSpreadsheet\Reader\Exception as PHPSpreadsheetReaderException;

class CertificateController extends MainController
{
    public function authenticity(Request $request, $uid)
    {
        if (Certificate::where('uid', $uid)->first()) {
            $certificate = Certificate::select('users.fullname', 'certificates.uid', 'certificates.type', 'events.name', 'events.date', 'events.organiser_name', 'events.signature_first', 'events.signature_first_name', 'events.signature_first_position', 'events.signature_second', 'events.signature_second_name', 'events.signature_second_position', 'events.signature_third', 'events.signature_third_name', 'events.signature_third_position', 'certificates.position', 'certificates.category')->join('users', 'certificates.user_id', 'users.id')->join('events', 'certificates.event_id', 'events.id')->where('certificates.uid', $uid)->first();

            return view('certificate.authenticity')->with(['appVersion' => $this->appVersion, 'apiToken' => $this->apiToken, 'appName' => $this->appName, 'systemSetting' => $this->systemSetting, 'certificate' => $certificate]);
        } else {
            abort(404, 'Sijil tidak dijumpai.');
        }
    }

    public function addCertificateView(Request $request)
    {
        return view('certificate.add')->with(['appVersion' => $this->appVersion, 'apiToken' => $this->apiToken, 'appName' => $this->appName, 'systemSetting' => $this->systemSetting]);
    }

    public function certificateListView(Request $request)
    {
        $pagination = 15;
        // Check for filters and search
        if ($request->filled('sort_by') and $request->filled('sort_order') and $request->has('search')) {
            $sortBy = $request->sort_by;
            $sortOrder = $request->sort_order;
            $search = $request->search;
            if (!empty($search)) {
                switch ($search) {
                    case 'penghargaan':
                        $search = 'appreciation';
                        break;
                    case 'pencapaian':
                        $search = 'achievement';
                        break;
                    case 'penyertaan':
                        $search = 'participation';
                        break;
                    default:
                        $search = $search;
                        break;
                }
                if (Gate::allows('authAdmin')) {
                    $certificates = Certificate::join('users', 'certificates.user_id', 'users.id')->join('events', 'certificates.event_id', 'events.id')->select('certificates.uid', 'users.fullname', 'users.username', 'events.name', 'certificates.type', 'certificates.position', 'certificates.category')->where('certificates.uid', 'LIKE', "%{$search}%")->orWhere('users.fullname', 'LIKE', "%{$search}%")->orWhere('events.name', 'LIKE', "%{$search}%")->orWhere('certificates.type', 'LIKE', "%{$search}%")->orWhere('certificates.position', 'LIKE', "%{$search}%")->orWhere('certificates.category', 'LIKE', "%{$search}%")->orderBy($sortBy, $sortOrder)->paginate($pagination)->withQueryString();
                } else {
                    $certificates = Certificate::join('users', 'certificates.user_id', 'users.id')->join('events', 'certificates.event_id', 'events.id')->select('certificates.uid', 'users.fullname', 'users.username', 'events.name', 'certificates.type', 'certificates.position', 'certificates.category')->where('users.username', '=', Auth::user()->username)->where('certificates.uid', 'LIKE', "%{$search}%")->orWhere('users.fullname', 'LIKE', "%{$search}%")->orWhere('events.name', 'LIKE', "%{$search}%")->orWhere('certificates.type', 'LIKE', "%{$search}%")->orWhere('certificates.position', 'LIKE', "%{$search}%")->orWhere('certificates.category', 'LIKE', "%{$search}%")->orderBy($sortBy, $sortOrder)->paginate($pagination)->withQueryString();
                }
            } else {
                if (Gate::allows('authAdmin')) {
                    $certificates = Certificate::join('users', 'certificates.user_id', 'users.id')->join('events', 'certificates.event_id', 'events.id')->select('certificates.uid', 'users.fullname', 'users.username', 'events.name', 'certificates.type', 'certificates.position', 'certificates.category')->orderBy($sortBy, $sortOrder)->paginate($pagination)->withQueryString();
                } else {
                    $certificates = Certificate::join('users', 'certificates.user_id', 'users.id')->join('events', 'certificates.event_id', 'events.id')->select('certificates.uid', 'users.fullname', 'users.username', 'events.name', 'certificates.type', 'certificates.position', 'certificates.category')->where('users.username', '=', Auth::user()->username)->orderBy($sortBy, $sortOrder)->paginate($pagination)->withQueryString();
                }
            }
            $sortAndSearch = [
                'sortBy' => $sortBy,
                'sortOrder' => $sortOrder,
                'search' => $search,
            ];

            return view('certificate.list')->with(['sortAndSearch' => $sortAndSearch, 'certificates' => $certificates, 'appVersion' => $this->appVersion, 'apiToken' => $this->apiToken, 'appName' => $this->appName, 'systemSetting' => $this->systemSetting]);
        } else {
            if (Gate::allows('authAdmin')) {
                $certificates = Certificate::join('users', 'certificates.user_id', 'users.id')->join('events', 'certificates.event_id', 'events.id')->select('certificates.uid', 'users.fullname', 'users.username', 'events.name', 'certificates.type', 'certificates.position', 'certificates.category')->paginate($pagination)->withQueryString();
            } else {
                $certificates = Certificate::join('users', 'certificates.user_id', 'users.id')->join('events', 'certificates.event_id', 'events.id')->select('certificates.uid', 'users.fullname', 'users.username', 'events.name', 'certificates.type', 'certificates.position', 'certificates.category')->where('users.username', '=', Auth::user()->username)->paginate($pagination)->withQueryString();
            }

            return view('certificate.list')->with(['certificates' => $certificates, 'appVersion' => $this->appVersion, 'apiToken' => $this->apiToken, 'appName' => $this->appName, 'systemSetting' => $this->systemSetting]);
        }
    }

    public function updateCertificateView(Request $request, $uid)
    {
        if (Certificate::where('uid', $uid)->first()) {
            // Only admins can update certificates
            if (Gate::allows('authAdmin')) {
                $data = Certificate::where('uid', $uid)->join('events', 'certificates.event_id', '=', 'events.id')->first();

                return view('certificate.update')->with(['appVersion' => $this->appVersion, 'apiToken' => $this->apiToken, 'appName' => $this->appName, 'systemSetting' => $this->systemSetting, 'data' => $data]);
            } else {
                abort(403, 'Anda tidak boleh mengakses laman ini.');
            }
        } else {
            abort(404, 'Sijil tidak dijumpai.');
        }
    }

    public function addCertificate(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required'],
            'event-id' => ['required'],
            'certificate-type' => ['required'],
            'position' => ['required'],
        ]);

        $uidArray = Certificate::select('uid')->get();
        $uid = $this->generateUID(15, $uidArray);
        $username = strtolower($request->input('username'));
        $eventID = $request->input('event-id');
        $certificateType = strtolower($request->input('certificate-type'));
        $position = strtolower($request->input('position'));
        if (null !== $request->category && '' !== $request->category) {
            $category = $request->category;
        } else {
            $category = '';
        }
        // Recheck if username and event id is existed in case user doesn't input one that actually existed although with the JS help lel
        if (User::where('username', $username)->first()) {
            if (Event::where('id', $eventID)->first()) {
                $user = User::select('id', 'email')->where('username', $username)->first();
                Certificate::create([
                    'uid' => $uid,
                    'user_id' => $user->id,
                    'event_id' => $eventID,
                    'type' => $certificateType,
                    'position' => $position,
                    'category' => $category,
                ]);

                $eventName = Event::select('name')->where('id', $eventID)->first()->name;
                $userEmail = $user->email;

                // Sending Emails
                $emailDetailsArr = [
                    'eventName' => $eventName,
                    'certificateID' => $uid,
                ];

                seajell_send_mail(strtolower($userEmail), $emailDetailsArr, 'CertificateAddMail');

                $request->session()->flash('addCertificateSuccess', 'Sijil berjaya ditambah!');

                return back();
            } else {
                return back()->withInput()->withErrors([
                    'event-id' => 'ID Acara tidak dijumpai!',
                ]);
            }
        } else {
            return back()->withInput()->withErrors([
                'username' => 'Username Pengguna tidak dijumpai!',
            ]);
        }
    }

    public function addCertificateBulk(Request $request)
    {
        $validated = $request->validate([
            'certificate_list' => ['required', 'mimes:xlsx'],
        ]);
        $inputFile = $request->file('certificate_list');
        $reader = IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(true);
        $reader->setLoadSheetsOnly('1'); // Only read from worksheet named 1
        try {
            $spreadsheet = $reader->load($inputFile);
        } catch (PHPSpreadsheetReaderException $e) {
            exit('Error loading file: ' . $e->getMessage());
        }
        // Get all available rows. If a row is empty (in the username field), the rest of the row will be ignored. Warn the admin.
        $rows = $spreadsheet->getActiveSheet()->rangeToArray('B8:B507', null, false, false, true);

        // Check if event ID inserted and exist
        $eventID = $spreadsheet->getActiveSheet()->getCell('C6')->getValue();
        if (empty($eventID)) {
            return back()->withErrors([
                'sheetEventEmpty' => '[C6] ID acara kosong!',
            ]);
        }

        if (!Event::where('id', $eventID)->first()) {
            return back()->withErrors([
                'sheetEventNotFound' => '[C6] Acara tidak dijumpai!',
            ]);
        }

        if (empty($rows[8]['B'])) {
            return back()->withErrors([
                'sheetAtleastOne' => 'Sekurang-kurangnya satu data sijil diperlukan!',
            ]);
        }

        $availableRows = [];
        foreach ($rows as $row => $value) {
            if (!empty($value['B'])) {
                array_push($availableRows, $row);
            } else {
                // If one row is empty in the username field, all the following rows will be ignored.
                break;
            }
        }

        $certificateData = [];
        foreach ($availableRows as $row) {
            $data = $spreadsheet->getActiveSheet()->rangeToArray('B' . $row . ':E' . $row, null, false, false, true);
            array_push($certificateData, $data);
        }
        $spreadsheetErr = [];
        $validCertificateList = [];
        foreach ($certificateData as $dataIndex) {
            foreach ($dataIndex as $data) {
                $username = strtolower($data['B']);
                $type = $data['C'];
                $position = strtolower($data['D']);
                $category = strtolower($data['E']);
                $currentRow = key($dataIndex);

                // Check if user already
                if ('admin' == $username) {
                    // Check if adding user named 'admin'
                    $error = '[B' . $currentRow . '] ' . 'Anda tidak boleh menambah sijil untuk pengguna: admin!';
                    array_push($spreadsheetErr, $error);
                } elseif (!User::where('username', strtolower($username))->first()) {
                    // If user not found
                    $error = '[B' . $currentRow . '] ' . 'Pengguna dengan username tersebut tidak dijumpai!';
                    array_push($spreadsheetErr, $error);
                } else {
                    $userIDValid = User::select('id')->where('username', $username)->first()->id;
                    // Certificate type
                    if (empty($type)) {
                        $error = '[C' . $currentRow . '] ' . 'Ruangan jenis kosong!';
                        array_push($spreadsheetErr, $error);
                    } else {
                        // Check if type valid
                        // Only 1, 2 and 3 can be inserted for type
                        // 1 = participation
                        // 2 = achievement
                        // 3 = appreciation
                        if (1 == $type || 2 == $type || 3 == $type) {
                            switch ($type) {
                                case 1:
                                    $typeValid = 'participation';
                                    break;
                                case 2:
                                    $typeValid = 'achievement';
                                    break;
                                case 3:
                                    $typeValid = 'appreciation';
                                    break;
                                default:
                            }
                        } else {
                            $error = '[C' . $currentRow . '] ' . 'Hanya masukkan nombor yang diperlukan di ruangan jenis!';
                            array_push($spreadsheetErr, $error);
                        }
                    }

                    if (empty($position)) {
                        $error = '[D' . $currentRow . '] ' . 'Ruangan posisi kosong!';
                        array_push($spreadsheetErr, $error);
                    } else {
                        $positionValid = $position;
                    }

                    if (empty($category)) {
                        $categoryValid = null;
                    } else {
                        $categoryValid = $category;
                    }

                    // Check if all valid data have been set
                    if (!empty($userIDValid) && !empty($eventID) && !empty($typeValid) && !empty($positionValid)) {
                        $uidArray = Certificate::select('uid')->get();
                        $uid = $this->generateUID(15, $uidArray);
                        $validCertificate = [
                            'uid' => $uid,
                            'user_id' => $userIDValid,
                            'event_id' => $eventID,
                            'type' => $typeValid,
                            'position' => $positionValid,
                            'category' => $categoryValid,
                        ];
                        array_push($validCertificateList, $validCertificate);
                    }
                }
            }
        }
        // If if there's no problem with the spreadsheet, if doesn't, proceed to add the users.
        if (count($spreadsheetErr) > 0) {
            $request->session()->flash('spreadsheetErr', $spreadsheetErr);

            return back();
        } else {
            foreach ($validCertificateList as $validCertificate) {
                Certificate::updateOrCreate(
                    ['uid' => $validCertificate['uid']],
                    [
                        'user_id' => $validCertificate['user_id'],
                        'event_id' => $validCertificate['event_id'],
                        'type' => $validCertificate['type'],
                        'position' => $validCertificate['position'],
                        'category' => $validCertificate['category'],
                    ]
                );

                $eventName = Event::select('name')->where('id', $eventID)->first()->name;
                $userEmail = User::select('email')->where('id', $validCertificate['user_id'])->first()->email;

                // Sending Emails
                $emailDetailsArr = [
                    'eventName' => $eventName,
                    'certificateID' => $validCertificate['uid'],
                ];

                seajell_send_mail(strtolower($userEmail), $emailDetailsArr, 'CertificateAddMail');
            }
            // Certificate::upsert($validCertificateList, ['uid'], ['uid', 'user_id', 'event_id', 'type', 'position', 'category']);
            $request->session()->flash('spreadsheetSuccess', count($validCertificateList) . ' sijil berjaya ditambah secara pukal!');

            return back();
        }
    }

    // Generate unique UID for certificates
    protected function generateUID($length, $uidArray)
    {
        $uid = Str::random($length);
        if (count($uidArray) > 0) {
            for ($i = 0; $i < count($uidArray); ++$i) {
                $dbUID = $uidArray[$i]->uid;
                while ($uid == $dbUID) {
                    $uid = Str::random($length);
                }
            }
        } else {
            $uid = Str::random($length);
        }

        return $uid;
    }

    public function removeCertificate(Request $request)
    {
        $uid = $request->input('certificate-id');
        $certificate = Certificate::where('uid', $uid);
        $certificate->delete();
        $request->session()->flash('removeCertificateSuccess', 'Sijil berjaya dibuang!');

        return back();
    }

    public function updateCertificate(Request $request, $uid)
    {
        $validated = $request->validate([
            'user-id' => ['required'],
            'event-id' => ['required'],
            'certificate-type' => ['required'],
            'position' => ['required'],
        ]);

        if (null !== $request->category && '' !== $request->category) {
            $category = $request->category;
        } else {
            $category = '';
        }

        $eventID = $request->input('event-id');
        $certificateType = strtolower($request->input('certificate-type'));
        $position = strtolower($request->input('position'));

        // Recheck if username and event id is existed in case user doesn't input one that actually existed although with the JS help lel
        if (User::where('id', $request->input('user-id'))->first()) {
            if (Event::where('id', $eventID)->first()) {
                Certificate::updateOrCreate(
                    ['uid' => $uid],
                    [
                        'user_id' => $request->input('user-id'),
                        'event_id' => $eventID,
                        'type' => $certificateType,
                        'position' => $position,
                        'category' => $category,
                    ]
                );
                $request->session()->flash('updateCertificateSuccess', 'Sijil berjaya dikemas kini!');

                return back();
            } else {
                return back()->withInput()->withErrors([
                    'event-id' => 'ID Acara tidak dijumpai!',
                ]);
            }
        } else {
            return back()->withInput()->withErrors([
                'username' => 'Username Pengguna tidak dijumpai!',
            ]);
        }
    }

    public function certificateView(Request $request, $uid)
    {
        if (Certificate::where('uid', $uid)->first()) {
            $certEvent = Certificate::where('uid', $uid)->first()->event;
            $certID = Certificate::select('id')->where('uid', $uid)->first()->id;
            // Add view activity history
            CertificateViewActivity::create([
                'certificate_id' => $certID,
                'ip_address' => $request->ip(),
                'http_user_agent' => $request->server('HTTP_USER_AGENT'),
            ]);
            // Check for event visibility
            switch ($certEvent->visibility) {
                case 'public':
                    // Certificate PDF generated will have QR code with the URL to the certificate in it
                    return $this->generateCertificateHTML($uid, 'stream');
                    break;
                case 'hidden':
                    // Check if logged in
                    if (Auth::check()) {
                        if (Gate::allows('authAdmin') || Certificate::where('uid', $uid)->first()->user_id == Auth::user()->id) {
                            return $this->generateCertificateHTML($uid, 'stream');
                        } else {
                            return redirect()->route('home');
                        }
                    } else {
                        return redirect()->route('home');
                    }
                    break;
                default:
                    break;
            }
        } else {
            abort(404, 'Sijil tidak dijumpai.');
        }
    }

    protected function generateCertificateHTML($certificateID, $mode = 'stream', $savePath = null)
    {
        $certificateFileName = 'SeaJell_e_Certificate_' . $certificateID . '.pdf';
        $eventID = Certificate::select('event_id')->where('uid', $certificateID)->first()->event_id;
        $eventData = Event::where('id', $eventID)->first();
        $eventFontData = EventFont::where('event_id', $eventID)->first();
        $eventLayoutData = EventLayout::where('event_id', $eventID)->first();
        $certificateData = Certificate::select('certificates.uid', 'users.fullname', 'users.identification_number', 'certificates.position', 'certificates.category', 'certificates.type')->where('uid', $certificateID)->join('users', 'certificates.user_id', '=', 'users.id')->first();

        $eventFontImages = [
            'backgroundImage' => $this->cacheDataURLImage($eventData->background_image, 1050, 1485),
            'logoFirst' => $this->cacheDataURLImage($eventData->logo_first, 300, 300),
            'logoSecond' => $this->cacheDataURLImage($eventData->logo_second, 300, 300),
            'logoThird' => $this->cacheDataURLImage($eventData->logo_third, 300, 300),
            'signatureFirst' => $this->cacheDataURLImage($eventData->signature_first, 300, 100),
            'signatureSecond' => $this->cacheDataURLImage($eventData->signature_second, 300, 100),
            'signatureThird' => $this->cacheDataURLImage($eventData->signature_third, 300, 100),
        ];

        /**
         * QR Code with Endroid QR Code Library.
         */
        $writer = new PngWriter();

        $qrCodeData = url('certificate/authenticity/' . $certificateID);
        // Create QR code
        $qrCode = QrCode::create($qrCodeData)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(300)
            ->setMargin(3)
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));
        if (!empty($this->systemSetting->logo)) {
            $qrLogoPath = storage_path('app/public' . $this->systemSetting->logo);
        } else {
            $qrLogoPath = storage_path('app/public/logo/SeaJell-Logo.png');
        }

        $qrLogo = Logo::create($qrLogoPath)
            ->setResizeToWidth(50);

        $result = $writer->write($qrCode, $qrLogo);
        $qrCodeDataURI = $result->getDataUri();

        $viewData = ['appVersion' => $this->appVersion, 'apiToken' => $this->apiToken, 'appName' => $this->appName, 'systemSetting' => $this->systemSetting, 'eventData' => $eventData, 'eventFontData' => $eventFontData, 'eventLayoutData' => $eventLayoutData, 'certificateData' => $certificateData, 'qrCodeDataURI' => $qrCodeDataURI, 'eventFontImages' => $eventFontImages];

        // Only allows self-signed certificate if APP_DEBUG environment variable is set to true
        if (!empty(env('APP_DEBUG')) && true == env('APP_DEBUG')) {
            $pdf = PDF::getFacadeRoot();
            $dompdf = $pdf->getDomPDF();
            $dompdf->setHttpContext(stream_context_create([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ]));
        } else {
            $pdf = PDF::getFacadeRoot();
        }

        switch ($eventData->orientation) {
            case 'P':
                $paperOrientation = 'potrait';
                break;
            case 'L':
                $paperOrientation = 'landscape';
                break;
            default:
                $paperOrientation = 'potrait';
                break;
        }

        // Check whether wanna save or stream the certificate
        switch ($mode) {
            case 'stream':
                return $pdf->loadView('certificate.layout', $viewData)->setPaper('a4', $paperOrientation)->setWarnings(true)->stream($certificateFileName);
            case 'save':
                $fullPath = $savePath . 'SeaJell_e_Certificate_' . $certificateID . '.pdf';
                PDF::loadView('certificate.layout', $viewData)->setPaper('a4', $paperOrientation)->setWarnings(false)->save($fullPath);
                // no break
            default:
                return $pdf->loadView('certificate.layout', $viewData)->setPaper('a4', $paperOrientation)->setWarnings(false)->stream($certificateFileName);
        }
    }

    protected function saveCertificateCollection($request, $certificates, $folderFor, $historyDataUser, $historyDataEvent)
    {
        $currentTimestamp = Carbon::now()->timestamp;
        $folderName = $folderFor . $currentTimestamp; // Folder name to save all certificate in storage/app/certificate folder
        $savePath = storage_path('app/certificate/' . $folderName . '/');
        Storage::disk('local')->makeDirectory('/certificate/' . $folderName);
        // Saves all certificates relating to user to storage/app/certificate folder
        foreach ($certificates as $certificate) {
            $this->generateCertificateHTML($certificate->uid, 'save', $savePath);
        }
        // Archive all certificates to a zip file
        $zipName = $folderName . '.zip';
        $zip = new ZipArchive;
        $zipSavePath = storage_path('app/certificate/' . $folderName . '/' . $zipName);
        if (true === $zip->open($zipSavePath, ZipArchive::CREATE)) {
            $files = Storage::disk('local')->files('/certificate/' . $folderName);
            foreach ($files as $key => $value) {
                $fileNameInZip = basename($value);
                $filePath = storage_path('app/') . $value;
                $zip->addFile($filePath, $fileNameInZip);
            }

            $zip->close();
        }
        $downloadZipPath = asset('certificate/' . $folderName . '/' . $folderName . '.zip');
        // Certificates Total
        $certificatesTotal = $certificates->count();
        // Current Date and Next 24 hour
        $currentDateTime = Carbon::now()->toDateTimeString();
        $next24HourDateTime = Carbon::parse($currentDateTime)->addDays(1);
        CertificateCollectionHistory::create([
            'requested_by' => Auth::user()->id,
            'requested_on' => $currentDateTime,
            'next_available_download' => $next24HourDateTime,
            'user_id' => $historyDataUser,
            'event_id' => $historyDataEvent,
            'certificates_total' => $certificatesTotal,
        ]);
        CertificateCollectionDeletionSchedule::create([
            'folder_name' => $folderName,
            'delete_after' => $next24HourDateTime,
        ]);

        return $downloadZipPath;
    }

    public function downloadCertificateCollection(Request $request)
    {
        /*
         * Admin can download all certificates for a participant or an event.
         * Participant can download certificates only for themselves.
         * Downloads for event or user is limited to the user who tries to download it to every 24 hours.
         */
        if (Gate::allows('authAdmin')) {
            // Admin tries to download
            $validated = $request->validate([
                'id_username' => ['required'],
            ]);
            if ($request->has('collection_download_options')) {
                switch ($request->input('collection_download_options')) {
                    case 'participant':
                        if (User::where('role', 'participant')->where('username', strtolower($request->input('id_username')))->first()) {
                            // Checks if certificate exist.
                            if (Certificate::join('users', 'certificates.user_id', 'users.id')->where('users.username', strtolower($request->input('id_username')))->first()) {
                                // Check for download limit
                                $participantID = User::select('id')->where('username', strtolower($request->input('id_username')))->first()->id;
                                $certificates = Certificate::join('users', 'certificates.user_id', 'users.id')->where('users.username', strtolower($request->input('id_username')))->select('certificates.uid')->get();
                                $folderFor = 'user_';
                                $historyDataUser = User::select('id')->where('username', strtolower($request->input('id_username')))->first()->id;
                                $historyDataEvent = null;
                                // If collection download is for a user and is done by current authenticated user
                                if (CertificateCollectionHistory::where('user_id', $participantID)->where('requested_by', Auth::user()->id)->first()) {
                                    $latestRequest = CertificateCollectionHistory::where('user_id', $participantID)->where('requested_by', Auth::user()->id)->latest('requested_on')->first();
                                    if (Carbon::now()->toDateTimeString() > $latestRequest->next_available_download) {
                                        // If the date already passed the last download for 24 hour
                                        $request->session()->flash('collectionDownloadSuccessPath', $this->saveCertificateCollection($request, $certificates, $folderFor, $historyDataUser, $historyDataEvent));

                                        return back();
                                    } else {
                                        return back()->withErrors([
                                            'collectionLimit' => $latestRequest->next_available_download,
                                        ]);
                                    }
                                } else {
                                    // No old download history
                                    $request->session()->flash('collectionDownloadSuccessPath', $this->saveCertificateCollection($request, $certificates, $folderFor, $historyDataUser, $historyDataEvent));

                                    return back();
                                }
                            } else {
                                return back()->withErrors([
                                    'collectionNoCertificate' => 'Tiada sijil untuk koleksi tersebut!',
                                ]);
                            }
                        } else {
                            return back()->withErrors([
                                'collectionUserNotFound' => 'Peserta tidak wujud!',
                            ]);
                        }
                        break;
                    case 'event':
                        if (Event::where('id', $request->input('id_username'))->first()) {
                            // Checks if certificate exist
                            if (Certificate::where('event_id', $request->input('id_username'))->first()) {
                                // Check for download limit
                                $certificates = Certificate::where('event_id', $request->input('id_username'))->select('certificates.uid')->get();
                                $folderFor = 'event_';
                                $historyDataUser = null;
                                $historyDataEvent = $request->input('id_username');
                                if (CertificateCollectionHistory::where('event_id', $request->input('id_username'))->first()) {
                                    $latestRequest = CertificateCollectionHistory::where('event_id', $request->input('id_username'))->latest('requested_on')->first();
                                    if (Carbon::now()->toDateTimeString() > $latestRequest->next_available_download) {
                                        // If the date already passed the last download for 24 hour
                                        $request->session()->flash('collectionDownloadSuccessPath', $this->saveCertificateCollection($request, $certificates, $folderFor, $historyDataUser, $historyDataEvent));

                                        return back();
                                    } else {
                                        return back()->withErrors([
                                            'collectionLimit' => $latestRequest->next_available_download,
                                        ]);
                                    }
                                } else {
                                    // No old download history
                                    $request->session()->flash('collectionDownloadSuccessPath', $this->saveCertificateCollection($request, $certificates, $folderFor, $historyDataUser, $historyDataEvent));

                                    return back();
                                }
                            }
                        } else {
                            return back()->withErrors([
                                'collectionEventNotFound' => 'Acara tidak wujud!',
                            ]);
                        }
                        break;
                    default:
                        return redirect()->back();
                }
            }
        } elseif (!Gate::allows('authAdmin')) {
            // Participant downloads collection for themself
            if (Certificate::where('user_id', Auth::user()->id)->first()) {
                // Check for download limit
                $participantID = Auth::user()->id;
                $certificates = Certificate::where('user_id', $participantID)->select('certificates.uid')->get();
                $folderFor = 'user_';
                $historyDataUser = $participantID;
                $historyDataEvent = null;
                // If collection download is for a user and is done by current authenticated user
                if (CertificateCollectionHistory::where('user_id', $participantID)->where('requested_by', Auth::user()->id)->first()) {
                    $latestRequest = CertificateCollectionHistory::where('user_id', $participantID)->where('requested_by', Auth::user()->id)->latest('requested_on')->first();
                    if (Carbon::now()->toDateTimeString() > $latestRequest->next_available_download) {
                        // If the date already passed the last download for 24 hour
                        $request->session()->flash('collectionDownloadSuccessPath', $this->saveCertificateCollection($request, $certificates, $folderFor, $historyDataUser, $historyDataEvent));

                        return back();
                    } else {
                        return back()->withErrors([
                            'collectionLimit' => $latestRequest->next_available_download,
                        ]);
                    }
                } else {
                    // No old download history
                    $request->session()->flash('collectionDownloadSuccessPath', $this->saveCertificateCollection($request, $certificates, $folderFor, $historyDataUser, $historyDataEvent));

                    return back();
                }
            } else {
                return back()->withErrors([
                    'collectionNoCertificate' => 'Tiada sijil untuk koleksi tersebut!',
                ]);
            }
        } else {
            return redirect()->back();
        }
    }
}
