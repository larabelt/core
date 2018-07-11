<?php

use Illuminate\Database\Migrations\Migration;

class CreateFormsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function ($table) {
            $table->increments('id');
            $table->string('token', 16);
            $table->string('guid', 100)->nullable();
            $table->string('config_key')->nullable();
            $table->text('data')->nullable();
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
        Schema::dropIfExists('forms');
    }

}