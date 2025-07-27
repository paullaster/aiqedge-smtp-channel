<?php

namespace Aiqedge\SmtpNotificationsChannel;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiqedgeSmtpChannel
{
    /**
     * The URL for the AIQEDGE-SMTP API.
     *
     * @var string
     */
    protected string $apiUrl;

    /**
     * The API key for the AIQEDGE-SMTP service.
     *
     * @var string
     */
    protected string $apiKey;

    /**
     * Create a new AIQEDGE-SMTP channel instance.
     *
     * @param string $apiUrl
     * @param string $apiKey
     * @return void
     */
    public function __construct(string $apiUrl, string $apiKey)
    {
        $this->apiUrl = $apiUrl;
        $this->apiKey = $apiKey;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification): void
    {
        $message = $notification->toAiqedgeSmtp($notifiable);

        // Use the properties that were set in the constructor
        $endpoint = "{$this->apiUrl}/{$this->apiKey}/send";

        $response = Http::post($endpoint, $message);

        if ($response->failed()) {
            Log::error('AIQEDGE-SMTP notification failed: ' . $response->body());
        }
    }
}
