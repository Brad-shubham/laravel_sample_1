<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check())
        {
            return redirect('login');
        }

        $user = Auth::user();

        foreach ($roles as $role) {
            if ($user->user_type == User::USER_TYPE[$role]) {
                return $next($request);
            }
        }

        return redirect('dashboard');
    }
}
