<?php

namespace App\Http\Controllers;

use PDF;
use TCPDF_FONTS;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Event;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\MainController;

class CertificateController extends MainController
{
    public function addCertificateView(Request $request){
        return view('certificate.add')->with(['apiToken' => $this->apiToken]);
    }
    public function certificateListView(Request $request){
        if(Gate::allows('authAdmin')){
            $certificates = Certificate::select('certificates.id', 'certificates.type', 'certificates.position', 'users.fullname', 'events.name')->join('users', 'certificates.user_id', '=', 'users.id')->join('events', 'certificates.event_id', '=', 'events.id')->paginate(7);
            return view('certificate.list')->with(['certificates' => $certificates, 'apiToken' => $this->apiToken]);
        }else{
            $certificates = Certificate::select('certificates.id', 'certificates.type', 'certificates.position', 'users.fullname', 'events.name')->join('users', 'certificates.user_id', '=', 'users.id')->join('events', 'certificates.event_id', '=', 'events.id')->where('username', Auth::user()->username)->paginate(7);
            return view('certificate.list')->with(['certificates' => $certificates, 'apiToken' => $this->apiToken]);
        }
    }
    public function addCertificate(Request $request){
        $validated = $request->validate([
            'username' => ['required'],
            'event-id' => ['required'],
            'certificate-type' => ['required'],
            'position' => ['required']
        ]);

        $username = strtolower($request->input('username'));
        $eventID = $request->input('event-id');
        $certificateType = strtolower($request->input('certificate-type'));
        $position = strtolower($request->input('position'));

        // Recheck if username and event id is existed in case user doesn't input one that actually existed although with the JS help lel
        if(User::where('username', $username)->first()){
            if(Event::where('id', $eventID)->first()){
                $userID = User::select('id')->where('username', $username)->first()->id;
                Certificate::create([
                    'user_id' => $userID,
                    'event_id' => $eventID,
                    'type' => $certificateType,
                    'position' => $position
                ]);
                $request->session()->flash('addCertificateSuccess', 'Sijil berjaya ditambah!');
                return back();
            }else{
                return back()->withInput()->withErrors([
                    'event-id' => 'ID Acara tidak dijumpai!'
                ]);
            }
        }else{
            return back()->withInput()->withErrors([
                'username' => 'Username Pengguna tidak dijumpai!'
            ]);
        }
    }
    public function certificateView(Request $request, $id){
        $certEvent = Certificate::find($id)->event;

        // Check for event visibility
        switch ($certEvent->visibility) {
            case 'public':
                // Certificate PDF generated will have QR code with the URL to the certificate in it
                $this->generateCertificate($request, $id, $QRCode = TRUE);
                break;
            case 'hidden':
                if(Gate::allows('authAdmin') || Certificate::find($id)->user_id == Auth::user()->id){
                    $this->generateCertificate($request, $id);
                }else{
                    return redirect()->route('home');
                }
                break;
            default:
                break;
        }
    }
    protected function generateCertificate($request, $certificateID, $QRCode = FALSE, $backgroundColor = array(255, 254, 212)){
        $certUser = Certificate::find($certificateID)->user;
        $certEvent = Certificate::find($certificateID)->event;

        $userFullname = strtoupper($certUser->fullname);
        $userIdentificationNumber = $certUser->identification_number;
        $eventName = strtoupper($certEvent->name);
        $dateExploded = explode("-", $certEvent->date);
        $eventDate = $dateExploded[2] . '/' . $dateExploded[1] . '/' . $dateExploded[0];
        $eventLocation = strtoupper($certEvent->location);
        $eventOrganiserName = strtoupper($certEvent->organiser_name);
        $certificateType = Certificate::find($certificateID)->type;
        $certificationPosition = strtoupper(Certificate::find($certificateID)->position);
        $certificationVerifierName = strtoupper(Certificate::find($certificateID)->event->verifier_name);
        $certificationVerifierPosition = strtoupper(Certificate::find($certificateID)->event->verifier_position);
        $certificationVerifierSignaturePath = Certificate::find($certificateID)->event->verifier_signature;
        $organiserLogoPath = $certEvent->organiser_logo;
        $instituteLogoPath = $certEvent->institute_logo;
        // Generate the certificate

        // Try to find way to add custom fonts
        $title = 'SeaJell';
        PDF::SetCreator('SeaJell');
        PDF::SetAuthor('SeaJell');
        switch ($certificateType) {
            case 'participation':
                $certificateTypeText = 'Sijil Penyertaan';
                break;
            case 'achievement':
                $certificateTypeText = 'Sijil Pencapaian';
                break;
            case 'appreciation':
                $certificateTypeText = 'Sijil Penghargaan';
                break;
            default:
                break;
        }
        PDF::SetTitle($title . ' - ' . $certificateTypeText);
        PDF::AddPage();
        PDF::SetMargins(25, 25, 25, true);
        PDF::setPageMark();

        //Background color
        PDF::Rect(0, 0, 2000, 300,'F', array(), $backgroundColor);

        // Border
        $backgroundBorder = array('width' => 5, 'color' => array(255, 0, 255));
        PDF::Rect(25, 15, 160, 270,'F', $backgroundBorder, array());
        $borderStyle = array('width' => 1, 'color' => array(252, 186, 3));
        PDF::Rect(25, 15, 160, 270, 'D', array('all' => $borderStyle));

        // Custom fonts
        PDF::addFont('cookie');
        PDF::addFont('badscript');
        PDF::addFont('bebasneue');
        /**
         * Logos
         * Check if institute logo is available
         */
        if($instituteLogoPath !== '' && $instituteLogoPath !== NULL){
            if(Storage::disk('public')->exists($organiserLogoPath)){
                $organiserLogo = '.' . Storage::disk('local')->url($organiserLogoPath);
            }
            if(Storage::disk('public')->exists($instituteLogoPath)){
                $instituteLogo = '.' . Storage::disk('local')->url($instituteLogoPath);
            }
            PDF::Image($organiserLogo, $x = 58, $y = 20, $w = 30, $h = 30);
            PDF::Image($instituteLogo, $x = 121, $y = 20, $w = 30, $h = 30);
        }else{
            if(Storage::disk('public')->exists($organiserLogoPath)){
                $organiserLogo = '.' . Storage::disk('local')->url($organiserLogoPath);
            }
            PDF::Image($organiserLogo, $x = 85, $y = 20, $w = 30, $h = 30);
        }

        PDF::Ln(40);
        PDF::SetFont('cookie', 'BI', 45);
        PDF::Cell($w = 0, $h = 1, $txt = $certificateTypeText, $align = 'C', $border = '1', $calign = 'C');

        switch ($certificateType) {
            case 'participation':
                $certificateIntro = 'Adalah dengan ini diakui bahawa';
                break;
            case 'achievement':
                $certificateIntro = 'Setinggi-tinggi tahniah diucapkan kepada';
                break;
            case 'appreciation':
                $certificateIntro = 'Setinggi-tinggi penghargaan dan terima kasih kepada';
                break;
            default:
                break;
        }
        
        PDF::Ln(5);
        PDF::SetFont('badscript', 'I', 13);
        PDF::Cell($w = 0, $h = 1, $txt = $certificateIntro, $align = 'C', $border = '1', $calign = 'C');

        PDF::SetFont('bebasneue', 'B', 13);
        PDF::MultiCell(0, 1, $userFullname, 0, 'C');


        PDF::SetFont('bebasneue', 'B', 13);
        PDF::Cell($w = 0, $h = 1, $txt = '(' . $userIdentificationNumber . ')', $align = 'C', $border = '1', $calign = 'C');
        switch ($certificateType) {
            case 'participation':
                PDF::Ln(10);
                PDF::SetFont('badscript', 'I', 13);
                PDF::Cell($w = 0, $h = 1, $txt = 'Telah menyertai', $align = 'C', $border = '1', $calign = 'C');

                PDF::SetFont('bebasneue', 'B', 13);
                PDF::MultiCell(0, 1, $eventName, 0, 'C');
                break;
            case 'achievement':
                PDF::Ln(10);
                PDF::SetFont('badscript', 'I', 13);
                PDF::Cell($w = 0, $h = 1, $txt = 'Di atas pencapaian', $align = 'C', $border = '1', $calign = 'C');

                PDF::SetFont('bebasneue', 'B', 13);
                PDF::Cell($w = 0, $h = 1, $txt = $certificationPosition, $align = 'C', $border = '1', $calign = 'C');
                
                PDF::Ln();
                PDF::SetFont('badscript', 'I', 13);
                PDF::Cell($w = 0, $h = 1, $txt = 'Dalam', $align = 'C', $border = '1', $calign = 'C');

                PDF::SetFont('bebasneue', 'B', 13);
                PDF::MultiCell(0, 1, $eventName, 0, 'C');
                break;
            case 'appreciation':
                PDF::Ln(10);
                PDF::SetFont('badscript', 'I', 13);
                PDF::Cell($w = 0, $h = 1, $txt = 'atas sumbangan dan komitmen sebagai', $align = 'C', $border = '1', $calign = 'C');

                PDF::SetFont('bebasneue', 'B', 13);
                PDF::Cell($w = 0, $h = 1, $txt = $certificationPosition, $align = 'C', $border = '1', $calign = 'C');
                
                PDF::Ln();
                PDF::SetFont('badscript', 'I', 13);
                PDF::Cell($w = 0, $h = 1, $txt = 'Dalam', $align = 'C', $border = '1', $calign = 'C');

                PDF::SetFont('bebasneue', 'B', 13);
                PDF::MultiCell(0, 1, $eventName, 0, 'C');
                break;
            default:
                break;
        }
        

        PDF::Ln(10);
        PDF::SetFont('badscript', 'I', 13);
        PDF::Cell($w = 0, $h = 1, $txt = 'Pada', $align = 'C', $border = '1', $calign = 'C');

        PDF::SetFont('bebasneue', 'B', 13);
        PDF::MultiCell(0, 1, $eventDate, 0, 'C');

        PDF::Ln(10);
        PDF::SetFont('badscript', 'I', 13);
        PDF::Cell($w = 0, $h = 1, $txt = 'Bertempat di', $align = 'C', $border = '1', $calign = 'C');
        PDF::SetFont('bebasneue', 'B', 13);
        PDF::MultiCell(0, 0, $eventLocation, 0, 'C');

        PDF::Ln(10);
        PDF::SetFont('badscript', 'I', 13);
        PDF::Cell($w = 0, $h = 1, $txt = 'Anjuran', $align = 'C', $border = '1', $calign = 'C');
        PDF::SetFont('bebasneue', 'B', 13);
        PDF::MultiCell(0, 0, $eventOrganiserName, 0, 'C');

        /**
         * Signature
         */


        if(Storage::disk('public')->exists($certificationVerifierSignaturePath)){
            $certificationVerifierSignature = '.' . Storage::disk('local')->url($certificationVerifierSignaturePath);
        }
        PDF::Image($certificationVerifierSignature, $x = 40, $y = 225, $w = 39, $h = 13);

        PDF::SetFont('bebasneue', '', 12);
        PDF::SetXY(40, 235);
        PDF::MultiCell($w = 0, $h = 1, $txt = '...............................................', $align = 'C', $border = "1", $calign = 'C');
        PDF::MultiCell($w = 100, $h = 0, $txt = '(' . $certificationVerifierName . ')', 0, 'L', 0, 0, 40);
        PDF::Ln();
        PDF::MultiCell($w = 100, $h = 0, $txt = $certificationVerifierPosition, 0, 'L', 0, 0, 40);

        // Generate QR Code if visibility is set to TRUE
        switch ($QRCode) {
            case TRUE:
                $style = array(
                    'border' => 0,
                    'vpadding' => 0.5,
                    'hpadding' => 0.5,
                    'fgcolor' => array(0,0,0),
                    'bgcolor' => array(),
                    'module_width' => 1, 
                    'module_height' => 1
                );
                PDF::write2DBarcode(url()->current(), 'QRCODE,Q', 145, 240, 30, 30, $style, 'N');
                break;
            case FALSE:
                break;
            default:
                break;
        }

        PDF::Output('SeaJell_e_Certificate.pdf', 'I');
        PDF::reset();
    }
}