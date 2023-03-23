<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Certificate extends Model
{
    const LEVELS = [
        'One' => 1,
        'Two' => 2,
        'Three' => 3,
    ];

    const AWARDED_AT = [
        1 => 'One',
        5 => 'Two',
        10 => 'Three',
    ];

    protected $fillable = ['student_id', 'level', 'teacher_id', 'file'];

    /**
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $appends = [
        'url',
    ];

    /**
     * Return url of the certificate generated
     *
     * @return mixed
     */
    public function getUrlAttribute(){
        return Storage::disk('certificates')->url($this->file);
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
}
