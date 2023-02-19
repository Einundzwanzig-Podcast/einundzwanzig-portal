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
        Schema::create('twitter_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('twitter_id');
            $table->string('nickname');
            $table->string('token');
            $table->unsignedInteger('expires_in');
            $table->json('data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('twitter_accounts');
    }
};
