<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestResult extends Model
{
    use \Znck\Eloquent\Traits\BelongsToThrough;

    protected $fillable = [
        'student_id', 'test_id', 'teacher_id', 'total_marks', 'total_questions', 'percentage', 'status'
    ];

    protected $appends = ['creation_date'];

    protected $casts = [
        'percentage' => 'float',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    const PASSING_PERCENTAGE = 70;

    const STATUS = [
        'pending' => 1,
        'qualified' => 2,
        'not_qualified' => 3,
    ];

    /**
     * Get create at date
     *
     * @return string
     */
    public function getCreationDateAttribute(){
        return Carbon::parse($this->created_at)->format('M d, Y');
    }

    /**
     * Get update at date
     *
     * @return string
     */
    public function getUpdationDateAttribute(){
        return Carbon::parse($this->updated_at)->format('M d, Y');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function answer()
    {
        return $this->hasOne(TestAnswer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id')->withTrashed();
    }

    /**
     * @return \Znck\Eloquent\Relations\BelongsToThrough
     */
    public function course()
    {
        return $this->belongsToThrough(Course::class, [Book::class, Lesson::class, Test::class])
            ->withTrashed('tests.deleted_at');
    }
}
