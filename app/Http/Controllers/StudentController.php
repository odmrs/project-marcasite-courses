<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $students = Student::all();
        $courses = Course::all();

        return Inertia::render('Students/Index', [
            'students' => $students,
            'courses' => $courses,
        ]);
    }

    public function newStudent()
    {
        $courses = Course::all();

        return Inertia::render('Students/Create', [
            'courses' => $courses,
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
            'status' => 'string|in:pago,pendente',
            'phone' => 'telefone',
            'cellphone' => [
                'required',
                'regex:/^\(\d{2}\)\s?\d{4,5}-\d{4}$/',
            ],
            'password' => 'required|string|min:6|max:255',
        ]);

        $student = Student::create($validated);

        $courseId = $request->input('course_id');
        $student->courses()->attach($courseId);

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
        return inertia::render('Students/Update', [
            'student' => $student,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student): RedirectResponse
    {
        $validatedRulesValidation = [
            'name' => 'string|max:255',
            'course_id' => 'exists:courses,id',
            'email' => 'email',
            'cpf' => 'cpf',
            'address' => 'string|max:255',
            'company_name' => 'nullable|string|max:255',
            'userType' => 'string|in:estudante,profissional,associado',
            'status' => 'string|in:pago,pendente',
            'phone' => 'telefone',
            'cellphone' => [
                'regex:/^\(\d{2}\)\s?\d{4,5}-\d{4}$/',
            ],
            'password' => 'string|min:6|max:255',
        ];
        $validated = $request->validate($validatedRulesValidation);

        $student->update($validated);

        $courseIds = $request->input('course_ids', []);
        $student->courses()->sync($courseIds);

        return redirect(route('students.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student): RedirectResponse
    {
        $student->delete();

        return redirect(route('students.index'));
    }
}
