<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKarobarParibartansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karobar_paribartans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organization_id')->nullable();

            $table->string('old_org_type')->nullable();
            $table->string('old_org_product_type')->nullable();

            $table->string('new_org_type')->nullable();
            $table->string('new_org_product_type')->nullable();

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
        Schema::dropIfExists('karobar_paribartans');
    }
}
