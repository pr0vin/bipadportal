<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Renew extends Model
{
    use HasFactory;

    protected $guarded=['id'];
    protected $appends = ['current_renew_quarter'];
    public function patient(){
        return $this->belongsTo(Patient::class);
    }

    public function getCurrentRenewQuarterAttribute()
    {
        // Convert the current date from AD to BS format

        $renewDate = $this->next_renew_date;

        $date = new DateTime($renewDate);

        // Subtract one month
        $regDate=$date->modify('-1 month');
        if (!$regDate) {
            return 0;
        }
        // Split the date to get the month
        $month = $regDate->format('m');
        // $month = (int)$dateParts[1];


        // Determine the quarter based on the month
        if ($month >= 4 && $month <= 6) {
            return 1;
        } elseif ($month >= 7 && $month <= 9) {
            return 2;
        } elseif ($month >= 10 && $month <= 12) {
            return 3;
        } else {
            return 4;
        }
    }
}
