<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_name',
        'course_description',
        'course_price',
        'start_date',
        'end_date',
        'max_students',
        'file_upload'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
