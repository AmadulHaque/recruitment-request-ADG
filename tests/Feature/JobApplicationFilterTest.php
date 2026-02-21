<?php

namespace Tests\Feature;

use App\Enums\ApplicationStatus;
use App\Enums\UserRole;
use App\Models\Candidate;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobApplicationFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_filter_applications_by_status()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create(['role' => UserRole::CANDIDATE]);
        $candidate = Candidate::factory()->create(['user_id' => $user->id]);
        
        $job1 = Job::factory()->create();
        $job2 = Job::factory()->create();
        
        $app1 = JobApplication::factory()->create([
            'candidate_id' => $candidate->id,
            'job_id' => $job1->id,
            'application_status' => ApplicationStatus::APPLIED,
        ]);
        
        $app2 = JobApplication::factory()->create([
            'candidate_id' => $candidate->id,
            'job_id' => $job2->id,
            'application_status' => ApplicationStatus::INTERVIEW_INVITED,
        ]);

        $response = $this->actingAs($user)
            ->getJson('/api/candidate/applications?status=' . ApplicationStatus::APPLIED->value);

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment(['id' => $app1->id])
            ->assertJsonMissing(['id' => $app2->id]);
    }

    public function test_can_sort_applications()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create(['role' => UserRole::CANDIDATE]);
        $candidate = Candidate::factory()->create(['user_id' => $user->id]);
        
        $job = Job::factory()->create();
        
        $app1 = JobApplication::factory()->create([
            'candidate_id' => $candidate->id,
            'created_at' => now()->subDays(2),
        ]);
        
        $app2 = JobApplication::factory()->create([
            'candidate_id' => $candidate->id,
            'created_at' => now(),
        ]);

        // Sort asc
        $response = $this->actingAs($user)
            ->getJson('/api/candidate/applications?sort_by=created_at&sort_direction=asc');

        $response->assertStatus(200);
        $data = $response->json('data');
        $this->assertEquals($app1->id, $data[0]['id']);
        $this->assertEquals($app2->id, $data[1]['id']);

        // Sort desc
        $response = $this->actingAs($user)
            ->getJson('/api/candidate/applications?sort_by=created_at&sort_direction=desc');

        $data = $response->json('data');
        $this->assertEquals($app2->id, $data[0]['id']);
        $this->assertEquals($app1->id, $data[1]['id']);
    }
}
