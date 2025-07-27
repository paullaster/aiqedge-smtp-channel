<?php

namespace Aiqedge\SmtpNotificationsChannel;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class AiqedgeSmtpServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // When Laravel asks for the 'aiqedge_smtp' channel...
        Notification::extend('aiqedge_smtp', function ($app) {

            // Fetch the config values from the service container here, ONCE.
            $apiUrl = $app['config']->get('services.aiqedge_smtp.url');
            $apiKey = $app['config']->get('services.aiqedge_smtp.key');

            // Pass the resolved config values into the channel's constructor.
            return new AiqedgeSmtpChannel($apiUrl, $apiKey);
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
