<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\CommonMark\Reference\Reference;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_doctors', function (Blueprint $table) {
            $table->id();
            // $table->unsignedInteger('patient_id');
            $table->foreignId('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->string('name');
            $table->string('post');
            $table->string('nmc_no');
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
        Schema::dropIfExists('patient_doctors');
    }
};
