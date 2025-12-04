<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientDoctor extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
