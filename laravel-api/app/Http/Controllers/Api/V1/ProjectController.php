<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \App\Models\Project::query()
            ->where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc');

        if ($request->has('tech_stack')) {
            $techStack = $request->query('tech_stack');
            $query->whereJsonContains('tech_stack', $techStack);
        }

        $projects = $query->get();

        return \App\Http\Resources\ProjectResource::collection($projects);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $project = \App\Models\Project::query()
            ->where('is_published', true)
            ->where('slug', $slug)
            ->firstOrFail();

        return new \App\Http\Resources\ProjectResource($project);
    }
}
