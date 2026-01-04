<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Distribution extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'patient_id',
        'distributed_date',
        'resource_id',
        'quantity',
        'type',
        'remark',
    ];

    protected $casts = [
        'distributed_date' => 'date',
        'type' => 'boolean',
    ];

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
