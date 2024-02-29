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
}
