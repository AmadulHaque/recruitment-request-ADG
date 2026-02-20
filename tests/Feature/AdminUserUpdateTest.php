<?php

namespace Tests\Feature;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminUserUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_update_user_profile()
    {
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $targetUser = User::factory()->create([
            'role' => UserRole::CANDIDATE,
            'email' => 'old@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->actingAs($admin)
            ->putJson("/api/admin/users/{$targetUser->id}", [
                'name' => 'New Name',
                'email' => 'new@example.com',
                'password' => 'newpassword',
                'password_confirmation' => 'newpassword',
            ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $targetUser->refresh();
        $this->assertEquals('new@example.com', $targetUser->email);
        $this->assertEquals('New Name', $targetUser->name);
        $this->assertTrue(Hash::check('newpassword', $targetUser->password));
    }

    public function test_non_admin_cannot_update_user_profile()
    {
        $company = User::factory()->create([
            'role' => UserRole::COMPANY,
        ]);

        $targetUser = User::factory()->create(['role' => UserRole::CANDIDATE]);

        $response = $this->actingAs($company)
            ->putJson("/api/admin/users/{$targetUser->id}", [
                'name' => 'New Name',
            ]);

        $response->assertStatus(403);
    }

    public function test_email_must_be_unique()
    {
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $existingUser = User::factory()->create(['role' => UserRole::CANDIDATE, 'email' => 'existing@example.com']);
        $targetUser = User::factory()->create(['role' => UserRole::CANDIDATE, 'email' => 'target@example.com']);

        $response = $this->actingAs($admin)
            ->putJson("/api/admin/users/{$targetUser->id}", [
                'email' => 'existing@example.com',
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}
