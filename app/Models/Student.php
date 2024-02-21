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
        "address",
        "company_name",
        "phone",
        "cellphone",
        "password"
    ];
}
