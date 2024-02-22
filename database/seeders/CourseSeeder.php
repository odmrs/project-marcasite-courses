<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuário root
        Course::create([
            'user_id' => 1,
            'course_name' => 'Curso de php',
            'course_description' => 'Um curso sobre php...',
            'course_price' => 59.70,
            'start_date' => '2024-02-14',
            'end_date' => '2024-02-15',
            'max_students' => 89,
        ]);
        Course::create([
            'user_id' => 1,
            'course_name' => 'Curso de Vuejs',
            'course_description' => 'Um curso sobre vuejs...',
            'course_price' => 200,
            'start_date' => '2024-02-12',
            'end_date' => '2024-02-15',
            'max_students' => 48,
        ]);
        Course::create([
            'user_id' => 1,
            'course_name' => 'Curso de Laravel',
            'course_description' => 'Um curso sobre Laravel...',
            'course_price' => 500,
            'start_date' => '2024-02-12',
            'end_date' => '2024-02-15',
            'max_students' => 200,
        ]);

    }
}
