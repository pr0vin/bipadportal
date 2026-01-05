<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sifarish extends Model
{
    use HasFactory;
    protected $table = 'sifarish';

    protected $fillable = [
        'patient_id',
        'paid_amount',
        'sifarish_date',
    ];

    protected $casts = [
        'sifarish_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
