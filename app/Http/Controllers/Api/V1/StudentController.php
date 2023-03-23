<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;


class StudentController extends Controller
{
    /**
     * method used to get the student information
     * @param  $student_id
     * @return JsonResponse
     */
    public function checkStudent($student_id)
    {
        try
        {
                $checkUser = User::whereStudentId($student_id)->first();

                if ($checkUser){
                    $success['profile']['student_id'] = $checkUser->student_id;
                    $success['profile']['surname'] = $checkUser->profile->surname;
                    $success['profile']['first_name'] = $checkUser->profile->first_name;
                    $success['profile']['last_name'] = $checkUser->profile->middle_name;
                    $success['profile']['email'] = $checkUser->email;
                    $success['profile']['phone_number'] = $checkUser->phone_number;
                    $success['profile']['country_id'] = $checkUser->profile->country_id;
                    return response()->json($success, 200);
                }else{
                    $response['error'] = "Student ID does not exists in the system";
                    return response()->json($response, 401);
                }


        }catch (\Exception $e)
        {
            return response()->json(['error' => "Something Went Wrong"], 403);
        }
    }
}
