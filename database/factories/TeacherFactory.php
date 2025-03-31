<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Liamtseva\PGFKEduSystem\Enums\Department;
use Liamtseva\PGFKEduSystem\Enums\Qualification;
use Liamtseva\PGFKEduSystem\Models\Subject;
use Liamtseva\PGFKEduSystem\Models\Teacher;
use Liamtseva\PGFKEduSystem\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Liamtseva\PGFKEduSystem\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Teacher::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Створюємо пов’язаного користувача
            'qualification' => $this->faker->randomElement(Qualification::cases()), // Випадкова кваліфікація
            'phone_number' => $this->faker->phoneNumber(), // Генеруємо номер телефону
            'experience_years' => $this->faker->numberBetween(1, 40), // Випадковий досвід у роках
        ];
    }
    public function withSubjects($count = 1)
    {
        return $this->afterCreating(function (Teacher $teacher) use ($count) {
            $subjects = Subject::factory()->count($count)->create();
            $teacher->subjects()->attach($subjects);
        });
    }
}
