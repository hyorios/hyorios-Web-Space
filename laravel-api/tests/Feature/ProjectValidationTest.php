<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_project_requires_title_and_slug(): void
    {
        $user = User::factory()->create([
            'is_admin' => true,
        ]);

        $response = $this->actingAs($user, 'backpack')->post('/admin/project', [
            // empty payload
        ]);

        $response->assertSessionHasErrors(['title', 'slug']);
    }

    public function test_project_can_be_created_with_valid_data(): void
    {
        $user = User::factory()->create([
            'is_admin' => true,
        ]);

        $response = $this->actingAs($user, 'backpack')->post('/admin/project', [
            'title' => 'Test Project',
            'slug' => 'test-project',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('projects', ['slug' => 'test-project']);
    }
}
