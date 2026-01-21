<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\DistributionDetail;

class Distribution extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'patient_id',
        'organization_name',
        'distributed_date',
        'type',
        'remark',
        'fiscal_year_date',
    ];

    protected $casts = [
        'distributed_date' => 'date',
    ];
    public function details()
    {
        return $this->hasMany(DistributionDetail::class);
    }

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
