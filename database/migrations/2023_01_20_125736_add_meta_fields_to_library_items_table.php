<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::table('library_items', function (Blueprint $table) {
            $table->text('subtitle')
                  ->nullable();
            $table->text('excerpt')
                  ->nullable();
            $table->string('main_image_caption')
                  ->nullable();
            $table->string('read_time')
                  ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('library_items', function (Blueprint $table) {
            //
        });
    }
};
