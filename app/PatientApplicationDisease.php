<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientApplicationDisease extends Model
{
    use HasFactory;
     protected $table = 'patientapplication_disease'; 

    protected $guarded=['id'];

    public function patientApplication()
    {
        return $this->belongsTo(PatientApplication::class);
    }

    public function disease()
    {
        return $this->belongsTo(Disease::class);
    }

}
