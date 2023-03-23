<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('v1/register', 'Api\V1\UserController@register');
Route::post('v1/login','Api\V1\UserController@login');
Route::get('v1/religion_list', 'Api\V1\ReligionController@religionList');
Route::post('v1/password_reset', 'Api\V1\ForgotPasswordController');
Route::get('v1/country_list', 'Api\V1\CountryController@countryList');
Route::post('v1/student_register', 'Api\V1\StudentController@studentRegister');
Route::get('v1/check_student/{student_id}', 'Api\V1\StudentController@checkStudent');
Route::post('v1/verify', 'Api\V1\ForgotPasswordController@verify');
Route::post('v1/set_password', 'Api\V1\ForgotPasswordController@setPassword');

Route::middleware('auth:api')->group(function (){
    Route::get('v1/show_profile', 'Api\V1\EditProfileController@showProfile');
    Route::put('v1/update_profile', 'Api\V1\EditProfileController@updateProfile');
    Route::post('v1/send_verification_email', 'Api\V1\EmailVerificationController@sendVerificationEmail');
    Route::post('v1/send_otp', 'Api\V1\PhoneVerificationController@sendOtp');
    Route::post('v1/phone_verification', 'Api\V1\PhoneVerificationController@verifyOtp');
    Route::get('v1/courses/', 'Api\V1\CourseController@course');
    Route::get('v1/course/{courseId}', 'Api\V1\CourseController@show');
    Route::get('v1/course/{id}/book', 'Api\V1\BookController@bookList');
    Route::get('v1/book/{id}/lesson', 'Api\V1\LessonController@lessonList');
    Route::get('v1/test_question/{id}', 'Api\V1\TestController@test');
    Route::post('v1/test_answer', 'Api\V1\TestController@testAnswer');
    Route::get('v1/lesson/{id}', 'Api\V1\LessonController@lesson');
    Route::post('v1/store_token', 'Api\V1\FCMController@storeDeviceToken');
    Route::get('v1/paragraph/{id}', 'Api\V1\ParagraphController@paragraph');
    Route::post('v1/para_answer', 'Api\V1\ParagraphController@paragraphAnswer');
    Route::get('v1/notification/','Api\V1\NotificationController@getNotification');
    Route::get('v1/student/certificate', 'Api\V1\EditProfileController@certificate');
});
