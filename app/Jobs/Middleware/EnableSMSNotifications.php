<?php

namespace App\Jobs\Middleware;

class EnableSMSNotifications
{
    public function handle($job, $next)
    {
        if (!config('services.sms.enabled')) {
            return false;
        }

        return $next($job);
    }
}
