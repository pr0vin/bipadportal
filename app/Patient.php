<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = ['current_quarter', 'current_renew_quarter', 'latest_renewal'];

    public function onlineApplication()
    {
        return $this->hasOne('App\OnlineApplication', 'patient_id', 'id')->withDefault([
            'token_number' => null,
            'applicant_ip' => null,
        ]);
    }
    public function isVerified(): bool
    {
        return isset($this->verified_date);
    }

    public function doctor()
    {
        return $this->hasOne(PatientDoctor::class);
    }


    public function disease()
    {
        return $this->belongsTo(Disease::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id', 'id');
    }
    public function district()
    {
        return $this->belongsTo(District::class);
    }
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function patientApplication()
    {
        return $this->hasMany(PatientApplication::class);
    }

    public function isRegistered(): bool
    {
        return isset($this->registered_date);
    }

    public function renews()
    {
        return $this->hasMany(Renew::class);
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function getCurrentQuarterAttribute()
    {
        // Convert the current date from AD to BS format

        $regDate = $this->registered_date;

        if (!$regDate) {
            return 0;
        }
        // Split the date to get the month
        $dateParts = explode('-', $regDate);
        $month = (int)$dateParts[1];


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

    public function getCurrentRenewQuarterAttribute()
    {
        // Convert the current date from AD to BS format

        $renewDate = $this->renewed_date;

        if (!$renewDate) {
            return 0;
        }
        // Split the date to get the month
        $dateParts = explode('-', $renewDate);
        $month = (int)$dateParts[1];


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


    public function getLatestRenewalAttribute()
    {
        $renews = $this->renews();
        $date = $renews->max('next_renew_date');


        return $date;
    }

    // public function isRecommanded($query)
    // {
    //     return $query->whereNotNull();
    // }
}
