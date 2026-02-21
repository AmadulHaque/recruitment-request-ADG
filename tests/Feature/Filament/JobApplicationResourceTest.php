<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\JobApplications\JobApplicationResource;
use App\Models\JobApplication;
use App\Models\User;
use App\Enums\UserRole;
use App\Models\Job;
use App\Models\Candidate;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobApplicationResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_job_application_resource_page()
    {
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $this->actingAs($admin)
            ->get(JobApplicationResource::getUrl('index'))
            ->assertSuccessful();
    }

    public function test_can_render_create_job_application_page()
    {
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        // Create prerequisites for the form select options
        $company = Company::create([
            'user_id' => $admin->id,
            'company_name' => 'Test Company',
        ]);
        
        // We need a job for the job_id select
        Job::factory()->create([
            'company_id' => $company->id,
        ]);
        
        // We need a candidate for the candidate_id select
        $candidateUser = User::factory()->create(['role' => UserRole::CANDIDATE]);
        Candidate::factory()->create(['user_id' => $candidateUser->id]);

        $this->actingAs($admin)
            ->get(JobApplicationResource::getUrl('create'))
            ->assertSuccessful();
    }

    public function test_can_render_view_job_application_page()
    {
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $company = Company::create([
            'user_id' => $admin->id,
            'company_name' => 'Test Company',
        ]);
        
        $job = Job::factory()->create([
            'company_id' => $company->id,
        ]);
        
        $candidateUser = User::factory()->create(['role' => UserRole::CANDIDATE]);
        $candidate = Candidate::factory()->create(['user_id' => $candidateUser->id]);

        $application = JobApplication::create([
            'job_id' => $job->id,
            'candidate_id' => $candidate->id,
            'meeting_url' => 'https://meet.google.com/test',
        ]);

        $this->actingAs($admin)
            ->get(JobApplicationResource::getUrl('view', ['record' => $application]))
            ->assertSuccessful();
    }
}
