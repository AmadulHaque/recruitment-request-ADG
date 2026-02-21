<?php

namespace Database\Factories;

use App\Enums\JobStatus;
use App\Enums\JobType;
use App\Enums\JobUrgency;
use App\Enums\SalaryType;
use App\Models\Company;
use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    protected $model = Job::class;

    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'job_title' => $this->faker->jobTitle,
            'job_category' => $this->faker->word,
            'job_type' => $this->faker->randomElement(JobType::cases()),
            'vacancy_count' => $this->faker->numberBetween(1, 10),
            'salary_min' => $this->faker->numberBetween(30000, 50000),
            'salary_max' => $this->faker->numberBetween(60000, 100000),
            'salary_type' => $this->faker->randomElement(SalaryType::cases()),
            'experience_min_year' => 0,
            'experience_max_year' => 5,
            'job_location' => $this->faker->city,
            'application_deadline' => $this->faker->dateTimeBetween('now', '+1 year'),
            'description' => $this->faker->paragraph,
            'urgency' => $this->faker->randomElement(JobUrgency::cases()),
            'status' => JobStatus::ACTIVE,
        ];
    }
}
