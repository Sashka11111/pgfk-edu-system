<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Liamtseva\PGFKEduSystem\Models\Group;
use Liamtseva\PGFKEduSystem\Models\Subject;

class GroupSubjectSeeder extends Seeder
{
    public function run(): void
    {
        $groups = Group::all();

        foreach ($groups as $group) {
            $subjectsCount = rand(3, 5);
            $subjectsToAssign = Subject::inRandomOrder()->take($subjectsCount)->get();

            foreach ($subjectsToAssign as $subject) {
                $group->subjects()->attach($subject->id);
            }
        }
    }
}
