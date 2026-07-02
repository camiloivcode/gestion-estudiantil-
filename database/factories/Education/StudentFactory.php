<?php

namespace Database\Factories\Education;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = \App\Models\Education\Student::class;

    public function definition(): array
    {
        return [
            'name'            => fake()->name(),
            'email'           => fake()->unique()->safeEmail(),
            'student_code'    => fake()->unique()->numerify('####-###'),
            'semester'        => fake()->numberBetween(1, 10),
            'status'          => 'active',
            'program_id'      => \App\Models\Education\Program::factory(),
            'enrollment_date' => fake()->date(),
        ];
    }
}
