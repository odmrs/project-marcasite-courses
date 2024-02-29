<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'course_id',
        'email',
        'cpf',
        'userType',
        'address',
        'company_name',
        'phone',
        'cellphone',
        'password',
        'status',
    ];

    // Relation with Course database
    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    protected static function booted()
    {
        static::created(function ($student) {
            $course = $student->course;

            if ($course) {
                $course->decrement('max_students');
            }
        });

        static::deleted(function ($student) {
            $course = $student->course;

            if ($course) {
                $course->increment('max_students');
            }
        });
    }
}
