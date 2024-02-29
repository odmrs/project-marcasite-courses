<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MyCourseController extends Controller
{
    public function index()
    {
        $lastStudentId = Student::latest()->value('id');

        $user = Auth::user();
        if ($user && ! $user->userType) {
            $lastStudent = Student::find($lastStudentId);
            $courses = $lastStudent ? $lastStudent->courses : [];
        } else {
            $courses = [];
        }

        return Inertia::render('Courses/All', [
            'courses' => $courses,
        ]);
    }
}
