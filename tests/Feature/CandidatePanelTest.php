<?php

namespace Tests\Feature;

use App\Enums\ApplicationStatus;
use App\Enums\UserRole;
use App\Filament\Candidate\Resources\JobApplications\JobApplicationResource;
use App\Filament\Candidate\Resources\JobApplications\Pages\ListJobApplications;
use App\Filament\Candidate\Resources\Jobs\JobResource;
use App\Filament\Candidate\Resources\JobApplications\Pages\ViewJobApplication;
use App\Filament\Candidate\Resources\Jobs\Pages\ListJobs;
use App\Models\Candidate;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests\TestCase;

class CandidatePanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_candidate_can_access_panel()
    {
        $user = User::factory()->create(['role' => UserRole::CANDIDATE]);
        $candidate = Candidate::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $response = $this->get('/candidate');

        $response->assertStatus(200);
    }

    public function test_candidate_can_list_jobs()
    {
        $user = User::factory()->create(['role' => UserRole::CANDIDATE]);
        $candidate = Candidate::factory()->create(['user_id' => $user->id]);
        $job = Job::factory()->create();

        $this->actingAs($user);

        Livewire::test(ListJobs::class)
            ->assertCanSeeTableRecords([$job]);
    }

    public function test_candidate_can_apply_for_job()
    {
        $user = User::factory()->create(['role' => UserRole::CANDIDATE]);
        $candidate = Candidate::factory()->create(['user_id' => $user->id]);
        $job = Job::factory()->create();

        $this->actingAs($user);

        Livewire::test(ListJobs::class)
            ->callTableAction('apply', $job)
            ->assertNotified('Application Submitted');

        $this->assertDatabaseHas('job_applications', [
            'job_id' => $job->id,
            'candidate_id' => $candidate->id,
            'application_status' => ApplicationStatus::APPLIED,
        ]);
    }

    public function test_candidate_cannot_apply_twice()
    {
        $user = User::factory()->create(['role' => UserRole::CANDIDATE]);
        $candidate = Candidate::factory()->create(['user_id' => $user->id]);
        $job = Job::factory()->create();

        JobApplication::create([
            'job_id' => $job->id,
            'candidate_id' => $candidate->id,
            'application_status' => ApplicationStatus::APPLIED,
        ]);

        $this->actingAs($user);

        Livewire::test(ListJobs::class)
            ->assertTableActionHidden('apply', $job);
    }

    public function test_candidate_can_list_applications()
    {
        $user = User::factory()->create(['role' => UserRole::CANDIDATE]);
        $candidate = Candidate::factory()->create(['user_id' => $user->id]);
        $job = Job::factory()->create();
        $application = JobApplication::create([
            'job_id' => $job->id,
            'candidate_id' => $candidate->id,
            'application_status' => ApplicationStatus::APPLIED,
        ]);

        $this->actingAs($user);

        Livewire::test(ListJobApplications::class)
            ->assertCanSeeTableRecords([$application]);
    }
    
    public function test_candidate_can_view_application_details()
    {
        $user = User::factory()->create(['role' => UserRole::CANDIDATE]);
        $candidate = Candidate::factory()->create(['user_id' => $user->id]);
        $job = Job::factory()->create();
        $application = JobApplication::create([
            'job_id' => $job->id,
            'candidate_id' => $candidate->id,
            'application_status' => ApplicationStatus::APPLIED,
            'meeting_url' => 'https://meet.google.com/abc-defg-hij',
        ]);

        $user->refresh(); // Ensure relationships are reloadable
        $this->actingAs($user);
        
        $url = JobApplicationResource::getUrl('view', ['record' => $application], panel: 'candidate');
        $this->get($url)
            ->assertStatus(200);
    }

    public function test_candidate_can_upload_document_via_action()
    {
        $user = User::factory()->create(['role' => UserRole::CANDIDATE]);
        $candidate = Candidate::factory()->create(['user_id' => $user->id]);
        $job = Job::factory()->create();
        $application = JobApplication::create([
            'job_id' => $job->id,
            'candidate_id' => $candidate->id,
            'application_status' => ApplicationStatus::APPLIED,
        ]);

        $this->actingAs($user);
        
        $file = UploadedFile::fake()->create('resume.pdf', 100);

        Livewire::test(ViewJobApplication::class, ['record' => $application->id])
            ->callAction('upload_document', [
                'name' => 'Resume',
                'file' => $file,
            ])
            ->assertNotified('Document Uploaded');

        $this->assertDatabaseHas('job_applications', [
            'id' => $application->id,
        ]);
        
        $application->refresh();
        $this->assertCount(1, $application->documents);
        $this->assertEquals('Resume', $application->documents[0]['name']);
    }
}
