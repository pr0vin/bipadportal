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
        Schema::create('sifarish', function (Blueprint $table) {
            $table->id();
            $table->foreignId('decision_id')->nullable()->constrained()->OnDelete('cascade');
            $table->foreignId('patient_id')->nullable()->constrained()->OnDelete('cascade');
            $table->string('paying_amount')->nullable();
            $table->date('sifarish_date')->nullable();
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
        Schema::dropIfExists('sifarish');
    }
};
