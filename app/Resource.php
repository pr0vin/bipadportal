<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;
     protected $fillable = ['name', 'unit_id', 'quantity', 'description'];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function distribution()
    {
        return $this->hasMany(Distribution::class);
    }
}
