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
        Schema::table('cities', function (Blueprint $table) {
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
        });
        Schema::table('venues', function (Blueprint $table) {
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
        });
        Schema::table('lecturers', function (Blueprint $table) {
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
        });
        Schema::table('meetups', function (Blueprint $table) {
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
        });
        Schema::table('meetup_events', function (Blueprint $table) {
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
        });
        Schema::table('bitcoin_events', function (Blueprint $table) {
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
        });
        Schema::table('courses', function (Blueprint $table) {
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
        });
        Schema::table('course_events', function (Blueprint $table) {
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
        });
        Schema::table('libraries', function (Blueprint $table) {
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
        });
        Schema::table('library_items', function (Blueprint $table) {
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
        });
        Schema::table('podcasts', function (Blueprint $table) {
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
        });
        Schema::table('episodes', function (Blueprint $table) {
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
        });
        Schema::table('book_cases', function (Blueprint $table) {
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
