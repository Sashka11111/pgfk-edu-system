<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Liamtseva\PGFKEduSystem\Models\Student;
use Liamtseva\PGFKEduSystem\Models\Subject;

class StudentSubjectSeeder extends Seeder
{
    /**
     * Run the seeder.
     */
    public function run(): void
    {
        // Отримуємо всіх студентів
        $students = Student::all();

        // Перевіряємо, чи є студенти та предмети в базі
        if ($students->isEmpty() || Subject::count() === 0) {
            throw new \Exception('Спочатку створіть студентів і предмети перед запуском цього сідера.');
        }

        // Проходимо по кожному студентові
        foreach ($students as $student) {
            // Випадкова кількість предметів для студента (від 3 до 5)
            $subjectsCount = rand(3, 5);

            // Вибираємо випадкові предмети
            $subjectsToAssign = Subject::inRandomOrder()
                ->take($subjectsCount)
                ->get();

            // Призначаємо предмети студентові
            foreach ($subjectsToAssign as $subject) {
                $student->subjects()->attach($subject->id, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
