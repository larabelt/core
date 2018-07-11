<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BeltCreateIndexTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('index', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('indexable');
            $table->integer('team_id')->nullable()->index();
            $table->boolean('is_active')->nullable()->index();
            $table->string('name')->nullable()->index();
            $table->string('slug')->nullable();
            $table->text('body')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
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
        Schema::dropIfExists('index');
    }
}
