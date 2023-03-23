<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lesson extends Model
{
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;
    use \Znck\Eloquent\Traits\BelongsToThrough;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $appends = ['short_name', 'creation_date', 'disable_assignment'];

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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function test()
    {
        return $this->hasOne(Test::class, 'lesson_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paragraphs()
    {
        return $this->hasMany(Paragraph::class, 'lesson_id')->orderBy('order_number');
    }

    /**
     * @return string
     */
    public function getShortNameAttribute()
    {
        return Str::limit($this->name, '25');
    }

    /**
     * Check if lesson already taken by the student to disable assignment
     * @return boolean
     */
    public function getDisableAssignmentAttribute()
    {
        return ($this->lessonStatus()->count() !== 0);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lessonStatus()
    {
        return $this->hasOne(LessonStatus::class, 'lesson_id');
    }

    public function paragraphAnswers()
    {
        return $this->hasManyDeep(ParagraphQuestionsAnswer::class,
            [Paragraph::class, ParagraphQuestion::class],
            [
                'lesson_id',
                'paragraph_id',
                'question_id',
            ],
            [
                'id',
                'id',
                'id',
            ]);
    }

    public function course()
    {
        return $this->belongsToThrough(Course::class, [Book::class]);
    }

    public function paraQuestions()
    {
        return $this->hasManyDeep(ParagraphQuestion::class,
            [Paragraph::class]);
    }
}
