<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;

class CertificateController extends Controller
{
    /**
     * Generate Level One Certificate for Student
     *
     * @param  User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function levelOne(User $user)
    {
        $certificate = $user->certificates()->where('level',
            Certificate::LEVELS['One'])->first();

        if ($certificate) {
            $studentName = $user->profile->full_name;
            $date = Carbon::now()->format('F dS Y');
            $teacher = $certificate->teacher->profile->full_name;

            $pdf = PDF::loadView('certificates.levelOne',
                compact('studentName', 'date', 'teacher', 'certificate'))->setPaper('a4',
                'landscape');

            // To directly download the PDF use $pdf->download('pdf-name');
            return $pdf->download('level-one-certificate.pdf');
        }
        return back();
    }

    /**
     * Generate Level Two Certificate for Student
     *
     * @param  User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function levelTwo(User $user)
    {
        $certificate = $user->certificates()->where('level',
            Certificate::LEVELS['Two'])->first();

        if ($certificate) {
            $studentName = $user->profile->full_name;
            $date = Carbon::now()->format('F dS Y');
            $teacher = $certificate->teacher->profile->full_name;

            $pdf = PDF::loadView('certificates.levelTwo',
                compact('studentName', 'date', 'teacher', 'certificate'))->setPaper('a4',
                'landscape');

            // To directly download the PDF use $pdf->download('pdf-name');
            return $pdf->download('level-two-certificate.pdf');
        }
        return back();
    }

    /**
     * Generate Level Three Certificate for Student
     *
     * @param  User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function levelThree(User $user)
    {
        $certificate = $user->certificates()->where('level',
            Certificate::LEVELS['Three'])->first();

        if ($certificate) {
            $studentName = $user->profile->full_name;
            $date = Carbon::now()->format('F dS Y');
            $teacher = $certificate->teacher->profile->full_name;

            $pdf = PDF::loadView('certificates.levelThree',
                compact('studentName', 'date', 'teacher', 'certificate'))->setPaper('a4',
                'landscape');

            // To directly download the PDF use $pdf->download('pdf-name');
            return $pdf->download('level-three-certificate.pdf');
        }
        return back();
    }
}
