<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Students/Index', [
            // resources/js/Pages/Students/Index.vue
        ]);
    }

    public function newStudent()
    {
        $courses = Course::all();
        return Inertia::render('Students/Create', [
            'courses' => $courses
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'email' => 'required|email|unique:students,email',
            'cpf' => 'required|cpf|unique:students,cpf',
            'address' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'userType' => 'required|string|in:estudante,profissional,associado',
            'phone' => 'telefone',
            'cellphone' => [
                'required',
                'regex:/^\(\d{2}\)\s?\d{4,5}-\d{4}$/'
            ],
            'password' => 'required|string|min:6|max:255',
        ]);

        Student::create($validated);

        return redirect(route('students.index'));
    }


    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }
}
