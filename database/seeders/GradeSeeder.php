<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Liamtseva\PGFKEduSystem\Models\Grade;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Grade::factory()->count(10)->create();
    }
}
