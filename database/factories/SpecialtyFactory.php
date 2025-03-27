<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Liamtseva\PGFKEduSystem\Enums\Department;
use Liamtseva\PGFKEduSystem\Models\Specialty;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Liamtseva\PGFKEduSystem\Models\Specialty>
 */
class SpecialtyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Specialty::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Облік і оподаткування',
                'Фінанси, банківська справа та страхування',
                'Право',
                'Інженерія програмного забезпечення',
                'Геодезія та землеустрій',
                'Будівництво та цивільна інженерія',
                'Туризм',
                'Автомобільний транспорт',
                'Фізична культура і спорт'
            ]), // Випадкова назва спеціальності
            'code' => $this->faker->unique()->randomElement([
                '071', '072', '081', '121', '193', '192', '242', '274', '017'
            ]), // Відповідний код спеціальності
            'department' => $this->faker->randomElement(Department::cases())->value, // Випадкове відділення
            'description' => $this->faker->optional()->paragraph(), // Опис (може бути null)
        ];
    }
}
