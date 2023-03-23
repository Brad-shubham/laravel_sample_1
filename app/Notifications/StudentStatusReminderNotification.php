<?php

namespace App\Notifications;

use Benwilkins\FCM\FcmMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StudentStatusReminderNotification extends Notification
{
    use Queueable;

    protected $message;

    /**
     * Create a new notification instance.
     * StudentStatusReminderNotification constructor.
     * @param $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if (!is_null($notifiable->email)) {
            return ['mail','fcm'];
        }
        return ['fcm'];
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
            ->subject('Activity Status Reminder')
            ->markdown('emails.students.statusReminder', [
                'student' => $notifiable,
                'message' => $this->message,
            ]);
    }

    /**
     * @param $notifiable
     * @return FcmMessage
     */
    public function toFcm($notifiable)
    {
        $message = new FcmMessage();
        $message->content([
            'title' => 'Activity Status Reminder',
            'body' => $this->message,
        ]);

        return $message;
    }
}
