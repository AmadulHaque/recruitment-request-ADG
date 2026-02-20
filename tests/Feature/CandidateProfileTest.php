<?php

namespace Tests\Feature;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CandidateProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_candidate_can_update_profile_with_new_fields()
    {
        $user = User::factory()->create([
            'role' => UserRole::CANDIDATE,
            'phone' => '1234567890',
        ]);

        $response = $this->actingAs($user)
            ->postJson('/api/candidate/profile', [
                'headline' => 'Software Engineer',
                'recruiter_id' => 'REC123',
                'availability_weeks' => 2,
                'cover_letter' => 'This is my cover letter.',
                'has_consented' => true,
                'skills' => ['PHP', 'Laravel'],
            ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('candidates', [
            'user_id' => $user->id,
            'headline' => 'Software Engineer',
            'recruiter_id' => 'REC123',
            'availability_weeks' => 2,
            'cover_letter' => 'This is my cover letter.',
            'has_consented' => 1,
        ]);

        $this->assertDatabaseHas('skills', ['name' => 'PHP']);
        $this->assertDatabaseHas('skills', ['name' => 'Laravel']);

        $response->assertJson([
            'data' => [
                'headline' => 'Software Engineer',
                'recruiter_id' => 'REC123',
                'availability_weeks' => 2,
                'cover_letter' => 'This is my cover letter.',
                'has_consented' => true,
            ]
        ]);
    }

    public function test_has_consented_is_required()
    {
        $user = User::factory()->create([
            'role' => UserRole::CANDIDATE,
        ]);

        $response = $this->actingAs($user)
            ->postJson('/api/candidate/profile', [
                'headline' => 'Software Engineer',
                // has_consented missing
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['has_consented']);
    }
}
