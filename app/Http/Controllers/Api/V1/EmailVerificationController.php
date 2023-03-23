<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\VerifyUserEmail;
use App\Notifications\EmailVerficationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EmailVerificationController extends Controller
{
    public function sendVerificationEmail(Request $request)
    {
        try
        {
            $user = Auth::user();

            $query = VerifyUserEmail::create([
                'user_id' => $user->id,
                'token' => str::random(40)
            ]);

            $token = $query->token ;
            $verify_url = "user/verify/".$token;

            $user->notify(new EmailVerficationNotification($verify_url));

            $data["success"] = "Verification Email sent to your email address";
            return response()->json($data, 200);

        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 403);
        }

    }
}
