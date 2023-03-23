<?php

namespace App\Jobs;

use App\Jobs\Middleware\EnableSMSNotifications;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SMSNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var User $user */
    public $user;

    /** @var String $message */
    public $message;

    /**
     * Create a new job instance.
     *
     * @param  User  $user
     * @param  String  $password
     *
     * @return void
     */
    public function __construct(User $user, $message)
    {
        $this->user = $user;
        $this->message = $message;
        $this->user->load(['profile']);
    }

    /**
     * Get the middleware the job should be dispatched through.
     *
     * @return array
     */
    public function middleware()
    {
        return [new EnableSMSNotifications()];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->user->country_code && $this->user->phone_number) {
            $phoneNumber = $this->user->country_code.$this->user->phone_number;

            $response = Http::retry(3, 1000)
                ->post('https://sms.simplesellable.com/api/v1/send/', [
                    'senderid' => config('services.sms.sender_id'),
                    'timestamp' => Carbon::now()->timestamp,
                    'verification' => Sha1(Carbon::now()->timestamp.config('services.sms.api_key')),
                    'mobile' => $phoneNumber,
                    'sms' => $this->message,
                ])->throw()->json();
        }
    }
}
