<?php

use Illuminate\Database\Migrations\Migration;

class BeltRemoveOldTables1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('user_roles');
        Schema::dropIfExists('roles_archived');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
