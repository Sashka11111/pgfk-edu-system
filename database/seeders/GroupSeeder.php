<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Liamtseva\PGFKEduSystem\Models\Group;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Group::factory()->count(10)->create();
    }
}
