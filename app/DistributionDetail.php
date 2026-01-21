<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributionDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'distribution_id',
        'resource_id',
        'quantity',
        'returnable',
        'is_returned',
        'remark',
    ];

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }


    public function distribution()
    {
        return $this->belongsTo(Distribution::class);
    }
}
