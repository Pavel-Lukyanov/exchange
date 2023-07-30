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
        Schema::create('to_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('object_user_id');
            $table->unsignedBigInteger('organization_user_id');
            $table->unsignedBigInteger('contract_id');
            $table->longText('list_completed_works');
            $table->string('photos');
            $table->foreign('object_user_id')->references('id')->on('users');
            $table->foreign('organization_user_id')->references('id')->on('users');
            $table->foreign('contract_id')->references('id')->on('contracts');
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
        Schema::dropIfExists('to_histories');
    }
};
