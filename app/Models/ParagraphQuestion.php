<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParagraphQuestion extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

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
    public function paragraph()
    {
        return $this->belongsTo(Paragraph::class, 'paragraph_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function paraAnswer()
    {
        return $this->hasOne(ParagraphQuestionsAnswer::class, 'question_id');
    }
}
