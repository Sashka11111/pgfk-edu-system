<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Liamtseva\PGFKEduSystem\Enums\Gender;
use Liamtseva\PGFKEduSystem\Enums\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Liamtseva\PGFKEduSystem\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password = 'Password123$';

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => fake()->randomElement([now(), null]),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => fake()->randomElement([Role::STUDENT->value,Role::TEACHER->value, Role::ADMIN->value]),
            'gender' => fake()->randomElement([Gender::MALE->value,Gender::FEMALE->value, Gender::OTHER->value]),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => Role::ADMIN->value,
        ]);
    }
}
