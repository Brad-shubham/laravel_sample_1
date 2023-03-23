<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\PostalCode;
use App\Models\User;
use App\Models\UsersProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EditProfileController extends Controller
{
    /**
     * method used to get the profile information
     *
     */

    public function showProfile()
    {
        $user = Auth::user();

        $data["status"] = "success";
        $data["profile_data"]["id"] = $user->id;
        $data["profile_data"]["username"] = $user->student_id;
        $data["profile_data"]["surname"] = $user->profile->surname;
        $data["profile_data"]["first_name"] = $user->profile->first_name;
        $data["profile_data"]["last_name"] = $user->profile->middle_name;
        $data["profile_data"]["email"] = $user->email;
        $data["profile_data"]["phone"] = $user->phone_number;
        $data["profile_data"]["address"] = $user->profile->address;
        $data["profile_data"]["city"] = $user->profile->city;
        $data["profile_data"]["image"] = $user->profile->profile_image;
        $data["profile_data"]["age"] = $user->profile->age;
        $data["profile_data"]["phone_verified"] = is_null($user->phone_verified_at) ? 0 : 1;
        $data["profile_data"]["email_verified"] = is_null($user->email_verified_at) ? 0 : 1;
        $data["profile_data"]["country_id"] = $user->profile->country_id;
        $data["profile_data"]["country_name"] = is_null($user->profile->country) ? null : $user->profile->country->name;
        $data["profile_data"]["religion"] = ucfirst($user->profile->religion);
        $data["profile_data"]["zip_code"] = is_null($user->profile->postalcode) ? null : $user->profile->postalcode->zipcode;

        return response()->json($data, 200);
    }


    /**
     * @param Request $request
     * method used to update the profile information
     * @return \Illuminate\Http\JsonResponse
     */

    public function updateProfile(Request $request)
    {

        try{
             if (User::find(Auth::user()->id)->exists()){

                 $user = Auth::user();

                 $user_profile = UsersProfile::where('user_id', $user->id)->first();

                 if ($request->email){
                     $user->email = is_null($request->email) ? $user->email : $request->email;
                     $user->save();
                 }


                 if ($request->image){
                     $fileName = time().'.'.$request->image->getClientOriginalExtension();
                     $path = asset('/uploads/profiles/'.$fileName);
                     $request->image->move(public_path('uploads/profiles/'), '/profiles/'.$fileName);
                 }

                 if ($request->zip_code){
                     $postal_id = PostalCode::where('zipcode', $request->zip_code)->first();

                     if ($postal_id){

                         $id = $postal_id->id;
                         $user_profile->postal_code_id = is_null($id) ? null : $id;
                     }else{

                         $errors['data'] = "Zip Code does not exists in the system";
                         return response()->json($errors, 422);
                     }

                 }

                 if($request->phone_number){
                     $user->phone_number = $request->phone_number;
                     $user->country_code = 254;
                     $user->save();
                 }
                 $user_profile->surname = is_null($request->surname) ? $user_profile->surname : $request->surname;
                 $user_profile->first_name = is_null($request->first_name) ? $user_profile->first_name : $request->first_name;
                 $user_profile->middle_name = is_null($request->last_name) ? $user_profile->middle_name : $request->last_name;
                 $user_profile->country_id = is_null($request->country_id) ? $user_profile->country_id : $request->country_id;
                 $user_profile->religion = is_null($request->religion) ? strtolower($user_profile->religion) : strtolower($request->religion);
                 $user_profile->address = is_null($request->address) ? $user_profile->address : $request->address;
                 $user_profile->city = is_null($request->city) ? $user_profile->city : $request->city;
                 $user_profile->age = is_null($request->age) ? $user_profile->age : $request->age;
                 $user_profile->profile_image = is_null($request->image) ? $user_profile->profile_image : $path;

                 $user_profile->save();

                 $success['profile_data'] = array();

                 $success['profile_data'] = UsersProfile::select('surname','first_name', 'address', 'city', 'profile_image', 'age', 'country_id', 'postal_code_id')->where('user_id', Auth::user()->id)->with('country:id,name', 'postalCode:id,zipcode')->get();
                 $success['profile_data'][0]['last_name'] = $user->profile->middle_name;
                 $success['profile_data'][0]['religion'] = $user->profile->religion;
                 $success['profile_data'][0]['email'] = $user->email;
                 $success['profile_data'][0]['email_verified_at'] = is_null($user->email_verified_at) ? 0 : 1;
                 $success['profile_data'][0]['phone_verified_at'] = is_null($user->phone_verified_at) ? 0 : 1;
                 $success['profile_data'][0]['username'] = $user->student_id;



                 $success['message'] = "Success! user profile updated successfully.";
                 return response()->json($success, 200);
            }

        }catch(\Exception $e){
            $errors['data'] = "Something went wrong.".$e->getMessage();
            return response()->json($errors, 403);
        }

    }

    public function certificate()
    {
        $certificates = Certificate::where('student_id', Auth::user()->id)->get();

        foreach ($certificates as $certificate){

            if (!is_null($certificate->file)) {
                $certificate->link = Storage::disk('certificates')->url($certificate->file);
            }
        }

        $data["certificate"] = $certificates;

        return response()->json($data);
    }
}
