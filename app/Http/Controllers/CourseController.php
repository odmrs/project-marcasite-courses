<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Storage;


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
            'file_upload' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
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

        // Adiciona a validação para o campo file_upload somente se um novo arquivo for enviado
        if ($request->hasFile('file_upload')) {
            $validationRules['file_upload'] = 'nullable|mimes:csv,txt,xlx,xls,pdf|max:2048';
        }

        // Valida os dados do formulário
        $validated = $request->validate($validationRules);

        // Se um novo arquivo foi enviado, realiza o processo de upload e atualiza o nome do arquivo no banco de dados
        if ($request->hasFile('file_upload')) {
            // Remove o arquivo anterior
            Storage::delete('uploads/' . $course->file_upload);

            // Salva o novo arquivo
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
    public function destroy(Course $course)
    {
        //
    }
}
