<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeEmail extends Notification
{
    use Queueable;

    public function __construct(public $user)
    {
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Welcome to Key Auth System!')
            ->line('Welcome ' . $notifiable->name . '!')
            ->line('Your account has been created successfully.')
            ->line('Your Login Key: ' . $notifiable->login_key)
            ->line('Please verify your email to activate your account.')
            ->action('Login Now', url('/login'))
            ->line('Thank you for using our application!');
    }
}
