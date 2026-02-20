<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\Candidates\CandidateResource;
use App\Models\Candidate;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Filament\Resources\Candidates\Pages\CreateCandidate;
use App\Filament\Resources\Candidates\Pages\EditCandidate;
use Livewire\Livewire;

use App\Models\Skill;

class CandidateResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_candidate_resource_page()
    {
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $this->actingAs($admin)
            ->get(CandidateResource::getUrl('index'))
            ->assertSuccessful();
    }

    public function test_can_create_candidate()
    {
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $user = User::factory()->create([
            'role' => UserRole::CANDIDATE,
        ]);

        $skill = Skill::create(['name' => 'PHP']);

        Livewire::actingAs($admin)
            ->test(CreateCandidate::class)
            ->set('data.user_id', $user->id)
            ->set('data.headline', 'Software Engineer')
            ->set('data.recruiter_id', 'REC123')
            ->set('data.availability_weeks', 2)
            ->set('data.cover_letter', 'Cover letter content')
            ->set('data.has_consented', true)
            ->set('data.skills', [$skill->id])
            ->call('create')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('candidates', [
            'user_id' => $user->id,
            'headline' => 'Software Engineer',
            'recruiter_id' => 'REC123',
            'availability_weeks' => 2,
            'cover_letter' => 'Cover letter content',
            'has_consented' => 1,
        ]);

        $this->assertDatabaseHas('candidate_skill', [
            'skill_id' => $skill->id,
        ]);
    }

    public function test_can_edit_candidate()
    {
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $candidate = Candidate::factory()->create([
            'headline' => 'Old Headline',
        ]);

        Livewire::actingAs($admin)
            ->test(EditCandidate::class, ['record' => $candidate->id])
            ->fillForm([
                'headline' => 'New Headline',
                'recruiter_id' => 'REC999',
                'availability_weeks' => 4,
                'cover_letter' => 'Updated cover letter',
                'has_consented' => true,
            ])
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('candidates', [
            'id' => $candidate->id,
            'headline' => 'New Headline',
            'recruiter_id' => 'REC999',
            'availability_weeks' => 4,
            'cover_letter' => 'Updated cover letter',
            'has_consented' => 1,
        ]);
    }
}
