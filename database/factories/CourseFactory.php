<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Liamtseva\PGFKEduSystem\Models\Course;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Liamtseva\PGFKEduSystem\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Course::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3), // Генерує випадкову назву
            'description' => $this->faker->paragraph(), // Випадковий опис
            'hours' => $this->faker->numberBetween(10, 100), // Випадкове число годин
        ];
    }
}
