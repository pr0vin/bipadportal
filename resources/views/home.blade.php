@extends('layouts.app')

@push('styles')
    <style>
        #dashboard {
            min-height: 100vh;
            padding: 1rem;
        }

        a.bg-white {
            color: #1f2d3d !important;
        }

        .dashboard-main-title {
            font-weight: bold;
            display: flex;
            justify-content: center;
            color: #7d8888;
            font-size: 14px;
        }

        .dashboard-card-title {
            font-weight: bold;

        }
    </style>
@endpush

@section('content')
    @php
        $runningFiscalYear = App\FiscalYear::where('is_running', 1)->first();
        $todayDate = ad_to_bs(now()->format('Y-m-d'));
        $year = $todayDate[0];
        $month = $todayDate[1];
        $today = Carbon\Carbon::parse($year . '-' . $month . '-2');

        $dirghaRegFemale = $dirghaFemale = $dirghaCount->whereNotNull('registered_date')->filter(function ($user) {
            return strtolower($user->gender) === 'female';
        });
    @endphp
    <div id="dashboard" class="m-n3">

        <div class="container-fluid font-noto">
            <h5 class="text-secondary fw-bold">
                Dashboard
            </h5>
            <div class="row mb-4">

                {{-- Alerts --}}
                <div class="col-md-12 mt-2">
                    @include('alerts.all')
                </div>
                {{-- cards --}}


                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 mb-3 ">
                            <div class="card ">

                                <div class=" px-3 my-3">



                                    <a
                                        href="{{ route('regLocation') }}?diseaseType=1&fiscal_year={{ $runningFiscalYear->id }}">
                                        <span class="kalimati-font p-2 "
                                            style="font-size: 32px;color:#808080;  font-weight:bold;">{{ $dirghaCount->whereNotNull('registered_date')->whereNull('closed_date')->count() }}</span>

                                        <h5 class=" text-success   dashboard-card-title mt-3  ">दीर्घरोगी मासिक
                                            उपचार
                                            खर्च</h5>

                                    </a>
                                    <a href="{{ route('newApplication') }}?diseaseType=1&fiscal_year={{ $runningFiscalYear->id }}"
                                        class="d-flex  mt-2 text-secondary">
                                        <span style="font-size: 12px; " class="dashboard-card-title pr-3  ">
                                            नयाँ आवेदनहरू :</span>
                                        <span for="" class="kalimati-font"
                                            style="margin-top: -4px">{{ $dirghaCount->whereNull('registered_date')->count() }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 mb-3 ">
                            <div class="card ">

                                <div class=" px-3 my-3">



                                    <a
                                        href="{{ route('regLocation') }}?diseaseType=2&fiscal_year={{ $runningFiscalYear->id }}">
                                        <span class="kalimati-font p-2 "
                                            style="font-size: 32px;color:#808080;  font-weight:bold;">{{ $bipannaCount->whereNotNull('registered_date')->count() }}</span>

                                        <h5 class=" text-primary   dashboard-card-title mt-3  ">बिपन्न सहयोगको सिफारिस</h5>
                                    </a>

                                    <a href="{{ route('newApplication') }}?diseaseType=2&fiscal_year={{ $runningFiscalYear->id }}"
                                        class="d-flex  mt-2 text-secondary">
                                        <span style="font-size: 12px; " class="dashboard-card-title pr-3  ">
                                            नयाँ आवेदनहरू :</span>
                                        <span for="" class="kalimati-font"
                                            style="margin-top: -4px">{{ $bipannaCount->whereNull('registered_date')->count() }}</span>
                                    </a>


                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 mb-3 ">
                            <div class="card ">

                                <div class=" px-3 my-3">



                                    <a
                                        href="{{ route('regLocation') }}?diseaseType=3&fiscal_year={{ $runningFiscalYear->id }}">
                                        <span class="kalimati-font p-2 "
                                            style="font-size: 32px;color:#808080;  font-weight:bold;">{{ $samajikCount->whereNotNull('registered_date')->count() }}</span>

                                        <h5 class=" text-info   dashboard-card-title mt-3  ">सामाजिक विकास मन्त्रालय</h5>
                                    </a>

                                    <a href="{{ route('newApplication') }}?diseaseType=3&fiscal_year={{ $runningFiscalYear->id }}"
                                        class="d-flex  mt-2 text-secondary">
                                        <span style="font-size: 12px; " class="dashboard-card-title pr-3  ">
                                            नयाँ आवेदनहरू :</span>
                                        <span for="" class="kalimati-font"
                                            style="margin-top: -4px">{{ $samajikCount->whereNull('registered_date')->count() }}</span>
                                    </a>


                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 mb-3 ">
                            <div class="card ">

                                <div class=" px-3 my-3">
                                    <a
                                        href="{{ route('regLocation') }}?diseaseType=4&fiscal_year={{ $runningFiscalYear->id }}">
                                        <span class="kalimati-font p-2 "
                                            style="font-size: 32px;color:#808080;  font-weight:bold;">{{ $nagarpalikaCount->whereNotNull('registered_date')->count() }}</span>

                                        <h5 class=" text-danger   dashboard-card-title mt-3  ">पालिकाको स्वास्थ्य राहत कोष
                                        </h5>
                                    </a>

                                    <a href="{{ route('newApplication') }}?diseaseType=4&fiscal_year={{ $runningFiscalYear->id }}"
                                        class="d-flex  mt-2 text-secondary">
                                        <span style="font-size: 12px; " class="dashboard-card-title pr-3  ">
                                            नयाँ आवेदनहरू :</span>
                                        <span for="" class="kalimati-font"
                                            style="margin-top: -4px">{{ $nagarpalikaCount->whereNull('registered_date')->count() }}</span>
                                    </a>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 ">
                    <div class="card p-3">
                        <div class="d-flex justify-content-between ">
                            <div class=" mb-3">
                                <div class="d-flex items-center justify-content-start">
                                    <span class="dashboard-card-title  font-nep  "
                                        style="font-size: 14px; font-weight:400 ;color:#c7c7c7">जम्मा
                                        आवेदनहरू </span>
                                </div>
                                <h4 class="kalimati-font  py-3 text-danger" style="font-weight:900; font-size:32px;">
                                    {{ $totalApplications }}

                                </h4>
                            </div>
                            <div class=" d-flex  ">
                                <x-fiscal-year-component />
                            </div>
                        </div>

                        <div class="  ">
                            <h4 style="  font-weight:400 ;color:#c7c7c7"
                                class="d-flex justify-content-start  dashboard-card-title font-nep   py-1 rounded-top ">
                                नगरपालिकाबाट मासिक उपचार खर्च पाउन
                                दर्ता भएका
                                दीर्घरोगीहरुको
                                विवरण:</h4>
                            <div class=" px-3 border rounded">

                                <a href="{{ route('regLocation') }}?diseaseType=1&fiscal_year={{ $runningFiscalYear->id }}" class="d-flex justify-content-between mt-2 text-secondary ">
                                    <span class="dashboard-card-title  "><i
                                            class="pr-3 bi bi-journal-check text-primary "></i>
                                        नयाँ
                                        दर्ता
                                        भएका</span>
                                    <span for=""
                                        class="kalimati-font">{{ $dirghaCount->whereNotNull('registered_date')->where('current_quarter', currentquarter())->whereNull('closed_date')->count() }}</span>
                                </a>

                                <a href="{{ route('renewedPatient') }}?fiscal_year={{ $runningFiscalYear->id }}" class="d-flex justify-content-between text-secondary">
                                    <span class="dashboard-card-title"><i class="pr-3 bi bi-recycle text-success"></i>
                                        नवीकरण
                                        भएका</span>
                                    <span for="" class="kalimati-font">{{ $renewedCount }}</span>
                                </a>
                                <a href="{{ route('dateExpiredPatient') }}?fiscal_year={{ $runningFiscalYear->id }}" class="d-flex justify-content-between text-secondary">
                                    <span class="dashboard-card-title"><i
                                            class="pr-3 bi bi-exclamation-triangle text-warning"></i>
                                        नवीकरण
                                        नभएका</span>
                                    <span for="" class="kalimati-font">{{ $expiredCount }}</span>
                                </a>
                                <a href="{{ route('closedPatient') }}?fiscal_year={{ $runningFiscalYear->id }}" class="d-flex justify-content-between text-secondary">
                                    <span class="dashboard-card-title"><i class="pr-3 bi bi-x text-red"
                                            style="font-size: 1rem"></i>
                                        लागतकट्टा भएका</span>
                                    <span for=""
                                        class="kalimati-font">{{ $dirghaCount->whereNotNull('closed_date')->count() }}</span>
                                </a>






                            </div>
                        </div>
                    </div>
                </div>



                {{-- <div class="col-md-3">
                    <div class="card " style="background-color: #17a3b83d">
                        <div class="card-body">
                            <label class="col-12 font-weight-bold text-center dashboard-main-title">दीर्घरोगी मासिक उपचार
                                खर्च</label>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <label class="dashboard-card-title">जम्मा आवेदन</label>
                                <label for="" class="kalimati-font">{{ $dirghaCount->count() }}</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label class="dashboard-card-title">महिला</label>
                                @php
                                    $dirghaFemale = $dirghaCount->filter(function ($user) {
                                        return strtolower($user->gender) === 'female';
                                    });
                                @endphp
                                <label for="" class="kalimati-font">{{ $dirghaFemale->count() }}</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label class="dashboard-card-title">पुरुष</label>
                                @php
                                    $dirghaMale = $dirghaCount->filter(function ($user) {
                                        return strtolower($user->gender) === 'male';
                                    });
                                @endphp
                                <label for="" class="kalimati-font">{{ $dirghaMale->count() }}</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label class="dashboard-card-title">अन्य</label>
                                @php
                                    $dirghaother = $dirghaCount->filter(function ($user) {
                                        return strtolower($user->gender) === 'other';
                                    });
                                @endphp
                                <label for="" class="kalimati-font">{{ $dirghaother->count() }}</label>
                            </div>
                            <hr class="m-0 p-0">
                            <div class="d-flex justify-content-between mt-2">
                                <label class="dashboard-card-title">दर्ता भएका</label>
                                <label for=""
                                    class="kalimati-font">{{ $dirghaCount->whereNotNull('registered_date')->count() }}</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label class="dashboard-card-title">महिला</label>
                                <label for=""
                                    class="kalimati-font">{{ $dirghaCount->whereNotNull('registered_date')->filter(function ($user) {
                                            return strtolower($user->gender) === 'female';
                                        })->count() }}</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label class="dashboard-card-title">पुरुष</label>
                                <label for=""
                                    class="kalimati-font">{{ $dirghaCount->whereNotNull('registered_date')->filter(function ($user) {
                                            return strtolower($user->gender) === 'male';
                                        })->count() }}</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label class="dashboard-card-title">अन्य</label>
                                <label for=""
                                    class="kalimati-font">{{ $dirghaCount->whereNotNull('registered_date')->filter(function ($user) {
                                            return strtolower($user->gender) === 'other';
                                        })->count() }}</label>
                            </div>

                        </div>
                    </div>
                </div> --}}



                {{-- <div class="col-md-3">
                    <div class="card ">
                        <h4 class="  dashboard-main-title  bg-primary text-white p-2 rounded-top">बिपन्न सहयोगको
                            सिफारिस</h4>
                        <div class=" px-3">


                            <div class="d-flex justify-content-between mt-2 text-secondary">
                                <label class="dashboard-card-title  "><i class="pr-3 bi bi-journal-check "></i>
                                    दर्ता
                                    भएका</label>
                                <label for=""
                                    class="kalimati-font">{{ $bipannaCount->whereNotNull('registered_date')->count() }}</label>
                            </div>

                            <div class="d-flex justify-content-between text-secondary">
                                <label class="dashboard-card-title"><i class="pr-3 bi bi-recycle"></i> नवीकरण भएका</label>
                                <label for="" class="kalimati-font">{{ $renewedCounts[2] }}</label>
                            </div>
                            <div class="d-flex justify-content-between text-secondary">
                                <label class="dashboard-card-title"><i class="pr-3 bi bi-exclamation-triangle"></i> नवीकरण
                                    नभएका</label>
                                <label for="" class="kalimati-font">{{ $expiredCounts[2] }}</label>
                            </div>
                            <div class="d-flex justify-content-between text-secondary">
                                <label class="dashboard-card-title"><i class="pr-3 bi bi-x " style="font-size: 1rem"></i>
                                    लागतकट्टा भएका</label>
                                <label for=""
                                    class="kalimati-font">{{ $bipannaCount->whereNotNull('closed_date')->count() }}</label>
                            </div>

                            <hr class="p-0 m-0 mb-2">
                            <div class="d-flex justify-content-between text-dark ">
                                <div class="d-flex items-center">
                                    <span class="dashboard-card-title pl-5"
                                        style="font-size: 14px; font-weight:600 ">जम्मा
                                        आवेदन</span>
                                </div>
                                <label for="" class="kalimati-font"
                                    style="font-weight: bold">{{ $bipannaCount->count() }}</label>
                            </div>




                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card ">
                        <h4 class="  dashboard-main-title  bg-info text-white p-2 rounded-top">सामाजिक विकास
                            मन्त्रालय</h4>
                        <div class=" px-3">


                            <div class="d-flex justify-content-between mt-2 text-secondary">
                                <label class="dashboard-card-title  "><i class="pr-3 bi bi-journal-check "></i>
                                    दर्ता
                                    भएका</label>
                                <label for=""
                                    class="kalimati-font">{{ $samajikCount->whereNotNull('registered_date')->count() }}</label>
                            </div>

                            <div class="d-flex justify-content-between text-secondary">
                                <label class="dashboard-card-title"><i class="pr-3 bi bi-recycle"></i> नवीकरण भएका</label>
                                <label for="" class="kalimati-font">{{ $renewedCounts[3] }}</label>
                            </div>
                            <div class="d-flex justify-content-between text-secondary">
                                <label class="dashboard-card-title"><i class="pr-3 bi bi-exclamation-triangle"></i> नवीकरण
                                    नभएका</label>
                                <label for="" class="kalimati-font">{{ $expiredCounts[3] }}</label>
                            </div>
                            <div class="d-flex justify-content-between text-secondary">
                                <label class="dashboard-card-title"><i class="pr-3 bi bi-x " style="font-size: 1rem"></i>
                                    लागतकट्टा भएका</label>
                                <label for=""
                                    class="kalimati-font">{{ $samajikCount->whereNotNull('closed_date')->count() }}</label>
                            </div>

                            <hr class="p-0 m-0 mb-2">
                            <div class="d-flex justify-content-between text-dark ">
                                <div class="d-flex items-center">
                                    <span class="dashboard-card-title pl-5"
                                        style="font-size: 14px; font-weight:600 ">जम्मा
                                        आवेदन</span>
                                </div>
                                <label for="" class="kalimati-font"
                                    style="font-weight: bold">{{ $samajikCount->count() }}</label>
                            </div>




                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card ">
                        <h4 class="  dashboard-main-title  bg-danger text-white p-2 rounded-top">पालिकाको स्वास्थ्य राहत
                            कोष</h4>
                        <div class=" px-3">


                            <div class="d-flex justify-content-between mt-2 text-secondary">
                                <label class="dashboard-card-title  "><i class="pr-3 bi bi-journal-check "></i>
                                    दर्ता
                                    भएका</label>
                                <label for=""
                                    class="kalimati-font">{{ $nagarpalikaCount->whereNotNull('registered_date')->count() }}</label>
                            </div>

                            <div class="d-flex justify-content-between text-secondary">
                                <label class="dashboard-card-title"><i class="pr-3 bi bi-recycle"></i> नवीकरण भएका</label>
                                <label for="" class="kalimati-font">{{ $renewedCounts[4] }}</label>
                            </div>
                            <div class="d-flex justify-content-between text-secondary">
                                <label class="dashboard-card-title"><i class="pr-3 bi bi-exclamation-triangle"></i> नवीकरण
                                    नभएका</label>
                                <label for="" class="kalimati-font">{{ $expiredCounts[4] }}</label>
                            </div>
                            <div class="d-flex justify-content-between text-secondary">
                                <label class="dashboard-card-title"><i class="pr-3 bi bi-x " style="font-size: 1rem"></i>
                                    लागतकट्टा भएका</label>
                                <label for=""
                                    class="kalimati-font">{{ $nagarpalikaCount->whereNotNull('closed_date')->count() }}</label>
                            </div>

                            <hr class="p-0 m-0 mb-2">
                            <div class="d-flex justify-content-between text-dark ">
                                <div class="d-flex items-center">
                                    <span class="dashboard-card-title pl-5"
                                        style="font-size: 14px; font-weight:600 ">जम्मा
                                        आवेदन</span>
                                </div>
                                <label for="" class="kalimati-font"
                                    style="font-weight: bold">{{ $nagarpalikaCount->count() }}</label>
                            </div>




                        </div>
                    </div>
                </div> --}}

                {{-- <div class="col-md-3">
                    <div class="card h-100 " style="background-color: #dc35464b">
                        <div class="card-body">
                            <label class="col-12 font-weight-bold text-center dashboard-main-title">बिपन्न सहयोगको
                                सिफारिस</label>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <label class="dashboard-card-title">आवेदन फारम</label>
                                <label for="" class="kalimati-font">{{ $bipannaCount->count() }}</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label class="dashboard-card-title">महिला</label>
                                @php
                                    $bipannaFemale = $bipannaCount->filter(function ($user) {
                                        return strtolower($user->gender) === 'female';
                                    });
                                @endphp
                                <label for="" class="kalimati-font">{{ $bipannaFemale->count() }}</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label class="dashboard-card-title">पुरुष</label>
                                @php
                                    $bipannaMale = $bipannaCount->filter(function ($user) {
                                        return strtolower($user->gender) === 'male';
                                    });
                                @endphp
                                <label for="" class="kalimati-font">{{ $bipannaMale->count() }}</label>

                            </div>
                            <div class="d-flex justify-content-between">
                                <label class="dashboard-card-title">अन्य</label>
                                @php
                                    $bipannaother = $bipannaCount->filter(function ($user) {
                                        return strtolower($user->gender) === 'other';
                                    });
                                @endphp
                                <label for="" class="kalimati-font">{{ $bipannaother->count() }}</label>

                            </div>
                            <hr class="mt-1">
                            <div class="d-flex justify-content-between">
                                <label class="dashboard-card-title">सिफारिस भएका</label>
                                <label for=""
                                    class="kalimati-font">{{ $bipannaCount->whereNotNull('registered_date')->count() }}</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label class="dashboard-card-title">महिला</label>
                                <label for=""
                                    class="kalimati-font">{{ $bipannaCount->whereNotNull('registered_date')->filter(function ($user) {
                                            return strtolower($user->gender) === 'female';
                                        })->count() }}</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label class="dashboard-card-title">पुरुष</label>
                                <label for=""
                                    class="kalimati-font">{{ $bipannaCount->whereNotNull('registered_date')->filter(function ($user) {
                                            return strtolower($user->gender) === 'male';
                                        })->count() }}</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label class="dashboard-card-title">अन्य</label>
                                <label for=""
                                    class="kalimati-font">{{ $bipannaCount->whereNotNull('registered_date')->filter(function ($user) {
                                            return strtolower($user->gender) === 'other';
                                        })->count() }}</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card h-100 " style="background-color: #007bff57">
                        <div class="card-body">
                            <label class="col-12 font-weight-bold text-center dashboard-main-title">सामाजिक विकास
                                मन्त्रालय</label>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <label class="dashboard-card-title">आवेदन फारम</label>
                                <label for="" class="kalimati-font">{{ $samajikCount->count() }}</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label class="dashboard-card-title">महिला</label>
                                @php
                                    $samajikfemale = $samajikCount->filter(function ($user) {
                                        return strtolower($user->gender) === 'female';
                                    });
                                @endphp
                                <label for="" class="kalimati-font">{{ $samajikfemale->count() }}</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label class="dashboard-card-title">पुरुष</label>
                                @php
                                    $samajikmale = $samajikCount->filter(function ($user) {
                                        return strtolower($user->gender) === 'male';
                                    });
                                @endphp
                                <label for="" class="kalimati-font">{{ $samajikmale->count() }}</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label class="dashboard-card-title">अन्य</label>
                                @php
                                    $samajikother = $samajikCount->filter(function ($user) {
                                        return strtolower($user->gender) === 'other';
                                    });
                                @endphp
                                <label for="" class="kalimati-font">{{ $samajikother->count() }}</label>
                            </div>
                            <hr class="m-0 p-0">
                            <div class="d-flex mt-1 justify-content-between">
                                <label class="dashboard-card-title">सिफारिस भएका</label>
                                <label for=""
                                    class="kalimati-font">{{ $samajikCount->whereNotNull('registered_date')->count() }}</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label class="dashboard-card-title">महिला</label>
                                <label for=""
                                    class="kalimati-font">{{ $samajikCount->whereNotNull('registered_date')->filter(function ($user) {
                                            return strtolower($user->gender) === 'female';
                                        })->count() }}</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label class="dashboard-card-title">पुरुष</label>
                                <label for=""
                                    class="kalimati-font">{{ $samajikCount->whereNotNull('registered_date')->filter(function ($user) {
                                            return strtolower($user->gender) === 'male';
                                        })->count() }}</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label class="dashboard-card-title">अन्य</label>
                                <label for=""
                                    class="kalimati-font">{{ $samajikCount->whereNotNull('registered_date')->filter(function ($user) {
                                            return strtolower($user->gender) === 'other';
                                        })->count() }}</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card h-100 " style="background-color: #ffc1075f">
                        <div class="card-body">
                            <label class="col-12 font-weight-bold text-center dashboard-main-title">पालिकाको स्वास्थ्य राहत
                                कोष</label>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <label class="dashboard-card-title">आवेदन फारम</label>
                                <label for="" class="kalimati-font">{{ $nagarpalikaCount->count() }}</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label class="dashboard-card-title">महिला</label>
                                @php
                                    $nagarpalikafemale = $nagarpalikaCount->filter(function ($user) {
                                        return strtolower($user->gender) === 'female';
                                    });
                                @endphp
                                <label for="" class="kalimati-font">{{ $nagarpalikafemale->count() }}</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label class="dashboard-card-title">पुरुष</label>
                                @php
                                    $nagarpalikamale = $nagarpalikaCount->filter(function ($user) {
                                        return strtolower($user->gender) === 'male';
                                    });
                                @endphp
                                <label for="" class="kalimati-font">{{ $nagarpalikamale->count() }}</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label class="dashboard-card-title">अन्य</label>
                                @php
                                    $nagarpalikaother = $nagarpalikaCount->filter(function ($user) {
                                        return strtolower($user->gender) === 'other';
                                    });
                                @endphp
                                <label for="" class="kalimati-font">{{ $nagarpalikaother->count() }}</label>
                            </div>
                            <hr class="m-0 p-0">
                            <div class="d-flex justify-content-between">
                                <label class="dashboard-card-title">सिफारिस भएका</label>
                                <label for=""
                                    class="kalimati-font">{{ $nagarpalikaCount->whereNotNull('registered_date')->count() }}</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label class="dashboard-card-title">महिला</label>
                                <label for=""
                                    class="kalimati-font">{{ $nagarpalikaCount->whereNotNull('registered_date')->filter(function ($user) {
                                            return strtolower($user->gender) === 'female';
                                        })->count() }}</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label class="dashboard-card-title">पुरुष</label>
                                <label for=""
                                    class="kalimati-font">{{ $nagarpalikaCount->whereNotNull('registered_date')->filter(function ($user) {
                                            return strtolower($user->gender) === 'male';
                                        })->count() }}</label>
                            </div>
                            <div class="d-flex justify-content-between">
                                <label class="dashboard-card-title">अन्य</label>
                                <label for=""
                                    class="kalimati-font">{{ $nagarpalikaCount->whereNotNull('registered_date')->filter(function ($user) {
                                            return strtolower($user->gender) === 'other';
                                        })->count() }}</label>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>

            <div class="row">
                <div class="col-lg-6 mt-2">
                    <div class="card">
                        {{-- <div class="card-header bg-white d-flex justify-content-between">
                            <select name="" id="dirghaChart" class="form-control" style="width: 100px">
                                <option value="line">Line chart</option>
                                <option value="area" selected>Area chart</option>
                                <option value="bar">Bar chart</option>
                            </select>
                        </div> --}}
                        <div class="card-body">
                            <div id="chart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-2">
                    <div class="card">
                        <div class="card-body">
                            <div id="chartBipanna"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-2">
                    <div class="card">
                        <div class="card-body">
                            <div id="chartSamajik"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-2">
                    <div class="card">
                        <div class="card-body">
                            <div id="chartNagarpalika"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    {{-- <script src="https://unpkg.com/chart.js@2.9.3/dist/Chart.min.js"></script>
    <script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>

    <script src="{{ asset('assets/table2excel/dist/jquery.table2excel.js') }}"></script>
    <script>
        $(function() {
            $("#js-export-business-by-type-table-btn").click(function(e) {
                var table = $('#js-business-by-type-table');
                if (table && table.length) {
                    var preserveColors = (table.hasClass('table2excel_with_colors') ? true : false);
                    $(table).table2excel({
                        exclude: ".noExl",
                        name: "Business By Type",
                        filename: "business-by-type-" + new Date().toISOString().replace(
                            /[\-\:\.]/g, "") + ".xls",
                        fileext: ".xls",
                        exclude_img: true,
                        exclude_links: true,
                        exclude_inputs: true,
                        preserveColors: preserveColors
                    });
                }
            });

        });
    </script>
    <script>
        const ctx = document.getElementById('myChart');
        var renewed = "{{ $renewedCounts[1] }}";
        var dateExpired = "{{ $expiredCount }}";
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['नविकरण भएका', 'नविकरण नभएका'],
                datasets: [{
                    label: '# of Votes',
                    data: [renewed, dateExpired],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script>
        const ctx1 = document.getElementById('myChart1');
        var dirgha = "{{ $totalDirgha }}";
        var bipanna = "{{ $totalBipanna }}";
        var samajik = "{{ $totalSamajik }}";
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['दिर्घ', 'बिपन्न', 'सामाजिक'],
                datasets: [{
                    label: '# of Votes',
                    data: [dirgha, bipanna, samajik],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script> --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        let dirghaChart = "bar";
    </script>
    <script>
        let graphData = @json($graphData);
        console.log(graphData['dirghaDisease']);
        let dirghaDiseaseiseasesArray = graphData.map(item => item.dirghaDisease);
        let dirghaPatientCountArray = graphData.map(item => item.dirghaCount);
        let dirghaMale = graphData.map(item => item.dirghaMale);
        let dirghaFemale = graphData.map(item => item.dirghaFemale);
        let dirghaOther = graphData.map(item => item.dirghaOther);
        console.log(dirghaDiseaseiseasesArray);
        var options = {
            series: [{
                    name: "जम्मा",
                    data: dirghaPatientCountArray
                },
                {
                    name: "महिला",
                    data: dirghaFemale
                },
                {
                    name: "पुरुष",
                    data: dirghaMale
                }, {
                    name: 'अन्य',
                    data: dirghaOther,
                }
            ],
            chart: {
                height: 350,
                type: dirghaChart,
                dropShadow: {
                    enabled: true,
                    color: '#000',
                    top: 18,
                    left: 7,
                    blur: 10,
                    opacity: 0.2
                },
                zoom: {
                    enabled: true
                },
                toolbar: {
                    show: true
                }
            },
            colors: ['#77B6EA', '#545454', '#ECBEC5', '#F7E3A0'],
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: 'smooth'
            },
            title: {
                text: ' दीर्घरोगी मासिक उपचार खर्च ',
                align: 'left'
            },
            grid: {
                borderColor: '#e7e7e7',
                row: {
                    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                },
            },
            markers: {
                size: 1
            },
            xaxis: {
                categories: dirghaDiseaseiseasesArray,
                title: {
                    text: 'रोगहरु'
                },
                labels: {
                    rotate: 0,
                    style: {
                        fontSize: '8px',
                        fontWeight: 'bold',
                        fontFamily: 'Arial, sans-serif',
                        colors: ['#000']
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'बिरामी संख्या'
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                floating: true,
                offsetY: -25,
                offsetX: -5
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
    <script>
        let bipannaGraphData = @json($bipannaGraphData);
        console.log(bipannaGraphData['bipannaDisease']);
        let bipannaDiseaseiseasesArray = bipannaGraphData.map(item => item.bipannaDisease);
        let bipannaPatientCountArray = bipannaGraphData.map(item => item.bipannaCount);
        let bipannaMale = bipannaGraphData.map(item => item.bipannaMale);
        let bipannaFemale = bipannaGraphData.map(item => item.bipannaFemale);
        let bipannaOther = bipannaGraphData.map(item => item.bipannaOther);
        // console.log(bipannaDiseaseiseasesArray);
        var options1 = {
            series: [{
                    name: "जम्मा",
                    data: bipannaPatientCountArray
                },
                {
                    name: "महिला",
                    data: bipannaFemale
                },
                {
                    name: "पुरुष",
                    data: bipannaMale
                },
                {
                    name: 'अन्य',
                    data: bipannaOther,
                }
            ],
            chart: {
                height: 350,
                type: dirghaChart,
                dropShadow: {
                    enabled: true,
                    color: '#000',
                    top: 18,
                    left: 7,
                    blur: 10,
                    opacity: 0.2
                },
                zoom: {
                    enabled: true
                },
                toolbar: {
                    show: true
                }
            },
            colors: ['#77B6EA', '#545454', '#ECBEC5', '#F7E3A0'],
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: 'smooth'
            },
            title: {
                text: '  बिपन्न सहयोगको सिफारिस',
                align: 'left'
            },
            grid: {
                borderColor: '#e7e7e7',
                row: {
                    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                },
            },
            markers: {
                size: 1
            },
            xaxis: {
                categories: bipannaDiseaseiseasesArray,
                title: {
                    text: 'रोगहरु'
                },
                labels: {
                    rotate: 0,
                    style: {
                        fontSize: '8px',
                        fontWeight: 'bold',
                        fontFamily: 'Arial, sans-serif',
                        colors: ['#000']
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'बिरामी संख्या'
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                floating: true,
                offsetY: -25,
                offsetX: -5
            }
        };

        var chart1 = new ApexCharts(document.querySelector("#chartBipanna"), options1);
        chart1.render();
    </script>
    <script>
        let samajikGraphData = @json($samajikGraphData);
        console.log(samajikGraphData['samajikDisease']);
        let samajikDiseaseiseasesArray = samajikGraphData.map(item => item.samajikDisease);
        let samajikPatientCountArray = samajikGraphData.map(item => item.samajikCount);
        let samajikMale = samajikGraphData.map(item => item.samajikMale);
        let samajikFemale = samajikGraphData.map(item => item.samajikFemale);
        let samajikOther = samajikGraphData.map(item => item.samajikOther);
        // console.log(samajikDiseaseiseasesArray);
        var options1 = {
            series: [{
                    name: "जम्मा",
                    data: samajikPatientCountArray
                },
                {
                    name: "महिला",
                    data: samajikFemale
                },
                {
                    name: "पुरुष",
                    data: samajikMale
                },
                {
                    name: 'अन्य',
                    data: samajikOther,
                }
            ],
            chart: {
                height: 350,
                type: dirghaChart,
                dropShadow: {
                    enabled: true,
                    color: '#000',
                    top: 18,
                    left: 7,
                    blur: 10,
                    opacity: 0.2
                },
                zoom: {
                    enabled: true
                },
                toolbar: {
                    show: true
                }
            },
            colors: ['#77B6EA', '#545454', '#ECBEC5', '#F7E3A0'],
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: 'smooth'
            },
            title: {
                text: '   सामाजिक विकास मन्त्रालय ',
                align: 'left'
            },
            grid: {
                borderColor: '#e7e7e7',
                row: {
                    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                },
            },
            markers: {
                size: 1
            },
            xaxis: {
                categories: samajikDiseaseiseasesArray,
                title: {
                    text: 'रोगहरु'
                },
                labels: {
                    rotate: 0,
                    style: {
                        fontSize: '8px',
                        fontWeight: 'bold',
                        fontFamily: 'Arial, sans-serif',
                        colors: ['#000']
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'बिरामी संख्या'
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                floating: true,
                offsetY: -25,
                offsetX: -5
            }
        };

        var chart1 = new ApexCharts(document.querySelector("#chartSamajik"), options1);
        chart1.render();
    </script>

    <script>
        let nagarpalikaGraphData = @json($nagarpalikaGraphData);
        console.log(nagarpalikaGraphData['nagarpalikaDisease']);
        let nagarpalikaDiseaseiseasesArray = nagarpalikaGraphData.map(item => item.nagarpalikaDisease);
        let nagarpalikaPatientCountArray = nagarpalikaGraphData.map(item => item.nagarpalikaCount);
        let nagarpalikaMale = nagarpalikaGraphData.map(item => item.nagarpalikaMale);
        let nagarpalikaFemale = nagarpalikaGraphData.map(item => item.nagarpalikaFemale);
        let nagarpalikaOther = nagarpalikaGraphData.map(item => item.nagarpalikaOther);
        // console.log(nagarpalikaDiseaseiseasesArray);
        var optionsNagarpalika = {
            series: [{
                    name: "जम्मा",
                    data: nagarpalikaPatientCountArray
                },
                {
                    name: "महिला",
                    data: nagarpalikaFemale
                },
                {
                    name: "पुरुष",
                    data: nagarpalikaMale
                },
                {
                    name: "अन्य",
                    data: nagarpalikaOther,
                }
            ],
            chart: {
                height: 350,
                type: dirghaChart,
                dropShadow: {
                    enabled: true,
                    color: '#000',
                    top: 18,
                    left: 7,
                    blur: 10,
                    opacity: 0.2
                },
                zoom: {
                    enabled: true
                },
                toolbar: {
                    show: true
                }
            },
            colors: ['#77B6EA', '#545454', '#ECBEC5', '#F7E3A0'],
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: 'smooth'
            },
            title: {
                text: ' पालिकाको स्वास्थ्य राहत कोष ',
                align: 'left'
            },
            grid: {
                borderColor: '#e7e7e7',
                row: {
                    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                },
            },
            markers: {
                size: 1
            },
            xaxis: {
                categories: nagarpalikaDiseaseiseasesArray,
                title: {
                    text: 'रोगहरु'
                },
                labels: {
                    rotate: 0,
                    style: {
                        fontSize: '8px',
                        fontWeight: 'bold',
                        fontFamily: 'Arial, sans-serif',
                        colors: ['#000']
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'बिरामी संख्या'
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                floating: true,
                offsetY: -25,
                offsetX: -5
            }
        };

        var chart1 = new ApexCharts(document.querySelector("#chartNagarpalika"), optionsNagarpalika);
        chart1.render();
    </script>


    <script>
        $("#dirghaChart").on('change', () => {
            dirghaChart = $("#dirghaChart").val();

            // Destroy the old chart instance
            chart.updateOptions({
                chart: {
                    type: dirghaChart
                }
            });
        });
    </script>
@endpush
