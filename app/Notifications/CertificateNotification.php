<?php

namespace App\Notifications;

use App\Models\Certificate;
use Benwilkins\FCM\FcmMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class CertificateNotification extends Notification
{
    use Queueable;

    protected $certificate;

    protected $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Certificate $certificate, $message)
    {
        $this->certificate = $certificate;
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
            ->subject('Certificate Awarded')
            ->markdown('emails.students.certificateAwarded', [
                'student' => $notifiable,
                'certificate' => $this->certificate,
                'downloadUrl' => Storage::disk('certificates')->url($this->certificate->file)
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
            'title' => 'Certificate Awarded',
            'body' => $this->message,
        ]);

        return $message;
    }
}
