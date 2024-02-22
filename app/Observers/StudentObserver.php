<?php

namespace App\Observers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StudentObserver
{
    /**
     * Handle the Student "created" event.
     */
    public function created(Student $student): void
    {
        // Create a new user when a student is create
        User::create([
            'name' => $student->name,
            'email' => $student->email,
            'password' => Hash::make($student->password),
            'is_admin' => false,
        ]);
    }

    /**
     * Handle the Student "updated" event.
     */
    public function updated(Student $student): void
    {
        //
    }

    /**
     * Handle the Student "deleted" event.
     */
    public function deleted(Student $student): void
    {

    }

    /**
     * Handle the Student "restored" event.
     */
    public function restored(Student $student): void
    {
        //
    }

    /**
     * Handle the Student "force deleted" event.
     */
    public function forceDeleted(Student $student): void
    {
        //
    }
}
