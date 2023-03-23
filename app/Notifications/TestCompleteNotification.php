<?php

namespace App\Notifications;

use App\Models\Test;
use Benwilkins\FCM\FcmMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TestCompleteNotification extends Notification
{
    use Queueable;

    protected $test;

    protected $message;

    /**
     * Create a new notification instance.
     *
     * TestCompleteNotification constructor.
     * @param  Test  $test
     */
    public function __construct(Test $test, $message)
    {
        $this->test = $test;
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
            return ['mail', 'database','fcm'];
        }
        return ['database', 'fcm'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Test Completed Successfully')
            ->markdown('emails.students.testComplete', [
                'student' => $notifiable,
                'test' => $this->test,
                'message' => $this->message,
            ]);
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
            'message' => $this->message,
        ];
    }

    /**
     * @param $notifiable
     * @return FcmMessage
     */
    public function toFcm($notifiable)
    {
        $message = new FcmMessage();
        $message->content([
            'title' => 'Test Completion',
            'body' => $this->message,
        ]);

        return $message;
    }
}
