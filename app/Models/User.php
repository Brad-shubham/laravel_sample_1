<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasApiTokens;

    public const USER_TYPE = [
        'super admin' => 0,
        'admin' => 1,
        'teacher' => 2,
        'student' => 3,
    ];

    public const MARTIAL_STATUS = [
        'married' => 'Married',
        'single' => 'Single',
    ];

    public const ACTIVITY_STATUS = [
        'candidate' => 'Candidate',
        'active' => 'Active',
        'inactive' => 'Inactive',
        'unresponsive' => 'Unresponsive',
    ];

    public const GENDER = [
        'male' => 'Male',
        'female' => 'Female'
    ];

    public const RELIGION_TYPE = [
        'catholic' => 'Catholic',
        'protestant' => 'Protestant',
        'other' => 'Other'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id', 'email', 'password', 'country_code', 'phone_number', 'user_type', 'is_register', 'is_old', 'old_student_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Add necessary date fields are to be used as Carbon instances.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'profile',
        'profile.postalCode',
        'profile.country',
        'profile.language',
    ];

    protected $appends = [
        'formatted_phone_number'
    ];

    /**
     * Return complete phone number with country code
     * @return string
     */
    public function getFormattedPhoneNumberAttribute()
    {
        if ($this->country_code && $this->phone_number) {
            return '+'.$this->country_code.'-'.$this->phone_number;
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne(UsersProfile::class)->withDefault();
    }

    /**
     * @param $identifier
     * @return mixed
     */
    public function findForPassport($identifier)
    {
        return $this->orWhere('email', $identifier)->orWhere('phone_number', $identifier)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function verifyUserEmail()
    {
        return $this->hasOne(VerifyUserEmail::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function testResults()
    {
        return $this->hasMany(TestResult::class, 'student_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'student_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paragraphAnswers()
    {
        return $this->hasMany(ParagraphQuestionsAnswer::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function progress()
    {
        return $this->hasMany(CourseProgress::class, 'student_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lessonProgress()
    {
        return $this->hasMany(LessonStatus::class, 'student_id', 'id');
    }

    /**
     * @param $notification
     * @return mixed
     */
    public function routeNotificationForFcm($notification)
    {
        return $this->device_token;
    }
}
