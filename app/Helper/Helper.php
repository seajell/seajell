<?php

use App\Jobs\AlertMailJob;
use App\Mail\NewAccountMail;
use App\Models\SystemSetting;
use App\Mail\CertificateAddMail;
use App\Mail\ForgetPasswordMail;
use Illuminate\Support\Facades\App;
use App\Models\EmailServiceSettings;
use Illuminate\Support\Facades\Cache;

if (!function_exists('set_locale')) {
    function set_locale($language = 'ms-MY')
    {
        $cacheKey = 'seajell-locale-' . app()->environment();
        // Clear existing locale cache
        Cache::forget($cacheKey);
        // Cache forever new locale
        Cache::forever($cacheKey, $language);
        // Set new locale for current request/runtime
        App::setLocale($language);
    }
}

if (!function_exists('get_locale')) {
    function get_locale()
    {
        // Get from cache if does exists
        if ($appLocale = Cache::get('seajell-locale-' . app()->environment())) {
            return $appLocale;
        }

        // Fallback to user setting if does exist
        if (Schema::hasTable('system_settings')) {
            if (SystemSetting::where('id', 1)->first()) {
                $systemSetting = SystemSetting::query()->find(1);

                return $systemSetting->language;
            }
        }

        // Fallback to default application locale
        return config('app.locale');
    }
}

if (!function_exists('seajell_send_mail')) {
    /**
     * Send Email Helper for SeaJell.
     *
     * @param string $email destination email dddress
     * @param array $emailDetailsArr array containing the email details used for view
     * @param string $emailType type of the email
     *
     * @author Muhammad Hanis Irfan bin Mohd Zaid
     *
     * @return void
     */
    function seajell_send_mail($email, $emailDetailsArr, $emailType)
    {
        if (!empty(EmailServiceSettings::where('id', 1)->first()) && !empty(SystemSetting::where('id', 1)->first())) {
            $emailServiceSetting = EmailServiceSettings::where('id', 1)->first();
            $systemSetting = SystemSetting::query()->find(1);
            if ('on' == $emailServiceSetting->service_status) {
                if (!empty($emailServiceSetting->support_email)) {
                    $emailSupportEmail = $emailServiceSetting->support_email;
                } else {
                    $emailSupportEmail = '';
                }

                if (!empty($systemSetting->logo)) {
                    $emailSystemLogo = $systemSetting->logo;
                } else {
                    $emailSystemLogo = '';
                }

                if (!empty($systemSetting->name)) {
                    $emailSystemName = $systemSetting->name;
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

                // Accepts associative array
                $emailDetails = $emailDetailsArr;
                switch ($emailType) {
                    case 'NewAccountMail':
                        AlertMailJob::dispatch(strtolower($email), new NewAccountMail($basicEmailDetails, $emailDetails));
                        break;
                    case 'ForgetPasswordMail':
                        AlertMailJob::dispatch(strtolower($email), new ForgetPasswordMail($basicEmailDetails, $emailDetails));
                        break;
                    case 'CertificateAddMail':
                        AlertMailJob::dispatch(strtolower($email), new CertificateAddMail($basicEmailDetails, $emailDetails));
                        break;
                    default:
                        break;
                }
            }
        }
    }
}
