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
        Schema::table('translations', function (Blueprint $table) {
            $table->index([
                'value',
            ]);
        });
        Schema::table('languages', function (Blueprint $table) {
            $table->index([
                'name',
                'language',
            ]);
        });
        Schema::table('countries', function (Blueprint $table) {
            $table->index([
                'name',
                'code',
                'longitude',
                'latitude',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
