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
            $table->string('name');
            $table->string('country');
            $table->string('city');
            $table->string('street');
            $table->string('house');
            $table->string('contract_number');
            $table->date('contract_date_start');
            $table->date('contract_date_end');
            $table->string('type_installation');
            $table->string('name_organization_do_project')->nullable();
            $table->date('project_release_date')->nullable();
            $table->string('organization_name_mounting')->nullable();
            $table->date('date_delivery_object')->nullable();
            $table->json('services_schedule');
            $table->longText('description_object');
            $table->string('installation_composition');
            $table->json('scheme')->nullable();
            $table->json('loop_lists')->nullable();
            $table->json('photos')->nullable();
            $table->boolean('is_archived')->default(false);
            $table->boolean('is_completed')->default(false);
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
