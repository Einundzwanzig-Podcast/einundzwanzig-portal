<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookCasesTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up(): void
    {
        Schema::create('book_cases', function (Blueprint $table) {
            $table->id();
            $table->boolean('orange_pilled')
                  ->default(false);
            $table->unsignedInteger('orange_pilled_amount')
                  ->default(0);
            $table->string('title');
            $table->double('lat');
            $table->double('lon');
            $table->text('address')
                  ->nullable();
            $table->string('type');
            $table->string('open')
                  ->nullable();
            $table->text('comment')
                  ->nullable();
            $table->text('contact')
                  ->nullable();
            $table->text('bcz')
                  ->nullable();
            $table->boolean('digital');
            $table->string('icontype');
            $table->boolean('deactivated');
            $table->string('deactreason');
            $table->string('entrytype');
            $table->text('homepage')
                  ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('book_cases');
    }
}
