<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    protected $with = ['books'];

    protected $appends = ['short_name', 'creation_date'];

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
    public function books()
    {
        return $this->hasMany(Book::class);
    }

    /**
     * Get course short name
     *
     * @return string
     */
    public function getShortNameAttribute()
    {
        return Str::limit($this->name, '25');
    }

    public function testResults()
    {
        return $this->hasManyDeep(TestResult::class, [Book::class, Lesson::class, Test::class]);
    }

    public function studentProgress()
    {
        return $this->hasOne(CourseProgress::class);
    }

    public function lessons()
    {
        return $this->hasManyDeep(Lesson::class,
            [Book::class]);
    }

    public function tests()
    {
        return $this->hasManyDeep(Test::class, [Book::class, Lesson::class]);
    }

    public function lessonsStatus()
    {
        return $this->hasManyDeep(LessonStatus::class,
            [Book::class, Lesson::class],
            [
                'course_id',
                'book_id',
                'lesson_id',
            ],
            [
                'id',
                'id',
                'id',
            ]);
    }
}
