<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'decision_id',
        'paid_date',
        'title',
        'remark',
        'fiscal_year_date',
        'total',
    ];

    protected $casts = [
        'paid_date' => 'date',
    ];

    public function decision()
    {
        return $this->belongsTo(Decision::class);
    }

    public function paymentDetails()
    {
        return $this->hasMany(PaymentDetail::class);
    }
}
