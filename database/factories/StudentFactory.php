<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Liamtseva\PGFKEduSystem\Models\Group;
use Liamtseva\PGFKEduSystem\Models\Student;
use Liamtseva\PGFKEduSystem\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Liamtseva\PGFKEduSystem\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Створюємо користувача
            'record_book_number' => strtoupper(Str::random(8)), // Генеруємо номер залікової книжки
            'group_id' => Group::factory(), // Прив'язуємо до випадкової групи
            'enrollment_date' => $this->faker->date(),
            'is_scholarship_holder' => $this->faker->boolean(30), // 30% студентів отримують стипендію
            'birthplace' => $this->faker->city(),
            'birthdate' => $this->faker->date(),
            'phone_number' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'guardian_name' => $this->faker->name(),
            'guardian_phone' => $this->faker->phoneNumber(),
        ];
    }
}
