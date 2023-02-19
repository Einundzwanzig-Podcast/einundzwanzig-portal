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
        Schema::table('library_items', function (Blueprint $table) {
            DB::statement('ALTER TABLE library_items
              ALTER COLUMN tweet DROP DEFAULT,
              ALTER COLUMN tweet TYPE BOOLEAN USING tweet::BOOLEAN,
              ALTER COLUMN tweet SET DEFAULT FALSE;'
            );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('library_items', function (Blueprint $table) {
            //
        });
    }
};
