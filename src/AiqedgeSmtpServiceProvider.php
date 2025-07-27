<?php

namespace Aiqedge\SmtpNotificationsChannel;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class AiqedgeSmtpServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Notification::extend('aiqedge_smtp', function ($app) {
            return new AiqedgeSmtpChannel();
        });

        $this->publishes([
            __DIR__ . '/../config/aiqedge_smtp.php' => config_path('services.php'),
        ], 'config');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/aiqedge_smtp.php',
            'services.aiqedge_smtp'
        );
    }
}
