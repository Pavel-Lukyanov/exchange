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
        Schema::create('serviced_objects', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('name');
            $table->string('country');
            $table->string('city');
            $table->string('street');
            $table->string('house_number');
            $table->string('number_contract');
            $table->string('date_start_contract');
            $table->string('date_end_contract');
            $table->string('type_installation');
            $table->string('name_organization_do_project');
            $table->string('project_release_date');
            $table->string('name_organization_performed_installation_commissioning')->nullable();
            $table->date('date_delivery_object')->nullable();
            $table->string('services_shedule');
            $table->longText('description_object');
            $table->string('installation_composition');
            $table->string('scheme')->nullable();
            $table->string('loop_lists')->nullable();
            $table->string('photos')->nullable();
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
        Schema::dropIfExists('serviced_objects');
    }
};
