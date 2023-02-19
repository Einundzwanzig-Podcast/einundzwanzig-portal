<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('meetups', function (Blueprint $table) {
            $table->renameColumn('link', 'telegram_link');
            $table->string('webpage')
                  ->nullable();
            $table->string('twitter_username')
                  ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('meetups', function (Blueprint $table) {
            //
        });
    }
};
