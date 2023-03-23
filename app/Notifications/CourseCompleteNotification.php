<?php

namespace App\Notifications;

use App\Models\Course;
use Benwilkins\FCM\FcmMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CourseCompleteNotification extends Notification
{
    use Queueable;

    protected $course;

    /**
     * Create a new notification instance.
     *
     * CourseCompleteNotification constructor.
     * @param  Course  $course
     */
    public function __construct(Course $course)
    {
        $this->course = $course;
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
     * @param $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Course Completed Successfully')
            ->markdown('emails.students.courseComplete', [
                'student' => $notifiable,
                'course' => $this->course,
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
            'message' => 'You have completed \''.$this->course->name.'\' course successfully.'
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
            'title' => 'Course Completion',
            'body' => 'You have completed \''.$this->course->name.'\' course successfully.',
        ]);

        return $message;
    }
}
