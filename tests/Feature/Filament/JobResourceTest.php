<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\Jobs\JobResource;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_job_resource_page()
    {
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $this->actingAs($admin)
            ->get(JobResource::getUrl('index'))
            ->assertSuccessful();
    }
}
