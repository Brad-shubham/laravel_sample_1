<?php

namespace App\Jobs;

use App\Models\Certificate;
use App\Models\User;
use App\Notifications\CertificateNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;
use Psy\Util\Str;

class CertificateGeneration implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $certificate;

    /**
     * Create a new job instance.
     *
     * @param  User  $user
     * @param  Certificate  $certificate
     *
     * @return void
     */
    public function __construct(Certificate $certificate)
    {
        $this->certificate = $certificate;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $certificate = $this->certificate->loadMissing('student', 'teacher');

        if ($certificate->level === Certificate::LEVELS['One']) {
            $fileName = $certificate->student->getKey().'/certificate-level-one-'.\Illuminate\Support\Str::random(5).'.pdf';
            $pdf = PDF::loadView('certificates.levelOne', compact('certificate'))
                ->setPaper('a4', 'landscape')
                ->output();
        } elseif ($certificate->level === Certificate::LEVELS['Two']) {
            $fileName = $certificate->student->getKey().'/certificate-level-two-'.\Illuminate\Support\Str::random(5).'.pdf';
            $pdf = PDF::loadView('certificates.levelTwo', compact('certificate'))
                ->setPaper('a4', 'landscape')
                ->output();
        } else {
            $fileName = $certificate->student->getKey().'/certificate-level-three-'.\Illuminate\Support\Str::random(5).'.pdf';
            $pdf = PDF::loadView('certificates.levelThree', compact('certificate'))
                ->setPaper('a4', 'landscape')
                ->output();
        }
        Storage::disk('certificates')->put($fileName, $pdf);

        $this->certificate->update(['file' => $fileName]);
        $message = 'You have assigned "LEVEL '.$certificate->level.'" certificate.';
        $certificate->student->notify(new CertificateNotification($certificate, $message));
    }
}
