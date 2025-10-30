<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendNewPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $newPassword;

    /**
     * Create a new notification instance.
     */
    public function __construct($newPassword)
    {
        $this->newPassword = $newPassword;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Password Has Been Reset')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your password has been successfully reset.')
            ->line('Here is your new password:')
            ->line('**' . $this->newPassword . '**')
            ->line('Please log in and change it as soon as possible for security reasons.')
            ->salutation('— Hisaab Share');
    }
}
