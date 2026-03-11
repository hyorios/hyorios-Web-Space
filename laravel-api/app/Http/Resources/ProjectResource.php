<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->getTranslations('title') ?: ['en' => $this->title],
            'description' => $this->getTranslations('description') ?: ['en' => $this->description],
            'excerpt' => $this->getTranslations('excerpt') ?: ['en' => $this->excerpt],
            'slug' => $this->slug,
            'thumbnail' => $this->cover_image ? url($this->cover_image) : null,
            'tech_stack' => is_array($this->tech_stack) ? $this->tech_stack : (json_decode($this->tech_stack, true) ?: []),
            'repo_url' => $this->repo_url,
            'live_url' => $this->live_url,
            'is_featured' => (bool) $this->is_featured,
            'is_published' => (bool) $this->is_published,
            'published_at' => $this->published_at,
        ];
    }
}
