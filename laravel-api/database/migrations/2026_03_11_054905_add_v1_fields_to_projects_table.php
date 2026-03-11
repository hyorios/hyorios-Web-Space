<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->json('title')->change();
            $table->json('description')->nullable()->change();
            $table->json('excerpt')->nullable();
            
            $table->string('slug')->unique()->nullable();
            $table->string('cover_image')->nullable();
            $table->json('tech_stack')->nullable();
            $table->string('repo_url')->nullable();
            $table->string('live_url')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('title')->change();
            $table->text('description')->nullable()->change();
            
            $table->dropColumn([
                'excerpt',
                'slug',
                'cover_image',
                'tech_stack',
                'repo_url',
                'live_url',
                'is_featured',
                'is_published',
                'published_at'
            ]);
        });
    }
};
