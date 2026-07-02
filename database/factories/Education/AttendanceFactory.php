<?php

namespace Database\Factories\Education;

use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    protected $model = \App\Models\Education\Attendance::class;

    public function definition(): array
    {
        return [
            'student_id' => \App\Models\Education\Student::factory(),
            'course_id'  => \App\Models\Education\Course::factory(),
            'date'       => fake()->date(),
            'status'     => fake()->randomElement(['present', 'absent', 'justified']),
        ];
    }
}
