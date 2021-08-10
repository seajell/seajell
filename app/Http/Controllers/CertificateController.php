<?php

namespace App\Http\Controllers;

use PDF;
use TCPDF_FONTS;
use TCPDF_COLORS;
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
        return view('certificate.add')->with(['apiToken' => $this->apiToken, 'appName' => $this->appName, 'orgName' => $this->orgName]);
    }
    public function certificateListView(Request $request){
        if(Gate::allows('authAdmin')){
            $certificates = Certificate::select('certificates.id', 'certificates.type', 'certificates.position', 'users.fullname', 'events.name')->join('users', 'certificates.user_id', '=', 'users.id')->join('events', 'certificates.event_id', '=', 'events.id')->paginate(7);
            return view('certificate.list')->with(['certificates' => $certificates, 'apiToken' => $this->apiToken, 'appName' => $this->appName, 'orgName' => $this->orgName]);
        }else{
            $certificates = Certificate::select('certificates.id', 'certificates.type', 'certificates.position', 'users.fullname', 'events.name')->join('users', 'certificates.user_id', '=', 'users.id')->join('events', 'certificates.event_id', '=', 'events.id')->where('username', Auth::user()->username)->paginate(7);
            return view('certificate.list')->with(['certificates' => $certificates, 'apiToken' => $this->apiToken, 'appName' => $this->appName, 'orgName' => $this->orgName]);
        }
    }

    public function updateCertificateView(Request $request, $id){
        if(Certificate::where('id', $id)->first()){
            // Only admins can update certificates
            if(Gate::allows('authAdmin')){
                $data = Certificate::where('id', $id)->first();
                return view('certificate.update')->with(['apiToken' => $this->apiToken, 'appName' => $this->appName, 'orgName' => $this->orgName, 'data' => $data]);
            }else{
                abort(403, 'Anda tidak boleh mengakses laman ini.');
            }
        }else{
            abort(404, 'Sijil tidak dijumpai.');
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

    public function removeCertificate(Request $request){
        $id = $request->input('certificate-id');
        $certificate = Certificate::where('id', $id);
        $certificate->delete();
        $request->session()->flash('removeCertificateSuccess', 'Sijil berjaya dibuang!');
        return back();
    }

    public function updateCertificate(Request $request, $id){
        $validated = $request->validate([
            'user-id' => ['required'],
            'event-id' => ['required'],
            'certificate-type' => ['required'],
            'position' => ['required']
        ]);

        $eventID = $request->input('event-id');
        $certificateType = strtolower($request->input('certificate-type'));
        $position = strtolower($request->input('position'));

        // Recheck if username and event id is existed in case user doesn't input one that actually existed although with the JS help lel
        if(User::where('id', $request->input('user-id'))->first()){
            if(Event::where('id', $eventID)->first()){
                Certificate::updateOrCreate(
                    ['id' => $id],
                    [
                        'user_id' => $request->input('user-id'),
                        'event_id' => $eventID,
                        'type' => $certificateType,
                        'position' => $position
                    ]
                );
                $request->session()->flash('updateCertificateSuccess', 'Sijil berjaya dikemas kini!');
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
        $borderAvailability = $certEvent->border;
        $borderHexColor = $certEvent->border_color;
        
        // Check if border is gonna be used from the database
        switch ($borderAvailability) {
            case 'available':
                $borderStatus = TRUE;
                break;
            case 'unavailable':
                $borderStatus = FALSE;
                break;
            default:
                break;
        }
        // Check for event visibility
        switch ($certEvent->visibility) {
            case 'public':
                // Certificate PDF generated will have QR code with the URL to the certificate in it
                $this->generateCertificate($request, $id, array(255, 254, 212), $borderStatus, $borderHexColor);
                break;
            case 'hidden':
                // Check if logged in
                if(Auth::check()){
                    if(Gate::allows('authAdmin') || Certificate::find($id)->user_id == Auth::user()->id){
                        $this->generateCertificate($request, $id, array(255, 254, 212), $borderStatus, $borderHexColor);
                    }else{
                        return redirect()->route('home');
                    }
                }else{
                    return redirect()->route('home');
                }
                break;
            default:
                break;
        }
    }
    protected function generateCertificate($request, $certificateID, $backgroundColor = array(255, 254, 212), $border = FALSE, $borderColor = '#000'){
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
        $backgroundImagePath = $certEvent->background_image;

        // Generate the certificate

        // Try to find way to add custom fonts
        $title = $this->orgName . ' - ' . 'SeaJell';
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
        PDF::SetMargins(0, 0, 0, true);
        PDF::SetAutoPageBreak(false, 0);
        PDF::setPageMark();

        /**
         * Background Color/Image
         * 
         * Check if no background image added.
         */

        if($certEvent->background_image != '' AND $certEvent->background_image != NULL){
            if(Storage::disk('public')->exists($backgroundImagePath)){
                $backgroundImage = '.' . Storage::disk('local')->url($backgroundImagePath);
            }
            //PDF::Image($backgroundImage, 0, 0, 350, 437, '', '', '', false, 300, '', false, false, 0);
            PDF::Image($backgroundImage, 0, 0, 210, 297, '', '', '', false, 600, '', false, false, 0);
        }else{
            PDF::Rect(0, 0, 210, 297,'F', array(), $backgroundColor);
        }
        

        // Border
        switch ($border) {
            case TRUE:
                $borderColor = TCPDF_COLORS::convertHTMLColorToDec($borderColor, TCPDF_COLORS::$spotcolor);
                $backgroundBorder = array('width' => 5, 'color' => array(255, 0, 255));
                $borderStyle = array('width' => 1, 'color' => $borderColor);
                PDF::Rect(25, 15, 160, 270, 'D', array('all' => $borderStyle));
                break;
            case FALSE:
                break;
            default:
                break;
        }

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
            PDF::Image($organiserLogo, $x = 90, $y = 20, $w = 30, $h = 30);
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
        PDF::MultiCell(160, 0, $userFullname, 0, 'C', 0, 1, 25);

        PDF::SetFont('bebasneue', 'B', 13);
        PDF::Cell($w = 0, $h = 1, $txt = '(' . $userIdentificationNumber . ')', $align = 'C', $border = '1', $calign = 'C');
        switch ($certificateType) {
            case 'participation':
                PDF::Ln(10);
                PDF::SetFont('badscript', 'I', 13);
                PDF::Cell($w = 0, $h = 1, $txt = 'Telah menyertai', $align = 'C', $border = '1', $calign = 'C');

                PDF::SetFont('bebasneue', 'B', 13);
                PDF::MultiCell(160, 0, $eventName, 0, 'C', 0, 1, 25);
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
                PDF::MultiCell(160, 0, $eventName, 0, 'C', 0, 1, 25);
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
                PDF::MultiCell(160, 0, $eventName, 0, 'C', 0, 1, 25);
                break;
            default:
                break;
        }
        

        PDF::Ln(10);
        PDF::SetFont('badscript', 'I', 13);
        PDF::Cell($w = 0, $h = 1, $txt = 'Pada', $align = 'C', $border = '1', $calign = 'C');

        PDF::SetFont('bebasneue', 'B', 13);
        PDF::MultiCell(160, 0, $eventDate, 0, 'C', 0, 1, 25);

        PDF::Ln(10);
        PDF::SetFont('badscript', 'I', 13);
        PDF::Cell($w = 0, $h = 1, $txt = 'Bertempat di', $align = 'C', $border = '1', $calign = 'C');
        PDF::SetFont('bebasneue', 'B', 13);
        PDF::MultiCell(160, 0, $eventLocation, 0, 'C', 0, 1, 25);

        PDF::Ln(10);
        PDF::SetFont('badscript', 'I', 13);
        PDF::Cell($w = 0, $h = 1, $txt = 'Anjuran', $align = 'C', $border = '1', $calign = 'C');
        PDF::SetFont('bebasneue', 'B', 13);
        PDF::MultiCell(160, 0, $eventOrganiserName, 0, 'C', 0, 1, 25);

        // Generate QR Code and re-adjust the signature position if visibility is set to PUBLIC 
        switch ($certEvent->visibility) {
            case 'public':
                /**
                 * Signature is visibility is PUBLIC
                 */
                if(Storage::disk('public')->exists($certificationVerifierSignaturePath)){
                    $certificationVerifierSignature = '.' . Storage::disk('local')->url($certificationVerifierSignaturePath);
                }
                PDF::Image($certificationVerifierSignature, $x = 40, $y = 225, $w = 39, $h = 13);

                PDF::SetFont('bebasneue', '', 12);
                PDF::SetXY(40, 235);
                PDF::MultiCell($w = 100, $h = 0, $txt = '...............................................', 0, 'L', 0, 0, 40);
                PDF::Ln();
                PDF::MultiCell($w = 100, $h = 0, $txt = '(' . $certificationVerifierName . ')', 0, 'L', 0, 0, 40);
                PDF::Ln();
                PDF::MultiCell($w = 100, $h = 0, $txt = $certificationVerifierPosition, 0, 'L', 0, 0, 40);
                $style = array(
                    'border' => 0,
                    'vpadding' => 0.5,
                    'hpadding' => 0.5,
                    'fgcolor' => array(0,0,0),
                    'bgcolor' => array(255, 255, 255),
                    'module_width' => 1, 
                    'module_height' => 1
                );
                PDF::write2DBarcode(url()->current(), 'QRCODE,Q', 145, 240, 30, 30, $style, 'N');
                break;
            case 'hidden':
                /**
                 * Signature is visibility is HIDDEN
                 */
                if(Storage::disk('public')->exists($certificationVerifierSignaturePath)){
                    $certificationVerifierSignature = '.' . Storage::disk('local')->url($certificationVerifierSignaturePath);
                }
                PDF::Image($certificationVerifierSignature, $x = 85, $y = 225, $w = 39, $h = 13);

                PDF::SetFont('bebasneue', '', 12);
                PDF::SetXY(105, 235);
                PDF::MultiCell($w = 160, $h = 0, $txt = '...............................................', 0, 'C', 0, 0, 25);
                PDF::Ln();
                PDF::MultiCell($w = 160, $h = 0, $txt = '(' . $certificationVerifierName . ')', 0, 'C', 0, 0, 25);
                PDF::Ln();
                PDF::MultiCell($w = 160, $h = 0, $txt = $certificationVerifierPosition, 0, 'C', 0, 0, 25);
                break;
            default:
                break;
        }

        PDF::Output('SeaJell_e_Certificate.pdf', 'I');
        PDF::reset();
    }
}