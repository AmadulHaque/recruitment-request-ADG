<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_user_resource_page()
    {
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $this->actingAs($admin)
            ->get(UserResource::getUrl('index'))
            ->assertSuccessful();
    }
}
