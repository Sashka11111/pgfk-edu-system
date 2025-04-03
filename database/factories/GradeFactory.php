<?php

namespace Liamtseva\PGFKEduSystem\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Liamtseva\PGFKEduSystem\Models\Grade;
use Liamtseva\PGFKEduSystem\Models\Student;
use Liamtseva\PGFKEduSystem\Models\Subject;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Liamtseva\PGFKEduSystem\Models\Grade>
 */
class GradeFactory extends Factory
{
    protected $model = Grade::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => Student::factory(), // Створює або посилається на студента
            'subject_id' => Subject::factory(), // Створює або посилається на предмет
            'grade' => $this->faker->optional(0.3)->numberBetween(60, 100), // 30% шансів, що оцінка буде null
            'is_failed' => $this->faker->boolean(20), // 20% шансів, що предмет не зараховано
            'exam_date' => $this->faker->dateTimeBetween('-1 year', 'now'), // Випадкова дата за останній рік
            'semester' => $this->faker->randomElement(['1', '2', '3', '4', '5', '6']), // Випадковий семестр
        ];
    }

    /**
     * Indicate that the grade is failed.
     *
     * @return static
     */
    public function failed(): static
    {
        return $this->state([
            'grade' => null,
            'is_failed' => true,
        ]);
    }

    /**
     * Indicate that the grade is for a specific semester.
     *
     * @param string $semester
     * @return static
     */
    public function forSemester(string $semester): static
    {
        return $this->state([
            'semester' => $semester,
        ]);
    }
}
