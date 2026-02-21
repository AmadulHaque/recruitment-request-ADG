<?php

namespace Tests\Feature;

use App\Enums\ApplicationStatus;
use App\Enums\UserRole;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class JobApplicationEnhancementTest extends TestCase
{
    use RefreshDatabase;

    public function test_application_creates_initial_timeline_entry()
    {
        /** @var \App\Models\User $candidateUser */
        $candidateUser = User::factory()->create(['role' => UserRole::CANDIDATE]);
        $candidate = Candidate::factory()->create(['user_id' => $candidateUser->id]);
        
        /** @var \App\Models\User $companyUser */
        $companyUser = User::factory()->create(['role' => UserRole::COMPANY]);
        $company = Company::factory()->create(['user_id' => $companyUser->id]);
        
        $job = Job::factory()->create(['company_id' => $company->id]);

        $response = $this->actingAs($candidateUser)
            ->postJson("/api/candidate/apply/{$job->id}");

        $response->assertStatus(201); // Assuming 201 for created, or 200 depending on implementation

        $application = JobApplication::first();
        $this->assertDatabaseHas('job_application_timelines', [
            'job_application_id' => $application->id,
            'status' => ApplicationStatus::APPLIED->value,
        ]);
    }

    public function test_candidate_can_view_timeline_and_meeting_url()
    {
        /** @var \App\Models\User $candidateUser */
        $candidateUser = User::factory()->create(['role' => UserRole::CANDIDATE]);
        $candidate = Candidate::factory()->create(['user_id' => $candidateUser->id]);
        
        $job = Job::factory()->create();
        
        $application = JobApplication::factory()->create([
            'job_id' => $job->id,
            'candidate_id' => $candidate->id,
            'meeting_url' => 'https://meet.google.com/abc-defg-hij',
        ]);

        // Create timeline entries
        $application->timeline()->create([
            'status' => ApplicationStatus::APPLIED->value,
            'occurred_at' => now()->subDays(2),
        ]);
        $application->timeline()->create([
            'status' => ApplicationStatus::INTERVIEW_INVITED->value,
            'occurred_at' => now(),
        ]);

        $response = $this->actingAs($candidateUser)
            ->getJson("/api/candidate/applications/{$application->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'timeline' => [
                        '*' => ['status', 'notes', 'occurred_at']
                    ],
                    'meeting_url',
                    'documents',
                ]
            ])
            ->assertJsonFragment([
                'meeting_url' => 'https://meet.google.com/abc-defg-hij',
            ]);
    }

    public function test_candidate_can_upload_documents()
    {
        Storage::fake('public');
        
        /** @var \App\Models\User $candidateUser */
        $candidateUser = User::factory()->create(['role' => UserRole::CANDIDATE]);
        $candidate = Candidate::factory()->create(['user_id' => $candidateUser->id]);
        
        $job = Job::factory()->create();
        
        $application = JobApplication::factory()->create([
            'job_id' => $job->id,
            'candidate_id' => $candidate->id,
        ]);

        $file = UploadedFile::fake()->create('passport.pdf', 100);

        $response = $this->actingAs($candidateUser)
            ->postJson("/api/candidate/applications/{$application->id}/documents", [
                'file' => $file,
            ]);

        $response->assertStatus(200);

        $application->refresh();
        $this->assertNotEmpty($application->documents);
        $this->assertEquals('passport.pdf', $application->documents[0]['name']);
        
        // Verify file storage
        $this->assertTrue(Storage::disk('public')->exists($application->documents[0]['path']));
    }
}
