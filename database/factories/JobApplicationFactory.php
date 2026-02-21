<?php

namespace Database\Factories;

use App\Enums\ApplicationStatus;
use App\Models\Candidate;
use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobApplication>
 */
class JobApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'job_id' => Job::factory(),
            'candidate_id' => Candidate::factory(),
            'application_status' => ApplicationStatus::APPLIED,
            'interview_date' => null,
            'interview_note' => null,
            'final_status' => null,
        ];
    }
}
