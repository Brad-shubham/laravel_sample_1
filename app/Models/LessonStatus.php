<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonStatus extends Model
{
    use \Znck\Eloquent\Traits\BelongsToThrough;

    protected $fillable = ['lesson_id', 'student_id', 'is_complete', 'is_unlocked'];

    /**
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id');
    }

    public function course()
    {
        return $this->belongsToThrough(Course::class, [Book::class, Lesson::class]);
    }
}
