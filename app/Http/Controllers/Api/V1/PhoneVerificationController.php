<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Jobs\SMSNotifications;
use App\Models\User;
use App\Models\UserOtp;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use GuzzleHttp\Client;

class PhoneVerificationController extends Controller
{

    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param Request $request
     * method used to send the OTP to phone number
     * @return \Illuminate\Http\JsonResponse
     */

    public function sendOtp(Request $request)
    {
        try{

            if ($request->get('phone_number')){

                $query = User::where('phone_number', $request->get('phone_number'))->first();

                if (is_null($query)){
                    $data["error_message"] = "Phone number does not exists in our system";
                    return response()->json($data, 403);
                }else{

                    $digits = 4;
                    $otp = rand(pow(10, $digits-1), pow(10, $digits)-1);
                    $student = User::whereId(Auth::user()->id)->first();

                    $message = 'OTP for phone verification '.$otp;

                    $this->dispatch(new SMSNotifications($student, $message));

                    $result = UserOtp::updateorcreate([
                        'phone_number' => $request->phone_number
                    ],[
                        'phone_number' => $request->phone_number,
                        'otp' => $otp,
                    ]);

                    if ($result == true){
                        $data['success'] = "Otp has sent to your mobile number";
                        return response()->json($data, 200);
                    }else{
                        $data['error'] = "There has been some issue. Please try after sometimes";
                        return response()->json($data, 403);
                    }
                }
            }else{

                $data["error_message"] = "Please enter the Phone number";

                return response()->json($data, 403);
            }

        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }


    /**
     * @param Request $request
     * method used to verify the OTP and phone number
     * @return \Illuminate\Http\JsonResponse
     */

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'phone_number' => 'required',
            'otp' => 'required'
        ],[
            'phone_number.required' => 'Oops! Phone number is required.',
            'otp.required' => 'Oops! OTP is required.'
        ]);

        if ($validator->fails()) {
            $errors = (new ValidationException($validator))->errors();

            throw new HttpResponseException(
                response()->json(['errors' => $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            );
        }

      try{

          $enter_otp = $request->get('otp');

          $query_result = UserOtp::where('phone_number', $request->get('phone_number'))->where('otp', $enter_otp)->update(['status' => true]);

              if ($query_result){
                  $verify_result = User::where('phone_number', $request->get('phone_number'))->update(['phone_verified_at' => Carbon::now()]);

                  if ($verify_result){
                      $data["success"] = "Your Phone is verified successfully";
                      return response()->json($data, 200);
                  }else{
                      $data["error_message"] = "Something Went Wrong";
                      return response()->json($data);
                  }
              }else{
                  $data["error_message"] = "Invalid otp";
                  return response()->json($data);
              }

      }catch (\Exception $e){
              return response()->json(['error' => $e->getMessage()], 403);
        }

    }
}
