<?php

namespace Database\Factories\Education;

use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherFactory extends Factory
{
    protected $model = \App\Models\Education\Teacher::class;

    public function definition(): array
    {
        return [
            'name'      => fake()->name(),
            'email'     => fake()->unique()->safeEmail(),
            'specialty' => fake()->jobTitle(),
            'status'    => 'active',
        ];
    }
}
