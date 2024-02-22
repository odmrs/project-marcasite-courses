<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "course_id",
        "email",
        "cpf",
        'userType',
        "address",
        "company_name",
        "phone",
        "cellphone",
        "password"
    ];
    // Relation with Course database
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    protected static function booted()
    {
        static::created(function ($student) {
            // Obtenha o curso associado ao aluno
            $course = $student->course;

            // Decrementa o número de vagas disponíveis no curso
            if ($course) {
                $course->decrement('max_students');
            }
        });

        static::deleted(function ($student) {
            // Obtenha o curso associado ao aluno
            $course = $student->course;

            // Incrementa o número de vagas disponíveis no curso
            if ($course) {
                $course->increment('max_students');
            }
        });
    }
}
