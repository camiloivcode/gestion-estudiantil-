<?php

namespace Database\Factories\Education;

use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    protected $model = \App\Models\Education\Course::class;

    public function definition(): array
    {
        return [
            'name'        => fake()->unique()->words(3, true),
            'code'        => strtoupper(fake()->bothify('???-###')),
            'teacher_id'  => \App\Models\Education\Teacher::factory(),
            'program_id'  => \App\Models\Education\Program::factory(),
            'credits'     => fake()->numberBetween(2, 6),
            'status'      => 'active',
            'description' => fake()->sentence(),
        ];
    }
}
