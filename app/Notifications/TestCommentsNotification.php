<?php

namespace App\Notifications;

use App\Models\Test;
use Benwilkins\FCM\FcmMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TestCommentsNotification extends Notification
{
    use Queueable;

    protected $test;

    /**
     * Create a new notification instance.
     *
     * @param  Test  $test
     * @return void
     */
    public function __construct(Test $test)
    {
        $this->test = $test;
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
            return ['mail', 'database', 'fcm'];
        }
        return ['database', 'fcm'];
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
            ->subject('Test Comments')
            ->markdown('emails.students.testComments', [
                'student' => $notifiable,
                'test' => $this->test,
            ]);
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
            'message' => 'There are some feedbacks from teacher on '.$this->test->title.' test.',
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
            'title' => 'Test Comments',
            'body' => 'There are some feedbacks from teacher on '.$this->test->title.' test.',
        ]);

        return $message;
    }
}
