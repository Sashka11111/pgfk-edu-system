<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Liamtseva\PGFKEduSystem\Models\Subject;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Liamtseva\PGFKEduSystem\Models\Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Subject::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3), // Генерує випадкову назву
            'description' => $this->faker->paragraph(), // Випадковий опис
            'hours' => $this->faker->numberBetween(10, 100), // Випадкове число годин
        ];
    }
}
