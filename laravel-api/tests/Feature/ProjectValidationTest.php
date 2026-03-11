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
    public function test_project_can_be_updated_without_changing_slug(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        
        $project = \App\Models\Project::factory()->create([
            'title' => 'Initial Title',
            'slug' => 'test-project',
        ]);

        $response = $this->actingAs($user, 'backpack')->put('/admin/project/' . $project->id, [
            'id' => $project->id,
            'title' => 'Updated Title',
            'slug' => 'test-project', // Still same
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('projects', ['id' => $project->id, 'slug' => 'test-project']);
    }

    public function test_project_cannot_be_updated_with_existing_foreign_slug(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        
        \App\Models\Project::factory()->create([
            'title' => 'Existing',
            'slug' => 'existing-slug',
        ]);

        $project = \App\Models\Project::factory()->create([
            'title' => 'Another Project',
            'slug' => 'another-slug',
        ]);

        $response = $this->actingAs($user, 'backpack')->put('/admin/project/' . $project->id, [
            'id' => $project->id,
            'title' => 'Attempt Steal',
            'slug' => 'existing-slug',
        ]);

        $response->assertSessionHasErrors(['slug']);
    }
}
