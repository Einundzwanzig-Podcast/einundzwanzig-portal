<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')
                  ->constrained()
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
            $table->string('name')
                  ->unique();
            $table->string('slug')
                  ->unique();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
}
