<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Liamtseva\PGFKEduSystem\Models\Group;
use Liamtseva\PGFKEduSystem\Models\Specialty;
use Liamtseva\PGFKEduSystem\Models\Teacher;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Liamtseva\PGFKEduSystem\Models\Group>
 */
class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Group::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->bothify('??-##'), // Наприклад, "AB-123"
            'year_of_study' => $this->faker->numberBetween(1, 4), // Рік навчання від 1 до 5
            'specialty_id' => Specialty::query()->inRandomOrder()->value('id') ?? null, // Випадкова спеціальність
            'teacher_id' => Teacher::query()->inRandomOrder()->value('id') ?? null, // Випадковий викладач
        ];
    }
}
