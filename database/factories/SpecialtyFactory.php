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
    protected $model = Specialty::class;

    protected static $specialties = [
        ['name' => 'Інженерія програмного забезпечення', 'code' => '121', 'department' => Department::PART_1->value],
        ['name' => 'Геодезія та землеустрій', 'code' => '193', 'department' => Department::PART_1->value],
        ['name' => 'Будівництво та цивільна інженерія', 'code' => '192', 'department' => Department::PART_1->value],
        ['name' => 'Автомобільний транспорт', 'code' => '274', 'department' => Department::PART_1->value],
        ['name' => 'Облік і оподаткування', 'code' => '071', 'department' => Department::PART_2->value],
        ['name' => 'Фінанси, банківська справа та страхування', 'code' => '072', 'department' => Department::PART_2->value],
        ['name' => 'Право', 'code' => '081', 'department' => Department::PART_2->value],
        ['name' => 'Туризм', 'code' => '242', 'department' => Department::PART_2->value],
        ['name' => 'Фізична культура і спорт', 'code' => '017', 'department' => Department::PART_2->value],
    ];

    protected static $usedSpecialties = [];

    public function definition(): array
    {
        if (count(static::$usedSpecialties) >= count(static::$specialties)) {
            static::$usedSpecialties = [];
        }

        $availableSpecialties = array_filter(static::$specialties, function ($specialty) {
            return !in_array($specialty['name'], static::$usedSpecialties);
        });

        $specialty = $this->faker->randomElement($availableSpecialties);
        static::$usedSpecialties[] = $specialty['name'];

        return [
            'name' => $specialty['name'],
            'code' => $specialty['code'],
            'department' => $specialty['department'],
            'description' => $this->faker->optional(0.7)->paragraph(),
        ];
    }
}
