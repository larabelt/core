<?php

use Illuminate\Database\Migrations\Migration;

class CreateConversionsMapTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversions_map', function ($table) {
            $table->increments('id');
            $table->morphs('old');
            $table->morphs('new');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conversions_map');
    }

}