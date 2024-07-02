<?php

// app/Notifications/NearbyAlert.php

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NearbyAlert extends Notification
{
    use Queueable;

    private $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
                    ->line('Alerte : ' . $this->message)
                    ->action('Voir les détails', url('/'))
                    ->line('Merci de votre aide !');
    }
}
