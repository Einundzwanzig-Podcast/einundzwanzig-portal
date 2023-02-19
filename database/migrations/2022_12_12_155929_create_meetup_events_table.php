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

        Schema::create('meetup_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meetup_id')
                  ->constrained()
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
            $table->dateTime('start');
            $table->string('location')
                  ->nullable();
            $table->text('description')
                  ->nullable();
            $table->string('link')
                  ->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetup_events');
    }
};
