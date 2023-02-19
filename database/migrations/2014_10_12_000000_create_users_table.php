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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('public_key')
                  ->unique()
                  ->nullable();
            $table->string('email')
                  ->unique()
                  ->nullable();
            $table->timestamp('email_verified_at')
                  ->nullable();
            $table->string('password')
                  ->nullable();
            $table->rememberToken();
            $table->foreignId('current_team_id')
                  ->nullable();
            $table->string('profile_photo_path', 2048)
                  ->nullable();
            $table->boolean('is_lecturer')
                  ->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
