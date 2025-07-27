<?php

namespace Aiqedge\SmtpNotificationsChannel;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class AiqedgeSmtpServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Notification::extend('aiqedge_smtp', function ($app) {

            $config = $app['config']->get('services.aiqedge_smtp');

            // Pass all the required config values into the channel's constructor.
            return new AiqedgeSmtpChannel(
                $config['url'] ?? '',
                $config['key'] ?? '',
                $config['regards'] ?? [] // Use a default empty array to prevent errors
            );
        });

        $this->publishes([
            __DIR__ . '/../config/aiqedge_smtp.php' => config_path('services.php'),
        ], 'config');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/aiqedge_smtp.php',
            'services'
        );
    }
}
