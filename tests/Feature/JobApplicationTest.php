<?php

namespace Tests\Feature;

use App\Models\Candidate;
use App\Models\Company;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_candidate_can_view_own_application_details()
    {
        $user = User::factory()->create(['role' => UserRole::CANDIDATE]);
        $candidate = Candidate::factory()->create(['user_id' => $user->id]);
        
        $companyUser = User::factory()->create(['role' => UserRole::COMPANY]);
        $company = Company::factory()->create(['user_id' => $companyUser->id]);
        
        $job = Job::factory()->create(['company_id' => $company->id]);
        
        $application = JobApplication::factory()->create([
            'job_id' => $job->id,
            'candidate_id' => $candidate->id,
        ]);

        $response = $this->actingAs($user)
            ->getJson("/api/candidate/applications/{$application->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $application->id,
                    'job_id' => $job->id,
                    'candidate_id' => $candidate->id,
                    'job' => [
                        'id' => $job->id,
                        'job_title' => $job->job_title,
                    ],
                    'candidate' => [
                        'id' => $candidate->id,
                        'headline' => $candidate->headline,
                    ],
                ]
            ]);
    }

    public function test_candidate_cannot_view_other_candidate_application()
    {
        $user = User::factory()->create(['role' => UserRole::CANDIDATE]);
        $candidate = Candidate::factory()->create(['user_id' => $user->id]);

        $otherUser = User::factory()->create(['role' => UserRole::CANDIDATE]);
        $otherCandidate = Candidate::factory()->create(['user_id' => $otherUser->id]);
        
        $companyUser = User::factory()->create(['role' => UserRole::COMPANY]);
        $company = Company::factory()->create(['user_id' => $companyUser->id]);
        
        $job = Job::factory()->create(['company_id' => $company->id]);
        
        $otherApplication = JobApplication::factory()->create([
            'job_id' => $job->id,
            'candidate_id' => $otherCandidate->id,
        ]);

        $response = $this->actingAs($user)
            ->getJson("/api/candidate/applications/{$otherApplication->id}");

        $response->assertStatus(403);
    }
}
