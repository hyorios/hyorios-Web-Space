<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_cannot_access_admin_panel(): void
    {
        $user = User::factory()->create([
            'is_admin' => false,
        ]);

        $response = $this->actingAs($user, 'backpack')->get('/admin/project');

        $response->assertRedirect(backpack_url('login'));
    }

    public function test_admin_can_access_admin_panel(): void
    {
        $user = User::factory()->create([
            'is_admin' => true,
        ]);

        $response = $this->actingAs($user, 'backpack')->get('/admin/project');

        $response->assertStatus(200);
    }
}
