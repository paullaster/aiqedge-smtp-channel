# AIQEDGE SMTP Channel

A Laravel notification channel for sending emails via the AIQEDGE SMTP API. This package lets you deliver notifications using AIQEDGE's SMTP service, making it easy to integrate external email delivery into your Laravel applications.

## Features

- Send notifications through AIQEDGE SMTP API
- Simple integration with Laravel's notification system
- Error logging for failed requests

## Installation

Install the package via Composer:

```bash
composer require aiqedge/smtp-channel
```

## Configuration

Add your AIQEDGE SMTP credentials to your `.env` file:

```env
AIQEDGE_SMTP_KEY=your-api-key-here
AIQEDGE_SMTP_URL=https://api.aiqedge.com/smtp
```

Then, add the following to your `config/services.php`:

```php
'aiqedge_smtp' => [
    'key' => env('AIQEDGE_SMTP_KEY'),
    'url' => env('AIQEDGE_SMTP_URL'),
],
```

## Usage

### 1. Add the Channel to Your Notification

In your notification class, add the `via()` method to specify the channel:

```php
public function via($notifiable)
{
    return [AiqedgeSmtpChannel::class];
}
```

### 2. Define the `toAiqedgeSmtp()` Method

Add a `toAiqedgeSmtp()` method to your notification class. This should return an array with the email details:

```php
public function toAiqedgeSmtp($notifiable)
{
    return [
        'to' => $notifiable->email,
        'subject' => 'Your Subject',
        'body' => 'Your message body',
        // Add other fields as required by AIQEDGE SMTP API
    ];
}
```

### 3. Send the Notification

Use Laravel's notification system as usual:

```php
$user->notify(new YourNotification());
```

### Request Body Reference

To see the possible request body and required fields, visit this Postman collection:

[AIQEDGE SMTP Send Email Request Example (Postman)](https://www.postman.com/paullaster-haurweengs/aiqedge-smtp/request/q7isdaa/send-email?tab=body&ctx=code)

## Example

```php
use Aiqedge\SmtpNotificationsChannel\AiqedgeSmtpChannel;
use Illuminate\Notifications\Notification;

class InvoicePaid extends Notification
{
    public function via($notifiable)
    {
        return [AiqedgeSmtpChannel::class];
    }

    public function toAiqedgeSmtp($notifiable)
    {
        return [
            'to' => $notifiable->email,
            'subject' => 'Invoice Paid',
            'body' => 'Your invoice has been paid.',
        ];
    }
}
```

## Error Handling

If the API request fails, the error will be logged using Laravel's logging system. Check your logs for details.

## License

This package is open-sourced software licensed under the MIT license.
