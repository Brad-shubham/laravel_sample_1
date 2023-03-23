<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParagraphQuestionsAnswer extends Model
{
    use \Znck\Eloquent\Traits\BelongsToThrough;

    protected $fillable = ['user_id', 'question_id', 'answer'];

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
    public function paragraphQuestion()
    {
        return $this->belongsTo(ParagraphQuestion::class, 'question_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
