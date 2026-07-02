<?php

namespace Database\Factories\Education;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProgramFactory extends Factory
{
    protected $model = \App\Models\Education\Program::class;

    public function definition(): array
    {
        return [
            'name'               => fake()->unique()->words(3, true),
            'code'               => strtoupper(fake()->lexify('???')),
            'description'        => fake()->sentence(),
            'duration_semesters' => fake()->numberBetween(6, 12),
        ];
    }
}
