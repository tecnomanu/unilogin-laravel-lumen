<?php

namespace Tecnomanu\UniLogin\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class MagicLinkNotification extends Notification
{
    use Queueable;

    protected $magicLink;

    public function __construct($magicLink)
    {
        $this->magicLink = $magicLink;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Hello!')
                    ->line('Here is your magic link for logging in.')
                    ->action('Login', url($this->magicLink))
                    ->salutation('Thank you for using ' . config('app.name') . '!');
    }
}
