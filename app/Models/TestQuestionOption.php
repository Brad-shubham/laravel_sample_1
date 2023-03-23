<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestQuestionOption extends Model
{
    protected $fillable = ['text', 'is_answer', 'question_id'];

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
    public function question()
    {
        return $this->belongsTo(TestQuestion::class, 'question_id');
    }
}
