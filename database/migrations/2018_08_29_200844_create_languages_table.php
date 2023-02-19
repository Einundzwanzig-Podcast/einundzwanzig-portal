<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use JoeDixon\Translation\Language;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('translation.database.connection'))
            ->create(config('translation.database.languages_table'), function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->string('language');
                $table->timestamps();
            });

        $initialLanguages = array_unique([
            config('app.fallback_locale'),
            config('app.locale'),
        ]);

        foreach ($initialLanguages as $language) {
            Language::firstOrCreate([
                'language' => $language,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(config('translation.database.connection'))
            ->dropIfExists(config('translation.database.languages_table'));
    }
};
