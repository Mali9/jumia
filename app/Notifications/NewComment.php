<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewComment extends Notification
{
    use Queueable;

    public $comment_id, $product_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($comment_id, $product_id)
    {
        $this->comment_id = $comment_id;
        $this->product_id = $product_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'comment_id' => $this->comment_id,
            'product_id' => $this->product_id,
            'message' => 'Someone commented on your product, go check it out !'
        ];
    }
}
