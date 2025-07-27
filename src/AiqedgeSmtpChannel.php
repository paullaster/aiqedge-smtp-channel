<?php

namespace Aiqedge\SmtpNotificationsChannel;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiqedgeSmtpChannel
{
    protected string $apiUrl;
    protected string $apiKey;

    /**
     * The default "regards" data from the config.
     *
     * @var array
     */
    protected array $defaultRegards;

    /**
     * Create a new AIQEDGE-SMTP channel instance.
     *
     * @param string $apiUrl
     * @param string $apiKey
     * @param array  $defaultRegards
     * @return void
     */
    public function __construct(string $apiUrl, string $apiKey, array $defaultRegards)
    {
        $this->apiUrl = $apiUrl;
        $this->apiKey = $apiKey;
        $this->defaultRegards = $defaultRegards;
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

        // --- Logic to merge the default regards ---
        // If the notification payload does NOT already have a 'regards' key,
        // and our default regards from the config is not empty, add it.
        if (!isset($message['regards']) && !empty($this->defaultRegards)) {
            $message['regards'] = $this->defaultRegards;
        }
        // ---------------------------------------------

        $endpoint = "{$this->apiUrl}/{$this->apiKey}/send";

        $response = Http::post($endpoint, $message);

        if ($response->failed()) {
            Log::error('AIQEDGE-SMTP notification failed: ' . $response->body());
        }
    }
}
