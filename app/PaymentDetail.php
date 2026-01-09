<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'patient_id',
        'paid_amount',
        'remark',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
