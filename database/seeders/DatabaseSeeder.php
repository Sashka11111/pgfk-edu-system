<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SpecialtySeeder::class,
            CourseSeeder::class,
            TeacherSeeder::class,
            GroupSeeder::class,
            StudentSeeder::class,
            WorkerSeeder::class,
            SubjectTeacherSeeder::class,
            GroupSubjectSeeder::class,
            StudentSubjectSeeder::class,
        ]);
    }
}
