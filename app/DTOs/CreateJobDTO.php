<?php

namespace App\DTOs;

class CreateJobDTO
{
    public function __construct(
        public int $company_id,
        public string $job_title,
        public ?string $job_category,
        public string $job_type,
        public int $vacancy_count,
        public ?int $salary_min,
        public ?int $salary_max,
        public ?string $salary_type,
        public ?int $experience_min_year,
        public ?int $experience_max_year,
        public ?string $education_requirement,
        public ?string $job_location,
        public ?string $application_deadline,
        public ?string $description,
        public ?string $benefits,
        public string $urgency,
        public string $status,
        public  $attachments,
        public array $skills
    ) {
    }
}

