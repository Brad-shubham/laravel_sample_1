<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Jobs\SMSNotifications;
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Notifications\PasswordResetRequest;


class ForgotPasswordController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Forgot Password api
     *
     * @param Request $request
     * @return JsonResponse
     *
     */
    public function __invoke(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required_without_all:phone_number|email',
        ],
            [
                'email.required_without_all' => 'Oops! Please enter email or phone number.'
            ]);

        if ($validator->fails()) {
            $errors = (new ValidationException($validator))->errors();

            throw new HttpResponseException(
                response()->json(['error' => $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            );
        }

        $digits = 4;
        $otp = rand(pow(10, $digits-1), pow(10, $digits)-1);

        if ($request->get('email')){

            $user = User::where('email', $request->get('email'))->first();


            if ($user != null) {
                try{
                    $user->notify(new PasswordResetRequest($otp));

                    $check = PasswordReset::where('email', $request->get('email'))->first();
                    if ($check != null){

                        $storeOtp = PasswordReset::where('email', $request->get('email'))->update(['token' => str::random(64),
                            'otp' => $otp]);
                    }else{

                        $storeOtp = PasswordReset::create([
                            'email' => $request->get('email'),
                            'token' => str::random(64),
                            'otp' => $otp
                        ]);
                    }

                    if ($storeOtp){
                        return response()->json(['success' => "Otp has sent to your email"], JsonResponse::HTTP_OK);
                    }else{
                        return response()->json(['error' => "Something went wrong"], JsonResponse::HTTP_FORBIDDEN);
                    }

                }catch (\Exception $e){
                    return response()->json(['error' => $e->getMessage()], JsonResponse::HTTP_NOT_FOUND);
                }

            }else{
                return response()->json(['error' => "Email does not exists in the system"], JsonResponse::HTTP_FORBIDDEN);
            }
        }else{

            $student = User::where('phone_number', $request->get('phone_number'))->first();

            if ($student != null) {
                try{
                    $message = 'Your OTP for password reset:'.'OTP:'.$otp;
                    $this->dispatch(new SMSNotifications($student, $message));

                    $check = PasswordReset::where('phone_number', $request->get('phone_number'))->first();


                    if ($check != null){
                        $storeOtp = PasswordReset::where('phone_number', $request->get('phone_number'))->update(['token' => str::random(64),
                            'otp' => $otp]);
                    }else{

                        $storeOtp = PasswordReset::create([
                            'phone_number' => $request->get('phone_number'),
                            'token' => str::random(64),
                            'otp' => $otp
                        ]);
                    }

                    if ($storeOtp){
                        return response()->json(['success' => "Otp has sent to your phone number"], JsonResponse::HTTP_OK);
                    }else{
                        return response()->json(['error' => "Something went wrong"], JsonResponse::HTTP_FORBIDDEN);
                    }
                }catch (\Exception $e){
                    return response()->json(['error' => $e->getMessage()], JsonResponse::HTTP_FORBIDDEN);
                }

            }else{
                return response()->json(['error' => "Phone Number does not exists in the system"], JsonResponse::HTTP_NOT_FOUND);
            }
        }

    }


    /**
     * This method verify the otp
     *
     * @param Request $request
     * @return JsonResponse
     *
     */
    public function verify(Request $request)
    {
        try{
            $enter_otp = $request->get('otp');

                if ($request->get('email')){
                    $query = PasswordReset::where('email', $request->get('email'))->where('otp', $enter_otp)->first();
                    if ($query != null){
                        $token = $query->token;
                       return response()->json(["token" => $token], 200);
                    }else{
                        return response()->json(['error' => "error"], JsonResponse::HTTP_FORBIDDEN);
                    }
                }else{
                    $query = PasswordReset::where('phone_number', $request->get('phone_number'))->where('otp', $request->get('otp'))->first();
                    if ($query != null){
                        $token = $query->token;
                        return response()->json(["token" => $token], 200);
                    }else{
                        return response()->json(['error' => "error"], JsonResponse::HTTP_FORBIDDEN);
                    }

                }

        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], JsonResponse::HTTP_FORBIDDEN);
        }
    }

    public function setPassword(Request $request){
        $token = $request->bearerToken();
        try
        {
                $password = $request->get('password');
                $value = PasswordReset::whereToken($token)->first();
                if ($value->email != null){
                    $email = $value->email;
                    $student = User::whereEmail($email)->update([
                        'password' => bcrypt($password)
                    ]);
                }else{
                    $phone_number = $value->phone_number;
                    $student = User::wherePhoneNumber($phone_number)->update([
                        'password' => bcrypt($password)
                    ]);
                }

                if ($student){
                    $success['message'] = "Your Password has been updated successfully";
                    return response()->json($success, 200);
                }else{
                    $errors['error'] = "Something Went Wrong";
                    return response()->json($errors, 403);
                }

        }catch (\Exception $e){
            $errors['error'] = "Something Went Wrong";
            return response()->json($errors, 403);
        }

    }


//    public function SMSNotification($student, $otp)
//    {
//        try {
//            $environment = config('app.env');
//
//            if ($environment == 'production') {
//
//                $phoneNumber = $student->country_code.$student->phone_number;
//                $url = "https://sms.simplesellable.com/api/v1/send";
//                $client = new \GuzzleHttp\Client();
//                $sms = 'Your OTP for password reset:'.'OTP:'.$otp;
//
//                $response = $client->post($url, [
//
//                    \GuzzleHttp\RequestOptions::JSON => [
//                        'senderid' => env('SENDER_ID'),
//                        'timestamp' => Carbon::now()->timestamp,
//                        'verification' => Sha1(Carbon::now()->timestamp.env('API_KEY')),
//                        'mobile' => $phoneNumber,
//                        'sms' => $sms,
//                    ],
//                ]);
//
//                if ($response->getStatusCode() == 200) {
//                    return true;
//                }
//            }else{
//                return false;
//            }
//        } catch (\Exception $e) {
//            return response()->json(['error' => $e->getMessage()], 403);
//        }
//    }
}