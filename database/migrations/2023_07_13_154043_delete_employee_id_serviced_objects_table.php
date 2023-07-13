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
        Schema::table('serviced_objects', function (Blueprint $table) {
            $table->dropConstrainedForeignId('employee_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('serviced_objects', function (Blueprint $table) {
            $table->foreignId('employee_id')->nullable()->constrained('users')->nullOnDelete();
        });
    }
};
