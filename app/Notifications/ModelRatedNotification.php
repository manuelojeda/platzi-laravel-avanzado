<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ModelRatedNotification extends Notification
{
    use Queueable;

    private string $qualifier_name;
    private string $product_name;
    private float $score;
    
    public function __construct(string $qualifier_name, string $product_name, float $score)
    {
        $this->qualifier_name = $qualifier_name;
        $this->product_name = $product_name;
        $this->score = $score;
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
        return (new MailMessage)
                    ->line("{$this->qualifier_name} ha calificado tu producto {$this->product_name} con {$this->score} estrellas");
    }
}
