<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiseaseApplication extends Model
{
    use HasFactory;

    protected $guarded=["id"];

    public function application_type(){
        return $this->belongsTo(ApplicationType::class);
    }

    public function disease(){
        return $this->belongsTo(';'::class);
    }

    
}
