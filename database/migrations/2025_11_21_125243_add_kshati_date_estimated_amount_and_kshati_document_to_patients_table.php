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
        Schema::table('patients', function (Blueprint $table) {
            $table->string('estimated_amount')->nullable()->after('email');
            $table->text('kshati_document')->nullable()->after('description');
            $table->string('kshati_date')->nullable()->after('registered_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patients', function (Blueprint $table) {
             $table->dropColumn(['estimated_amount', 'kshati_document','kshati_date']);
        });
    }
};
