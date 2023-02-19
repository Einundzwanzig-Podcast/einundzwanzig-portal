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
        Schema::table('twitter_accounts', function (Blueprint $table) {
            $table->text('token')
                  ->nullable()
                  ->change();
            $table->text('refresh_token')
                  ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('twitter_accounts', function (Blueprint $table) {
            //
        });
    }
};
