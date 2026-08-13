<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetLoginKey extends Notification
{
    use Queueable;

    public function __construct(public $token)
    {
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $resetUrl = url('/reset-key/' . $this->token . '?email=' . $notifiable->email);

        return (new MailMessage)
            ->subject('Reset Your Login Key')
            ->line('You are receiving this email because we received a login key reset request for your account.')
            ->action('Reset Login Key', $resetUrl)
            ->line('This reset link will expire in 1 hour.')
            ->line('If you did not request a login key reset, no further action is required.');
    }
}
