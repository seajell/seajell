<?php

namespace App\Providers;

use Illuminate\Mail\Mailer;
use App\Models\SystemSetting;
use App\Models\EmailServiceSettings;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);

        $this->app->bind('user.mailer', function ($app) {
            $emailServiceSetting = '';
            $fromName = 'SeaJell';

            if ($serviceSetting = EmailServiceSettings::where('id', 1)->first()) {
                $emailServiceSetting = $serviceSetting;
            }

            if ($systemSetting = SystemSetting::where('id', 1)->first()) {
                $fromName = $systemSetting->name;
            }

            $smtp_host = $emailServiceSetting->service_host;
            $smtp_port = $emailServiceSetting->service_port;
            $smtp_username = $emailServiceSetting->account_username;
            $smtp_password = $emailServiceSetting->account_password;
            $smtp_encryption = 'tls';

            $from_email = $emailServiceSetting->from_email;
            $from_name = $fromName;

            $transport = new \Swift_SmtpTransport($smtp_host, $smtp_port);
            $transport->setUsername($smtp_username);
            $transport->setPassword($smtp_password);
            $transport->setEncryption($smtp_encryption);

            $swift_mailer = new \Swift_Mailer($transport);
            $mailer = new Mailer('smtp', $app->get('view'), $swift_mailer, $app->get('events'));
            $mailer->setQueue($app['queue']);
            $mailer->alwaysFrom($from_email, $from_name);
            $mailer->alwaysReplyTo($from_email, $from_name);

            return $mailer;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
    }
}
