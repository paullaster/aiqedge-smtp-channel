<?php

namespace Aiqedge\SmtpNotificationsChannel;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiqedgeSmtpChannel
{
    public function send($notifiable, Notification $notification): void
    {
        $message = $notification->toAiqedgeSmtp($notifiable);

        $apiKey = config('services.aiqedge_smtp.key');
        $apiUrl = config('services.aiqedge_smtp.url');

        $endpoint = "{$apiUrl}/{$apiKey}/send";

        $response = Http::post($endpoint, $message);

        if ($response->failed()) {
            Log::error('AIQEDGE-SMTP notification failed: ' . $response->body());
        }
    }
}
