<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use \Spatie\Translatable\HasTranslations;
    
    public $translatable = ['title', 'description', 'excerpt'];

    protected $fillable = [
        'title',
        'description',
        'excerpt',
        'slug',
        'cover_image',
        'tech_stack',
        'repo_url',
        'live_url',
        'is_featured',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'tech_stack' => 'array',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];
}
