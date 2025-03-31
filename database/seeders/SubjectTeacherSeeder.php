<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Liamtseva\PGFKEduSystem\Models\Teacher;
use Liamtseva\PGFKEduSystem\Models\Subject;

class SubjectTeacherSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = Teacher::all();

        foreach ($teachers as $teacher) {
            $subjectsCount = rand(2, 3);
            $subjectsToAssign = Subject::inRandomOrder()->take($subjectsCount)->get();

            foreach ($subjectsToAssign as $subject) {
                $teacher->subjects()->attach($subject->id);
            }
        }
    }
}
