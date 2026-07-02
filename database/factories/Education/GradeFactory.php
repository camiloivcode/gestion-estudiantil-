<?php

namespace Database\Factories\Education;

use Illuminate\Database\Eloquent\Factories\Factory;

class GradeFactory extends Factory
{
    protected $model = \App\Models\Education\Grade::class;

    public function definition(): array
    {
        $g1 = fake()->randomFloat(2, 4, 10);
        $g2 = fake()->randomFloat(2, 4, 10);
        $g3 = fake()->randomFloat(2, 4, 10);
        $g4 = fake()->randomFloat(2, 4, 10);

        return [
            'student_id' => \App\Models\Education\Student::factory(),
            'course_id'  => \App\Models\Education\Course::factory(),
            'period'     => fake()->year() . '-' . fake()->randomElement(['1', '2']),
            'grade_1'    => $g1,
            'grade_2'    => $g2,
            'grade_3'    => $g3,
            'grade_4'    => $g4,
            'average'    => round(($g1 + $g2 + $g3 + $g4) / 4, 2),
        ];
    }
}
