<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Test extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'lesson_id'];

    protected $appends = ['short_title', 'creation_date', 'disable_assignment'];

    protected $with = ['lesson'];

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(TestQuestion::class);
    }

    /**
     * Get test short title
     * @return string
     */
    public function getShortTitleAttribute()
    {
        return Str::limit($this->title, '25');
    }

    /**
     * Check if test already taken by the student to disable assignment
     * @return boolean
     */
    public function getDisableAssignmentAttribute()
    {
        return ($this->testProgress()->count() !== 0);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function testResult()
    {
        return $this->hasOne(TestResult::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function testProgress()
    {
        return $this->hasOne(TestProgress::class);
    }
}
