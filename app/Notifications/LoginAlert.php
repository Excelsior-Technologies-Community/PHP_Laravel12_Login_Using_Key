<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginAlert extends Notification
{
    use Queueable;

    public function __construct(public $ip, public $device, public $location)
    {
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Login Detected')
            ->line('A new login was detected on your account.')
            ->line('IP Address: ' . $this->ip)
            ->line('Device: ' . $this->device)
            ->line('Location: ' . $this->location)
            ->line('If this was you, no further action is required.')
            ->line('If you did not login, please secure your account immediately.');
    }
}
