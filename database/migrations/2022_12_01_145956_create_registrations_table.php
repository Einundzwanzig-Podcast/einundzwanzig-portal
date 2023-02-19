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
        Schema::disableForeignKeyConstraints();

        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_event_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate()->primary();
            $table->foreignId('participant_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate()->primary();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
