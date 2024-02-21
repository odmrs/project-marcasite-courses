<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $courses = Course::with('user:id,name')->latest()->get();
        $allcourses = Course::all();
        Log::info($courses);
        Log::info($allcourses);
        return Inertia::render('Courses/Index', [
            'courses' => $courses,
            'allcourses' => $allcourses
        ]);
    }

    public function newCourse()
    {
        return Inertia::render('Courses/Create');
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
            'course_name' => 'required|string|max:255',
            'course_description' => 'required|string',
            'course_price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'max_students' => 'required|integer|min:5',
            'file_upload' => 'nullable|mimes:csv,txt,xlx,xls,pdf|max:2048'
        ]);

        if ($request->hasFile('file_upload')) {
            $filename = uniqid() . '.' . $request->file('file_upload')->getClientOriginalExtension();
            $file_upload = $request->file('file_upload')->storeAs('uploads', $filename);
            $validated['file_upload'] = $filename;
        }

        $request->user()->courses()->create($validated);

        return redirect(route('courses.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course): RedirectResponse
    {
        $this->authorize('update', $course);

        // Define a regra de validação para o campo file_upload
        $validationRules = [
            'course_name' => 'required|string|max:255',
            'course_description' => 'required|string',
            'course_price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'max_students' => 'required|integer|min:5',
        ];

        if ($request->hasFile('file_upload')) {
            $validationRules['file_upload'] = 'nullable|mimes:csv,txt,xlx,xls,pdf|max:2048';
        }

        $validated = $request->validate($validationRules);


        if ($request->hasFile('file_upload')) {
            Storage::delete('uploads/' . $course->file_upload);
            $filename = uniqid() . '.' . $request->file('file_upload')->getClientOriginalExtension();
            $file_upload = $request->file('file_upload')->storeAs('uploads', $filename);
            $validated['file_upload'] = $filename;
        }

        // Atualiza o curso com os dados validados
        $course->update($validated);

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
