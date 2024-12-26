<?php

namespace App\Notifications;

use App\Mail\GeneralMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GeneralNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     * Receive data with a title, message and optional action url, mailable markdown,
     * mailable data and attachment.
     */
    public function __construct(
        public string $title,
        public string $message,
        public string $action = '',
        public string $mailable = '',
        public array $data = [],
        public array $attachment = []
    ) {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): Mailable
    {
        return (new GeneralMail(
            title: $this->title,
            message: $this->message,
            action: $this->action,
            mailable: $this->mailable,
            data: $this->data,
            attachment: $this->attachment,
        ));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'action' => $this->action,
            'data' => $this->data,
        ];
    }
}
