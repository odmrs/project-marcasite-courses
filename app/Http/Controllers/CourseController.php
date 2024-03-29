<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $courses = Course::with('user:id,name')->latest()->get();

        return Inertia::render('Courses/Index', [
            'courses' => $courses,
        ]);
    }

    public function newCourse()
    {
        return Inertia::render('Courses/Create');
    }

    public function editCourse(Course $course)
    {
        // $this->authorize('update', $course);
        return Inertia::render('Courses/Update', [
            'course' => $course,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course, Student $student): RedirectResponse
    {
        $course->students()->attach($student);

        return redirect(route('Index'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $validated = $request->validate([
            'course_name' => 'required|string|max:255',
            'course_description' => 'required|string',
            'course_price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'max_students' => 'required|integer|min:5',
            'file_upload' => 'nullable|mimes:csv,txt,xlx,xls,pdf|max:2048',
        ]);

        // Store a file into -> storage/uploads/
        if ($request->hasFile('file_upload')) {
            $filename = uniqid().'.'.$request->file('file_upload')->getClientOriginalExtension();
            $file_upload = $request->file('file_upload')->storeAs('uploads', $filename);
            $validated['file_upload'] = $filename;
        }

        $course = $request->user()->courses()->create($validated);
        $studentIds = $request->input('student_ids', []); // Receber os IDs dos alunos selecionados
        $course->students()->attach($studentIds);

        return redirect(route('courses.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        return Inertia::render('Courses/Update', [
            'course' => $course,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        return Inertia::render('Courses/Update', [
            'course' => $course,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course): RedirectResponse
    {
        $this->authorize('update', $course);

        // Define a regra de validação para o campo file_upload
        $validationRules = [
            'course_name' => 'string|max:255',
            'course_description' => 'string',
            'course_price' => 'numeric|min:0',
            'start_date' => 'date',
            'end_date' => 'date|after_or_equal:start_date',
            'max_students' => 'integer|min:5',
        ];

        // I create this to fix bug of file, don't upgrade the tabe
        if ($request->hasFile('file_upload')) {
            $validationRules['file_upload'] = 'nullable|mimes:csv,txt,xlx,xls,pdf|max:2048';
        }

        $validated = $request->validate($validationRules);

        if ($request->hasFile('file_upload')) {
            Storage::delete('uploads/'.$course->file_upload);
            $filename = uniqid().'.'.$request->file('file_upload')->getClientOriginalExtension();
            $file_upload = $request->file('file_upload')->storeAs('uploads', $filename);
            $validated['file_upload'] = $filename;
        }

        // Atualiza o curso com os dados validados
        $course->update($validated);

        $studentIds = $request->input('student_ids', []); // Receber os IDs dos alunos selecionados
        $course->students()->sync($studentIds);

        return redirect(route('courses.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course): RedirectResponse
    {
        $this->authorize('delete', $course);
        $course->delete();

        return redirect(route('courses.index'));
    }
}
