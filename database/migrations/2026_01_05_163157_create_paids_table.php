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
        Schema::create('paids', function (Blueprint $table) {
            $table->id();
            $table->string('topic')->nullable();
             $table->foreignId('patient_id')->nullable()->constrained('patients')->OnDelete('cascade');
            $table->string('paid_amount')->nullable();
            $table->date('paid_date')->nullable();
            $table->text('remark')->nullable();
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
        Schema::dropIfExists('paids');
    }
};
