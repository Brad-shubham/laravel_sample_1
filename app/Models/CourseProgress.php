<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseProgress extends Model
{
    const STATUS = [
        'unlock' => 1,
        'progress' => 2,
        'completed' => 3,
    ];

    const GIFT_SENT_LEVELS = [1, 5, 10];

    protected $fillable = ['student_id', 'course_id', 'average_score', 'progress', 'status', 'gift_status'];

    /**
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
