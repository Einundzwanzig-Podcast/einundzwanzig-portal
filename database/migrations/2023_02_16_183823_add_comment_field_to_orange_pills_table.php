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
        Schema::table('orange_pills', function (Blueprint $table) {
            $table->text('comment')
                  ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::table('orange_pills', function (Blueprint $table) {
            //
        });
    }
};
