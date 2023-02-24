<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('library_items', function (Blueprint $table) {
            $table->renameColumn('nostr', 'nostr_status');
        });
        Schema::table('bitcoin_events', function (Blueprint $table) {
            $table->text('nostr_status')
                  ->nullable();
        });
        Schema::table('course_events', function (Blueprint $table) {
            $table->text('nostr_status')
                  ->nullable();
        });
        Schema::table('courses', function (Blueprint $table) {
            $table->text('nostr_status')
                  ->nullable();
        });
        Schema::table('meetup_events', function (Blueprint $table) {
            $table->text('nostr_status')
                  ->nullable();
        });
        Schema::table('meetups', function (Blueprint $table) {
            $table->text('nostr_status')
                  ->nullable();
        });
        Schema::table('orange_pills', function (Blueprint $table) {
            $table->text('nostr_status')
                  ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            //
        });
    }
};
