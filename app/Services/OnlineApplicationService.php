<?php

namespace App\Services;

use App\OnlineApplication;
use App\Organization;
use App\Patient;
use Illuminate\Pipeline\Pipeline;

class OnlineApplicationService
{
    public function all()
    {
        $onlineApplications = $this->onlineApplicationPipeline()
            ->with(['organization', 'organization.province', 'organization.district', 'organization.municipality', 'organization.ward'])
            ->paginate(request('per_page') ?? config('constants.online_application.per_page'));

        return $onlineApplications;
    }

    public function onlineApplicationPipeline()
    {
        return app(Pipeline::class)
            ->send(OnlineApplication::query())
            ->through([
                \App\QueryFilters\TokenNumber::class,
            ])
            ->thenReturn();
    }

    public function create(Patient $patient)
    {
        $onlineApplication = new OnlineApplication();
        $onlineApplication->token_number = $this->generateToken($patient->id);
        $onlineApplication->patient_id = $patient->id;
        $onlineApplication->applicant_ip = request()->ip();
        $patient->onlineApplication()->save($onlineApplication);
        return $onlineApplication->token_number;
    }

    public static function generateToken($org_id)
    {
        return (int)((10 + $org_id) . mt_rand(1000, 9999));
    }
}
