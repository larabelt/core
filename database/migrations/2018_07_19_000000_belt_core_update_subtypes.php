<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BeltCoreUpdateSubtypes extends Migration
{
    protected $tables = [
        'forms' => 'config_key',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tables as $table => $column) {
            Schema::table($table, function (Blueprint $table) use ($column) {
                $table->renameColumn($column, 'subtype');
            });
            if (array_get(DB::getConfig(), 'driver') == 'mysql') {
                DB::statement("ALTER TABLE $table MODIFY COLUMN `subtype` VARCHAR(255) AFTER `id`");
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->tables as $table => $column) {
            Schema::table($table, function (Blueprint $table) use ($column) {
                $table->renameColumn('subtype', $column);
            });
        }
    }

}
