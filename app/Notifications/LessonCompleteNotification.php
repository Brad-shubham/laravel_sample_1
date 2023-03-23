<?php

namespace App\Notifications;

use App\Models\Lesson;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LessonCompleteNotification extends Notification
{
    use Queueable;

    protected $lesson;

    /**
     * Create a new notification instance.
     *
     * LessonCompleteNotification constructor.
     * @param Lesson $lesson
     */
    public function __construct(Lesson $lesson)
    {
        $this->lesson = $lesson;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Lesson Completed Successfully')
            ->markdown('emails.students.lessonComplete', [
                'student' => $notifiable,
                'lesson' => $this->lesson,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'message' => 'You have completed \'' . $this->lesson->name . '\' lesson successfully.'
        ];
    }
}
