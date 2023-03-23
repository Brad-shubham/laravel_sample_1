<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginUserRequest;
use App\Http\Requests\Api\V1\Register\UserStoreRequest;
use App\Models\Course;
use App\Models\CourseProgress;
use App\Models\LessonStatus;
use App\Models\Test;
use App\Models\TestProgress;
use App\Models\User;
use App\Models\UsersProfile;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;

class UserController extends Controller
{
    use HasApiTokens;
    /**
     *  This constant variable is declared for success status.
     *
     *  @param $successStatus
     */
    public $successStatus = 200;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * register api
     *
     * @param UserStoreRequest $request
     * @return JsonResponse
     *
     */

    public function register(UserStoreRequest $request)
    {
        try{
            if($request->get('student_id')){
                $data = $request->registerData();
                $student_id = $request->get('student_id');

                $user = User::whereStudentId($student_id)->first();

                if ($user == null){
                    $errors['error'] = "Student ID does not exists in the system";
                    return response()->json($errors, 404);
                }else{

                    if ($user->is_register == false){

                        DB::beginTransaction();

                        $user->email = $data['email'];
                        $user->password = $data['password'];
                        $user->phone_number = $data['phone_number'];
                        $user->country_code = 254;
                        $user->user_type = 3;
                        $user->student_id = $student_id;
                        $user->is_register = 1;
                        $user->save();

                        UsersProfile::whereUserId($user->id)->update([
                            'surname' => $data['surname'],
                            'first_name' => $data['first_name'],
                            'middle_name' => $data['last_name'],
                            'country_id' => $data['country_id'],
                            'activity_status' => 'candidate',
                            'date_enrolled' => Carbon::now()
                        ]);

                        if ($request->image){
                            $filename = time().'.'.$request->image->getClientOriginalExtension();
                            $path = asset('/uploads/profiles/'.$filename);
                            $request->image->move(public_path('/uploads/profiles'), '/profiles/'.$filename);

                            UsersProfile::where('user_id', $user->id)->update(['profile_image'  => $path ]);

                        }

                        $tokenResult = $user->createToken(env('APP_NAME'));
                        $token = $tokenResult->token;
                        $token->expires_at = Carbon::now()->addWeeks(1);
                        $token->save();
                        $success['access_token'] = $tokenResult->accessToken;
                        $success['token_type'] = "Bearer";
                        $success['expires_in'] = Carbon::parse(
                            $tokenResult->token->expires_at
                        )->toDateTimeString();


                        $response["data"]["status"] = "success";
                        $response["data"]["response"] = "User Successfully Updated";
                        $response["data"]["token"] = $success;

                        if ($success){

                            // Create an entry for course progress
                            $course = Course::with('books.lessons')->first();

                            CourseProgress::updateorCreate([
                                'student_id' => $user->id,
                                'course_id' => $course->id,
                            ],[
                                'student_id' => $user->id,
                                'course_id' => $course->id,
                                'status' => 1,
                            ]);

                            // Get the lessonId
//                            $lessonValue = $course->lessons()->get()->toArray();
//                            $getFirstLesson = current($lessonValue);
//                            $getLessonId = $getFirstLesson['id'];
                            $firstLesson = $course->lessons()->first();

                            // Create an entry for lesson status
                            LessonStatus::updateorCreate([
                                'student_id' => $user->id,
                                'lesson_id' => $firstLesson->id,
                            ],[
                                'student_id' => $user->id,
                                'lesson_id' => $firstLesson->id,
                                'is_unlocked' => 1
                            ]);

                            // Create an entry for test progress
//                            $query = Test::Orderby('id')->first();
                            $firstTest = $firstLesson->test()->first();

                            if ($firstTest != null){

                                $testID = $firstTest->id;
                                TestProgress::updateOrCreate([
                                    'student_id' => $user->id,
                                    'test_id' => $testID,
                                ],[
                                    'student_id' => $user->id,
                                    'test_id' => $testID,
                                    'is_unlocked' => false
                                ]);
                            }

                        }

                        DB::commit();

                        return response()->json($response, 200);

                    }else{
                        $errors['error'] = "Student already migrated in the system";
                        return response()->json($errors, 409);
                    }
                }

            }
            else
            {
                $data = $request->registerData();
//                $digits = 7;
//                $student_id = rand(pow(10, $digits-1), pow(10, $digits)-1);

                $lastEnrolledStudent = User::withTrashed()
                    ->where('user_type', User::USER_TYPE['student'])
//                    ->where('is_old', false)
                    ->get()
                    ->last();

                if (is_null($lastEnrolledStudent)) {
                    $studentID = 1000000; // 7 digit number
                } else {
                    $studentID = $lastEnrolledStudent->student_id + 1;
                }


                DB::beginTransaction();

                $user = new User([
                    'email' => $data['email'],
                    'password' => $data['password'],
                    'phone_number' => $data['phone_number'],
                    'user_type' => 3,
                    'student_id' => $studentID,
                    'country_code' => 254,
                    'is_register' => 1
                ]);

                $user->save();

                $user_profile = new UsersProfile([
                    'surname' => $data['surname'],
                    'first_name' => $data['first_name'],
                    'middle_name' => $data['last_name'],
                    'country_id' => $data['country_id'],
                    'user_id' => $user->id,
                    'date_enrolled' => Carbon::now()
                ]);


                $user_profile->save();

                if ($request->image){
                    $filename = time().'.'.$request->image->getClientOriginalExtension();
                    $path = asset('/uploads/profiles/'.$filename);
                    $request->image->move(public_path('/uploads/profiles'), '/profiles/'.$filename);

                    UsersProfile::where('user_id', $user->id)->update(['profile_image'  => $path ]);

                }

                $tokenResult = $user->createToken(env('APP_NAME'));
                $token = $tokenResult->token;
                $token->expires_at = Carbon::now()->addWeeks(1);
                $token->save();
                $success['access_token'] = $tokenResult->accessToken;
                $success['token_type'] = "Bearer";
                $success['expires_in'] = Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString();


                $response["data"]["status"] = "success";
                $response["data"]["response"] = "User Successfully Created";
                $response["data"]["token"] = $success;

                if ($success){

                    // Create an entry for course progress
                    $course = Course::with('books.lessons')->first();
                    CourseProgress::updateorCreate([
                        'student_id' => $user->id,
                        'course_id' => $course->id,
                    ],[
                        'student_id' => $user->id,
                        'course_id' => $course->id,
                        'status' => 1,
                    ]);

                    // Get the lessonId
                    $course = Course::with('books.lessons')->Orderby('id')->first();
                    $firstLesson = $course->lessons()->first();
//                    $lessonValue = $course->lessons()->get()->toArray();
//                    $getFirstLesson = current($lessonValue);
//                    $getLessonId = $getFirstLesson['id'];


                    // Create an entry for lesson status
                    LessonStatus::updateorCreate([
                        'student_id' => $user->id,
                        'lesson_id' => $firstLesson->id,
                    ],[
                        'student_id' => $user->id,
                        'lesson_id' => $firstLesson->id,
                        'is_unlocked' => 1
                    ]);

                    // Create an entry for test progress
//                    $query = Test::Orderby('id')->first();
                    $firstTest = $firstLesson->test()->first();

                    if ($firstTest != null){
                        $testID = $firstTest->id;
                        TestProgress::updateOrCreate([
                            'student_id' => $user->id,
                            'test_id' => $testID,
                        ],[
                            'student_id' => $user->id,
                            'test_id' => $testID,
                            'is_unlocked' => false
                        ]);
                    }
                }

                DB::commit();

                return response()->json($response, 200);

            }

        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 403);
        }

    }

    /**
     *  login api.
     *
     * @param LoginUserRequest $request
     * @return JsonResponse
     */

    public function login(LoginUserRequest $request)
    {
        try{
            if (($request->loginData())){
                $http = new \GuzzleHttp\Client;
                $data = $request->loginData();

                if (array_key_exists("email",$data))
                {
                    $username = $data['email'];
                }
                else
                {
                    $username = $data['phone_number'];
                }

                $response = $http->post( env('APP_URL').'/oauth/token', [
                    'form_params' => [
                        'grant_type' => 'password',
                        'client_id' => env('CLIENT_ID'),
                        'client_secret' => env('CLIENT_SECRET'),
                        'username' => $username,
                        'password' => $data["password"],
                        'scope' => '*',
                    ],
                ]);

                return json_decode((string) $response->getBody(), true);

            }else{
                return response()->json(['error' => array('error_msg' => ['Oops! you have entered the wrong credentials'])], 401);
            }

        }catch (\Exception $e){
            return response()->json(['error' => array('error_msg' => ['Oops! you have entered the wrong credentials'])], 401);
        }
    }
}
