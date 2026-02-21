<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\Companies\CompanyResource;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_render_company_resource_page()
    {
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $this->actingAs($admin)
            ->get(CompanyResource::getUrl('index'))
            ->assertSuccessful();
    }
}
