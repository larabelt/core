<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BeltCreateTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('translatable');
            $table->string('translatable_column');
            $table->string('locale', 5)->default('en_US');
            $table->text('value')->nullable();
            $table->index(['translatable_type', 'translatable_id', 'translatable_column', 'locale'], 'main');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('translations');
    }
}
