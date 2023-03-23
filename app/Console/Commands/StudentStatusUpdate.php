<?php

namespace App\Console\Commands;

use App\Jobs\SMSNotifications;
use App\Models\User;
use App\Notifications\StudentStatusReminderNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class StudentStatusUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:student_status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the student\'s status based on the student\'s last activity.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $currentDate = Carbon::now()->toDateString();

        $this->line('update:student_status command starting...');
        Log::info('update:student_status command starting...', ['Today Date' => $currentDate]);

        try {
            User::query()
                ->where('user_type', '=', '3')
                ->orderBy('id')
                ->each(function (User $student) use ($currentDate) {

                    $last_lesson_date = $student->lessonProgress->last()->updated_at;
                    $daysDiffFromLastActivity = $last_lesson_date->diffInDays($currentDate);

                    if ($daysDiffFromLastActivity == 30) {
                        $message = 'Reminder: You have been inactive for last 30 days.';
                        $student->notify(new StudentStatusReminderNotification($message));

                        dispatch(new SMSNotifications($student, $message));
                    } elseif ($daysDiffFromLastActivity == 90) {
                        $student_profile = $student->profile;
                        $student_profile->activity_status = 'inactive';
                        $student_profile->save();

                        $message = 'Reminder: You have been inactive for last 90 days.';
                        $student->notify(new StudentStatusReminderNotification($message));

                        dispatch(new SMSNotifications($student, $message));
                    } elseif ($daysDiffFromLastActivity == 180) {
                        $message = 'Reminder: You have been inactive for last 180 days.';
                        $student->notify(new StudentStatusReminderNotification($message));

                        dispatch(new SMSNotifications($student, $message));

                    } elseif ($daysDiffFromLastActivity == 270) {
                        $student_profile = $student->profile;
                        $student_profile->activity_status = 'unresponsive';
                        $student_profile->save();

                        $message = 'Reminder: You have been inactive for last 9 months.';
                        $student->notify(new StudentStatusReminderNotification($message));

                        dispatch(new SMSNotifications($student, $message));
                    }
                });

        } catch (\Throwable $exception) {
            $this->error("update:student_status - Failed to send and update the student's activity status.");
            Log::error($exception);
        }

        Log::info('update:student_status command finished!');
        $this->info('update:student_status command finished!');
        return 0;
    }
}
