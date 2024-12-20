<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

use Illuminate\Notifications\Messages\MailMessage;


/**
 * Class PasswordReset
 * @package App\Notifications
 */
class PasswordReset extends Notification
{
    use Queueable;


    /**
     * Create a new notification instance.
     *
     * @param $reset
     * @param $user
     */
    public function __construct($reset, $user)
    {
        $this->reset = $reset;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $expire = $this->reset->created_at->addHours(24);
        $expiration = $expire->format('H:i \o\p d-m-Y');
        $url = route('passwordreset.edit', $this->reset->token);
        return (new MailMessage)
                    ->subject('Herstel je wachtwoord')
                    ->greeting('Nieuw wachtwoord instellen')
                    ->line('Beste '.$this->user->first_name.',')
                    ->line('Je hebt aangegeven dat je je wachtwoord voor starfish.dev bent vergeten')
                    ->line('Als u hier niet om heeft gevraagd negeer deze email dan')
                    ->action('Nieuw wachtwoord instellen', url($url))
                    ->line('Deze link is tot '.$expiration. ' geldig');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
