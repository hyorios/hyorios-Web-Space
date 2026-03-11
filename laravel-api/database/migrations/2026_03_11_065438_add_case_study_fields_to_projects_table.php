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
            $table->json('problem')->nullable()->after('description');
            $table->json('solution')->nullable()->after('problem');
            $table->json('implementation')->nullable()->after('solution');
            $table->json('result')->nullable()->after('implementation');
            $table->json('metrics')->nullable()->after('result');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['problem', 'solution', 'implementation', 'result', 'metrics']);
        });
    }
};
