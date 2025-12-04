<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDateColumnTypeToStringInFiscalYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fiscal_years', function (Blueprint $table) {
            $table->string('start')->change();
            $table->string('end')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fiscal_years', function (Blueprint $table) {
            $table->date('start')->change();
            $table->date('end')->change();
        });
    }
}
