<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class Book extends Model
{
    protected $with = ['lessons'];

    protected $appends = ['short_name', 'short_author_name', 'creation_date', 'disable_assignment'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Get create at date
     *
     * @return string
     */
    public function getCreationDateAttribute()
    {
        return Carbon::parse($this->created_at)->format('M d, Y');
    }

    /**
     * Get update at date
     *
     * @return string
     */
    public function getUpdationDateAttribute()
    {
        return Carbon::parse($this->updated_at)->format('M d, Y');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'book_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookSections()
    {
        return $this->hasMany(BookSection::class, 'book_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get book short name
     *
     * @return string
     */
    public function getShortNameAttribute()
    {
        return Str::limit($this->name, '25');
    }

    /**
     * Get author short name
     *
     * @return string
     */
    public function getShortAuthorNameAttribute()
    {
        return Str::limit($this->author, '25');
    }

    /**
     * Check if book already taken by the student to disable assignment
     * @return boolean
     */
    public function getDisableAssignmentAttribute()
    {
        if($this->lessons()->exists()){
            return ($this->lessons()->first()->lessonStatus()->count() !== 0);
        }
        else {
            return false;
        }
    }
}
