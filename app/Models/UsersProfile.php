<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class UsersProfile extends Model
{
    use SoftDeletes;

    protected $table = 'users_profile';

    protected $casts = [
        'date_enrolled' => 'datetime:M d, Y',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'surname', 'first_name', 'middle_name', 'birth_year', 'age', 'gender', 'address',
        'city',
        'country_id', 'private_mail_po_number', 'org_po_number', 'designation', 'encouragement_card_sent', 'prisoner',
        'marital_status', 'religion', 'course_language_id', 'date_enrolled', 'last_test', 'activity_status',
        'postal_code_id', 'comment'
    ];

    protected $appends = [
        'full_name', 'short_first_name', 'short_surname', 'formatted_encouragement_card_sent', 'formatted_last_test'
    ];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->middle_name . ' ' . $this->surname;
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFormattedEncouragementCardSentAttribute()
    {
        return $this->encouragement_card_sent ? date('M d, Y',
            strtotime($this->encouragement_card_sent)) : $this->encouragement_card_sent;
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFormattedLastTestAttribute()
    {
        return $this->last_test ? date('M d, Y', strtotime($this->last_test)) : $this->last_test;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function postalCode()
    {
        return $this->hasOne(PostalCode::class, 'id', 'postal_code_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function language()
    {
        return $this->hasOne(Language::class, 'id', 'course_language_id');
    }

    /**
     * Get user short first name
     * @return string
     */
    public function getShortFirstNameAttribute()
    {
        return Str::limit($this->first_name, '25');
    }

    /**
     * Get user short last name
     * @return string
     */
    public function getShortSurnameAttribute()
    {
        return Str::limit($this->surname, '25');
    }
}
