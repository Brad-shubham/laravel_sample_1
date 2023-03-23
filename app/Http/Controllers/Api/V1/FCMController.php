<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class FCMController extends Controller
{
    /**
     * the method used to save fcm token into records
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function storeDeviceToken(Request $request){

        $validator = Validator::make($request->all(), [
            'token' => 'required',
        ],
            [
                'token.required' => 'Oops! The device token is required.',
            ]);

        if ($validator->fails()) {
            $errors = (new ValidationException($validator))->errors();

            throw new HttpResponseException(
                response()->json(['errors' => $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            );
        }


        try{
            if (Auth::user()){
                User::whereId(Auth::user()->id)->update([
                    'device_token' => $request->token
                ]);
                $data['success'] = 'Device Token saved successfully';
                return response()->json($data, 200);
            }else{
                $data['errors'] = 'Unauthenticated User!!!';
                return response()->json($data, 422);
            }

        }catch (\Exception $e){
            $data['errors'] = "Something went wrong ".$e->getMessage();
            return response()->json($data, 401);
        }

    }
}
