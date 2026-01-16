<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Decision extends Model
{
    use HasFactory;
    protected $table = 'decisions';

    protected $fillable = [
        'title',
        'decision_date',
        'decision_file',
        'fiscal_year_date',
        'total'
    ];

    protected $casts = [
        'decision_date' => 'date',
    ];

    public function sifarish()
    {
        return $this->hasMany(Sifarish::class);
    }
}
