<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientApplication extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function application_type()
    {
        return $this->belongsTo(ApplicationType::class);
    }

    public function patientApplicationDisease()
    {
        return $this->hasMany(PatientApplicationDisease::class);
    }


    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
