<?php

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_published_projects_are_listed()
    {
        $published = \App\Models\Project::factory()->published()->create([
            'title' => ['en' => 'Published Project EN']
        ]);
        
        $unpublished = \App\Models\Project::factory()->create([
            'title' => ['en' => 'Unpublished Project EN']
        ]);

        $response = $this->get('/api/v1/projects');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonPath('data.0.id', $published->id);
    }

    public function test_can_filter_projects_by_tech_stack()
    {
        \App\Models\Project::factory()->published()->create([
            'tech_stack' => ['Laravel', 'Vue'],
            'title' => ['en' => 'Project 1']
        ]);

        \App\Models\Project::factory()->published()->create([
            'tech_stack' => ['Nuxt', 'Vue'],
            'title' => ['en' => 'Project 2']
        ]);

        $response = $this->get('/api/v1/projects?tech_stack=Nuxt');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonPath('data.0.title.en', 'Project 2');
    }

    public function test_can_show_published_project()
    {
        $project = \App\Models\Project::factory()->published()->create([
            'slug' => 'my-published-project',
        ]);

        $response = $this->get('/api/v1/projects/my-published-project');

        $response->assertStatus(200);
        $response->assertJsonPath('data.id', $project->id);
    }

    public function test_cannot_show_unpublished_project()
    {
        $project = \App\Models\Project::factory()->create([
            'slug' => 'my-unpublished-project',
        ]);

        $response = $this->get('/api/v1/projects/my-unpublished-project');

        $response->assertStatus(404);
    }
}
