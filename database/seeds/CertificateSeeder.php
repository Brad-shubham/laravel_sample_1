<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class CertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $student = \App\Models\User::where('user_type', \App\Models\User::USER_TYPE['student'])->first();
        $teacher = User::where('user_type', User::USER_TYPE['super admin'])->first();

        $certificateLevels = \App\Models\Certificate::LEVELS;

        foreach ($certificateLevels as $level) {
            \App\Models\Certificate::updateOrCreate([
                'student_id' => $student->id,
                'level' => $level,
            ],[
                'student_id' => $student->id,
                'level' => $level,
                'teacher_id' => $teacher->id,
            ]);
        }
    }
}
