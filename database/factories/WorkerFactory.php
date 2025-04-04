<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Liamtseva\PGFKEduSystem\Enums\Position;
use Liamtseva\PGFKEduSystem\Models\User;
use Liamtseva\PGFKEduSystem\Models\Worker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Liamtseva\PGFKEduSystem\Models\Worker>
 */
class WorkerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Worker::class;

    public function definition(): array
    {
        return [
            'user_id' => $this->faker->boolean(50) ? User::factory() : null, // 50% шансів, що user_id буде null
            'last_name' => $this->faker->lastName(), // Прізвище
            'first_name' => $this->faker->firstName(), // Ім’я
            'middle_name' => $this->faker->lastName(), // По батькові
            'position' => $this->faker->randomElement(Position::cases()), // Вибираємо випадкове значення з enum Position
            'phone_number' => $this->faker->optional()->phoneNumber(), // Генеруємо номер телефону (або null)
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'), // Випадкова дата створення
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'), // Випадкова дата оновлення
        ];
    }
}
