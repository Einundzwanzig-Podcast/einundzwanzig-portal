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
        Schema::connection(config('translation.database.connection'))
            ->create(config('translation.database.translations_table'), function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('language_id');
                $table->foreign('language_id')->references('id')
                    ->on(config('translation.database.languages_table'));
                $table->string('group')->nullable();
                $table->text('key');
                $table->text('value')->nullable();
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection(config('translation.database.connection'))
            ->dropIfExists(config('translation.database.translations_table'));
    }
};
