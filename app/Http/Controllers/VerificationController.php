<?php

namespace App\Http\Controllers;

use App\Models\VerifyUserEmail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VerificationController extends Controller
{

    /**
     * Verify the email token.
     *
     * @param   $token
     * @return \Illuminate\Http\Response
     */
    public function verifyEmail($token)
    {

        try{
            $verifyUser = VerifyUserEmail::where('token', $token)->first();

            if ($verifyUser){
                $user = $verifyUser->user;
                if (is_null($user->email_verified_at)){
                    $verifyUser->user->email_verified_at = Carbon::now();
                    $verifyUser->user->save();
                    $status = "Thanks for the Email Verification";
                    return view('emails.status', compact('status'));
                }else{
                    $status = "Your e-mail is already verified";
                    return view('emails.status', compact('status'));
                }
            }else{
                $status = "Sorry your email cannot be identified.";
                return view('emails.status', compact('status'));
            }

        }catch (\Exception $e){

            return $e->getMessage();
        }

    }
}
