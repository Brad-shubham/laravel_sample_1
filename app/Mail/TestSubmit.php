<?php

namespace App\Mail;

use App\Models\Test;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestSubmit extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    protected $student;

    /**
     * @var Test
     */
    protected $test;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $student, Test $test)
    {
        $this->student = $student;
        $this->test = $test;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->configDefaultRecipents();

        return $this
            ->subject('Test Submitted')
            ->markdown('emails.teachers.testSubmitted', [
                'student' => $this->student,
                'test' => $this->test,
            ]);
    }

    /**
     * configuring default recipents
     *
     * @return void
     */
    protected function configDefaultRecipents()
    {
        $superAdminUsers = $this->superAdminUsers()->pluck('email');
        $this->to($superAdminUsers->toArray());
    }

    /**
     * fetch super admin users
     *
     * @return mixed
     */
    protected function superAdminUsers()
    {
        return User::where('user_type', User::USER_TYPE['super admin'])->get();
    }
}
