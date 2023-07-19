<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('employees', function (Blueprint $table) {
            $table->renameColumn('object_id', 'serviced_object_id');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->renameColumn('object_id', 'serviced_object_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->renameColumn('serviced_object_id', 'object_id');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->renameColumn('serviced_object_id', 'object_id');
        });
    }
};
