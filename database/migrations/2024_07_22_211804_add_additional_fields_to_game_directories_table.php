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
            $table->string('rating')->nullable();
            $table->string('released')->nullable();
            $table->string('platforms')->nullable();
            $table->string('genres')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_directories', function (Blueprint $table) {
            $table->dropColumn(['rating', 'released', 'platforms', 'genres']);
        });
    }
};
