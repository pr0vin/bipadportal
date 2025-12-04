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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            
            $table->date('applied_date')->nullable(); // changed to applied_date
            $table->date('verified_date')->nullable()->index(); // change to verified_date
            $table->date('registered_date')->nullable()->index();
            $table->date('closed_date')->nullable()->index();
            $table->date('renewed_date')->nullable()->index();
            $table->string('registration_number')->nullable();
            $table->unsignedBigInteger('hospital_id')->nullable();

            $table->unsignedBigInteger('disease_id');
            $table->string('name');
            $table->string('name_en');
            $table->string('citizenship_number');
            $table->string('gender');
            $table->string('age');
            // $table->unsignedBigInteger('province_id');
            // $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('address_id');
            $table->string('ward_number');
            $table->string('tole');
            $table->string('contact_person');
            $table->string('mobile_number');
            $table->string('email')->nullable();
            $table->string('description')->nullable();
            // $table->json('application_types')->nullable();


            // documents
          
            $table->string('hospital_document')->nullable();
            $table->string('disease_proved_document')->nullable();
            $table->string('citizenship_card')->nullable();
            $table->string('application')->nullable();
            $table->string('doctor_recomandation')->nullable();
            $table->string('renewing_document')->nullable();
            $table->string('closing_document')->nullable();


            // boolen
            $table->boolean('isRecommended')->default(false);
            $table->unsignedBigInteger('fiscal_year_id')->nullable();
            $table->string('yearly_payment')->nullable();

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
        Schema::dropIfExists('patients');
    }
};
