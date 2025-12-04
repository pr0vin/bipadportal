<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();
            $table->string('form_province_id')->nullable();
            $table->string('form_district_id')->nullable();
            $table->string('form_municipality_id')->nullable();
            $table->string('form_ward_id')->nullable();
            $table->string('letter_municipality_name')->nullable();
            $table->string('letter_address_line_one')->nullable();
            $table->string('letter_address_line_two')->nullable();
            $table->string('letter_phone')->nullable();
            $table->string('letter_email')->nullable();
            $table->string('letter_website')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
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
        Schema::dropIfExists('user_settings');
    }
}
