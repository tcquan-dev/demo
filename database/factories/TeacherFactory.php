<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subjects = ['Math', 'Literature', 'English', 'History', 'Geography', 'Physics', 'Biology', 'Chemistry', 'Physical Education', 'Technology', 'Informatics'];

        return [
            'name' => fake()->name(),
            'gender' => fake()->numberBetween(0, 1),
            'phone_number' => fake()->phoneNumber(),
            'subject' => $subjects[array_rand($subjects)]
        ];
    }
}
