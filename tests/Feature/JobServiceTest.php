<?php

namespace Tests\Feature;

use App\DTOs\CreateJobDTO;
use App\DTOs\UpdateJobDTO;
use App\Enums\JobStatus;
use App\Enums\JobType;
use App\Enums\JobUrgency;
use App\Enums\SalaryType;
use App\Models\Company;
use App\Models\Job;
use App\Models\User;
use App\Services\JobService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class JobServiceTest extends TestCase
{
    use RefreshDatabase;

    private JobService $jobService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->jobService = new JobService();
    }

    public function test_can_create_job_with_single_attachment()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->create('document.pdf', 100);

        $user = User::factory()->create();
        $company = Company::factory()->create(['user_id' => $user->id]);

        $dto = new CreateJobDTO(
            company_id: $company->id,
            job_title: 'Software Engineer',
            job_category: 'Engineering',
            job_type: JobType::FULL_TIME->value,
            vacancy_count: 1,
            salary_min: 50000,
            salary_max: 80000,
            salary_type: SalaryType::YEARLY->value,
            experience_min_year: 1,
            experience_max_year: 3,
            education_requirement: 'Bachelor',
            job_location: 'Remote',
            application_deadline: '2025-12-31',
            description: 'Job Description',
            benefits: 'Benefits',
            urgency: JobUrgency::LOW->value,
            status: JobStatus::ACTIVE->value,
            attachments: $file,
            skills: ['PHP', 'Laravel']
        );

        $job = $this->jobService->store($dto);

        $this->assertNotNull($job->attachments);
        $this->assertTrue(Storage::disk('public')->exists($job->attachments));
    }

    public function test_can_update_job_with_single_attachment()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->create('document.pdf', 100);

        $user = User::factory()->create();
        $company = Company::factory()->create(['user_id' => $user->id]);
        $job = Job::factory()->create(['company_id' => $company->id]);

        $dto = new UpdateJobDTO(
            company_id: $company->id,
            job_title: 'Updated Title',
            job_category: 'Engineering',
            job_type: JobType::FULL_TIME->value,
            vacancy_count: 1,
            salary_min: 50000,
            salary_max: 80000,
            salary_type: SalaryType::YEARLY->value,
            experience_min_year: 1,
            experience_max_year: 3,
            education_requirement: 'Bachelor',
            job_location: 'Remote',
            application_deadline: '2025-12-31',
            description: 'Job Description',
            benefits: 'Benefits',
            urgency: JobUrgency::LOW->value,
            status: JobStatus::ACTIVE->value,
            attachments: $file,
            skills: ['PHP', 'Laravel']
        );

        $updatedJob = $this->jobService->update($job, $dto);

        $this->assertNotNull($updatedJob->attachments);
        $this->assertTrue(Storage::disk('public')->exists($updatedJob->attachments));
    }
}
