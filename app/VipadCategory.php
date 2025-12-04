<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VipadCategory extends Model
{
    use HasFactory;

    protected $table = 'vipad_categories';

    protected $fillable = [
        'name',
    ];

     public function patients()
    {
        return $this->hasMany(Patient::class);
    }

}
