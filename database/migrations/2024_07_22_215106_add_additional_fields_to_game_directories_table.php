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
        Schema::table('game_directories', function (Blueprint $table) {
            $table->string('updated')->nullable();
            $table->string('developers')->nullable();
            $table->text('trailers')->nullable(); // Store JSON or comma-separated URLs
            $table->integer('achievements')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_directories', function (Blueprint $table) {
            $table->dropColumn(['updated', 'developers', 'trailers', 'achievements']);
        });
    }
};
