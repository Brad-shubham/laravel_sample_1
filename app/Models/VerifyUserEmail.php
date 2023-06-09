<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerifyUserEmail extends Model
{
    protected $guarded = [];

    /**
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
