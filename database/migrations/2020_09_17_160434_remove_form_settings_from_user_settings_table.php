<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveFormSettingsFromUserSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_settings', function (Blueprint $table) {
            $table->dropColumn('form_province_id');
            $table->dropColumn('form_district_id');
            $table->dropColumn('form_municipality_id');
            $table->dropColumn('form_ward_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_settings', function (Blueprint $table) {
            $table->string('form_province_id')->nullable();
            $table->string('form_district_id')->nullable();
            $table->string('form_municipality_id')->nullable();
            $table->string('form_ward_id')->nullable();
        });
    }
}
