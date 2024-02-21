<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\RegisteredUserController;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('Register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
// Routes just for admin and auth users
// dashboard routes
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    // Course's routes
    Route::resource('courses', CourseController::class)
        ->only(['store', 'update', 'destroy'])
        ->middleware(['auth', 'verified']);
    Route::match(['get', 'post'], '/courses/create', [CourseController::class, 'newCourse'])->name('courses.create');

    // Student's routes
    Route::resource('students', StudentController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->middleware(['auth', 'verified']);
    Route::match(['get', 'post'], '/students/create', [StudentController::class, 'newStudent'])->name('students.create');
});

Route::resource('courses', CourseController::class)
    ->only(['index'])
    ->middleware(['auth', 'verified']);

// Download files
Route::get('/downloads/{filename}', function ($filename) {
    $path = storage_path('app/uploads/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }
    return response()->download($path);
})->where('filename', '.*');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
