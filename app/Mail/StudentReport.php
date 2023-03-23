<?php

namespace App\Mail;

use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentReport extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $students;
    public $pdf;

    /**
     * Create a new message instance.
     *
     * @param  User  $user
     * @param  $students
     *
     * @return void
     */
    public function __construct(User $user, $students)
    {
        $this->user = $user;
        $this->students = $students;
        $this->pdf = $this->pdfGeneration();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Students Status Report')
            ->markdown('emails.students.report', ['user' => $this->user])
            ->attachData(base64_decode($this->pdf), 'student_report.pdf', ['mime' => 'pdf']);
    }

    /**
     * Generate PDF
     */
    public function pdfGeneration()
    {
        $students = $this->students;

        $pdf = \PDF::loadView('students.pdf', compact('students'))->setPaper('a4', 'landscape');
        return base64_encode($pdf->output());
    }
}
