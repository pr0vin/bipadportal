<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddAdDatesToFiscalYears extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fiscal_years', function (Blueprint $table) {
            $table->date('start_ad')->nullable()->after('start');
            $table->date('end_ad')->nullable()->after('end');
        });

        DB::transaction(function () {
            foreach (\App\FiscalYear::all() as $fiscalYear) {
                $fiscalYear->update([
                    'start_ad' => bs_to_ad($fiscalYear->start),
                    'end_ad' => bs_to_ad($fiscalYear->end),
                ]);
            }
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
            $table->dropColumn('start_ad');
            $table->dropColumn('end_ad');
        });
    }
}
