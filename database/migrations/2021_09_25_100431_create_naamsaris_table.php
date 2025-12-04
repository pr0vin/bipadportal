<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNaamsarisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('naamsaris', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id')->nullable();

            $table->string('old_prop_name')->nullable();
            $table->string('old_prop_phone', 15)->nullable();
            $table->unsignedBigInteger('old_prop_province_id')->nullable();
            $table->unsignedBigInteger('old_prop_district_id')->nullable();
            $table->unsignedBigInteger('old_prop_municipality_id')->nullable();
            $table->unsignedBigInteger('old_prop_ward_id')->nullable();
            $table->string('old_prop_citizenship_no')->nullable();
            $table->string('old_prop_citizenship_district')->nullable();
            $table->string('old_prop_citizenship_issued_date', 20)->nullable();
            $table->string('old_prop_road_name')->nullable();
            $table->string('old_prop_house_no', 10)->nullable();

            $table->string('new_prop_name')->nullable();
            $table->string('new_prop_phone', 15)->nullable();
            $table->unsignedBigInteger('new_prop_province_id')->nullable();
            $table->unsignedBigInteger('new_prop_district_id')->nullable();
            $table->unsignedBigInteger('new_prop_municipality_id')->nullable();
            $table->unsignedBigInteger('new_prop_ward_id')->nullable();
            $table->string('new_prop_citizenship_no')->nullable();
            $table->string('new_prop_citizenship_district')->nullable();
            $table->string('new_prop_citizenship_issued_date', 20)->nullable();
            $table->string('new_prop_road_name')->nullable();
            $table->string('new_prop_house_no', 10)->nullable();

            $table->date('date_en')->nullable();
            $table->string('date_np')->nullable();
            $table->string('processing_officer')->nullable();

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
        Schema::dropIfExists('naamsaris');
    }
}
