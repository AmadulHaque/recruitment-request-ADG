<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Candidate>
 */
class CandidateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory()->create(['role' => \App\Enums\UserRole::CANDIDATE]),
            'headline' => $this->faker->jobTitle,
            'expected_salary_min' => $this->faker->numberBetween(30000, 50000),
            'expected_salary_max' => $this->faker->numberBetween(50000, 100000),
            'preferred_job_type' => $this->faker->randomElement(['full-time', 'part-time', 'contract', 'remote']),
            'preferred_location' => $this->faker->city,
            'total_experience_years' => $this->faker->numberBetween(0, 20),
            'availability' => 'Immediately',
            'availability_weeks' => $this->faker->numberBetween(0, 4),
            'about_me' => $this->faker->paragraph,
            'cover_letter' => $this->faker->paragraph,
            'has_consented' => true,
        ];
    }
}
