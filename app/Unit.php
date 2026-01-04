<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
     protected $guarded = ['id'];

    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

     
}
