<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Jobs\AlertMailJob;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Models\SystemSetting;
use App\Mail\ForgetPasswordMail;
use Illuminate\Support\Facades\URL;
use App\Models\EmailServiceSettings;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends MainController
{
    protected $emailSupportEmail;
    protected $emailSystemLogo;
    protected $emailSystemName;
    protected $emailServiceSetting;
    protected $systemSetting;

    public function __construct()
    {
        $this->systemSetting = SystemSetting::where('id', 1)->first();
        $this->emailServiceSetting = EmailServiceSettings::where('id', 1)->first();
        if (!empty($this->emailServiceSetting)) {
            if ('on' == $this->emailServiceSetting->service_status) {
                if (!empty($this->emailServiceSetting->support_email)) {
                    $this->emailSupportEmail = $this->emailServiceSetting->support_email;
                } else {
                    $this->emailSupportEmail = '';
                }

                if (!empty($this->systemSetting->logo)) {
                    $this->emailSystemLogo = $this->systemSetting->logo;
                } else {
                    $this->emailSystemLogo = '';
                }

                if (!empty($this->systemSetting->name)) {
                    $this->emailSystemName = $this->systemSetting->name;
                } else {
                    $this->emailSystemName = '';
                }
            }
        }
        $this->emailSupportEmail;
        $this->emailSystemLogo;
        $this->emailSystemName;
    }

    public function passwordResetRequestView(Request $request)
    {
        /*
         * Since idk how Laravel Password Reset feature actually works, I'm going to implement my own logic.
         * Request -> email -> reset
         * Tokens will only be valid for 24 hours / 1 day.
         */
        return view('auth.forgot-password')->with(['appVersion' => $this->appVersion, 'apiToken' => $this->apiToken, 'appName' => $this->appName, 'systemSetting' => $this->systemSetting]);
    }

    public function passwordResetRequest(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Check if user existed with the email given
        if (User::where('email', $request->input('email'))->first()) {
            // Insert password reset info into the database
            $uidArray = PasswordReset::select('token')->get();
            $token = $this->generateUID(50, $uidArray);
            $currentTime = Carbon::now();
            $next24HourFromNow = $currentTime->addDay()->toDateTimeString();

            PasswordReset::create([
                'email' => $request->input('email'),
                'token' => $token,
                'expired_on' => $next24HourFromNow,
                'created_at' => $currentTime->toDateTimeString(),
            ]);
        } else {
            return back()->withErrors([
                'email' => 'Pengguna dengan e-mel yang diberikan tidak wujud!',
            ]);
        }

        // Sending Email
        if (!empty($this->emailServiceSetting)) {
            if ('on' == $this->emailServiceSetting->service_status) {
                if (!empty($this->emailServiceSetting->support_email)) {
                    $emailSupportEmail = $this->emailServiceSetting->support_email;
                } else {
                    $emailSupportEmail = '';
                }

                if (!empty($this->systemSetting->logo)) {
                    $emailSystemLogo = $this->systemSetting->logo;
                } else {
                    $emailSystemLogo = '';
                }

                if (!empty($this->systemSetting->name)) {
                    $emailSystemName = $this->systemSetting->name;
                } else {
                    $emailSystemName = '';
                }

                $systemURL = URL::to('/');

                $basicEmailDetails = [
                    'supportEmail' => strtolower($emailSupportEmail),
                    'systemLogo' => $emailSystemLogo,
                    'systemName' => $emailSystemName,
                    'systemURL' => $systemURL,
                ];

                $emailDetails = [
                    'token' => $token,
                ];

                AlertMailJob::dispatch(strtolower($request->email), new ForgetPasswordMail($basicEmailDetails, $emailDetails));
            }
        }
        $request->session()->flash('passwordResetRequestSuccess', 'Permohonan berjaya. Sila lihat inbox e-mel anda!');

        return back();
    }

    public function passwordResetView($token)
    {
        // Checks if token existed and still valid (current time is lesser than expired on time)
        $currentTime = Carbon::now()->toDateTimeString();

        if (PasswordReset::select('token')->where('token', $token)->first() &&
        $currentTime < PasswordReset::select('expired_on')->where('token', $token)->first()->expired_on) {
            $resetStatus = 'valid';
            $email = PasswordReset::select('email')->where('token', $token)->first()->email;
        } else {
            $resetStatus = 'invalid';
            $email = '';
        }

        return view('auth.reset-password', ['token' => $token])->with(['appVersion' => $this->appVersion, 'apiToken' => $this->apiToken, 'appName' => $this->appName,
            'systemSetting' => $this->systemSetting, 'resetStatus' => $resetStatus, 'resetToken' => $token, 'email' => $email, ]);
    }

    public function passwordReset($token, Request $request)
    {
        $request->validate(['password' => 'required|confirmed']);
        $request->validate(['reset_token' => 'required']);
        $request->validate(['email' => 'required']);

        $password = $request->input('password');
        $email = $request->input('email');

        // Check if token given is available and related to email
        if (PasswordReset::select('token')->where('token', $token)->first() &&
        PasswordReset::select('email')->where('token', $token)->first()->email == strtolower($email)) {
            $currentTime = Carbon::now()->toDateTimeString();
            // Check if token still valid (current time is lesser than expired on time) (double checking to be sure)
            if ($currentTime < PasswordReset::select('expired_on')->where('token', $token)->first()->expired_on) {
                // Update the password
                $user = User::where('email', $email)->first();
                $user->password = Hash::make($password);
                $user->save();

                // Delete the token
                PasswordReset::where('token', $token)->delete();

                return view('auth.reset-password-success', ['token' => $token])->with(['appVersion' => $this->appVersion,
                    'apiToken' => $this->apiToken, 'appName' => $this->appName, 'systemSetting' => $this->systemSetting, ]);
            } else {
                // Just return to home route
                return route('/');
            }
        }
    }

    /**
     * Generate a unique string.
     *
     * @param int $length
     * @param array $uidArray
     *
     * @return mixed
     */
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
}
