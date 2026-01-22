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
    @endphp
    <div id="dashboard" class="dashboard-wrapper">
        <div class="container-fluid font-noto">

            <div class="dashboard-header mb-5">
                <h5 class="fw-bold text-secondary mb-0 dashboard-title">
                    Dashboard
                </h5>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card info-style-card-total h-100">
                        <div class="card-body p-4">
                            <div class="fw-bold mb-3  text-danger kalimati-font">
                                जम्मा आवेदनहरू
                            </div>
                            <div class="normal">
                                <div class="text-primary fw-semibold kalimati-font">
                                    कुल आवेदनहरू: {{ number_format($allPatientsCount) }}
                                </div>
                                <div class="text-danger fw-semibold kalimati-font">
                                    नयाँ आवेदनहरू: {{ number_format($allunverifiedPatientsCount) }}
                                </div>
                                <div class="text-success fw-semibold kalimati-font">
                                    <i class="pr-2 bi bi-journal-check text-success "></i> दर्ता भएका:
                                    {{ number_format($allverifiedPatientsCount) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card info-style-card-total h-100">
                        <div class="card-body p-4">
                            <div class="fw-bold mb-3 text-primary kalimati-font">
                                 सामाग्री विवरण
                            </div>

                            <div class="normal">
                                <div class="text-dark fw-semibold kalimati-font">
                                    जम्मा सामाग्री: {{ number_format($totalResources) }}
                                </div>

                                <div class="text-warning fw-semibold kalimati-font">
                                    फिर्ता पाउने सामाग्री: {{ number_format($returnableResources) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

          



            <div class="row g-4">
                @foreach ($applicationTypeCounts as $row)
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="card dashboard-card info-style-card h-100   transition-all">
                            <div class="card-body d-flex flex-column p-4">

                                <div class="dashboard-category fw-bold mb-3 kalimati-font">
                                    {{ $row->application_type->name }}
                                </div>

                                <div class="dashboard-count mt-auto">
                                    <div class="normal">
                                        <div class="text-primary fw-semibold kalimati-font">
                                            कुल आवेदनहरू: {{ number_format($row->total_patients) }}
                                        </div>
                                        <div class="text-danger fw-semibold kalimati-font">
                                            नयाँ आवेदनहरू: {{ number_format($row->unverified_patients) }}
                                        </div>
                                        <div class="text-success fw-semibold kalimati-font">
                                            <i class="pr-2 bi bi-journal-check text-success "></i>दर्ता भएका:
                                            {{ number_format($row->verified_patients) }}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <style>
        .dashboard-wrapper {
            padding: 1.5rem;
        }

        .dashboard-header {
            padding-top: 0.5rem;
        }

        .dashboard-title {
            font-size: 1.25rem;
            letter-spacing: -0.01em;
        }

        .dashboard-card {

            background: #fff;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .dashboard-card.hover-shadow:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08) !important;
        }

        .dashboard-category {
            letter-spacing: 0.03em;
            opacity: 0.8;
        }

        .dashboard-count h2 {
            font-size: 2.5rem;
            line-height: 1.1;
            letter-spacing: -0.02em;
        }

        @media (max-width: 768px) {
            .dashboard-wrapper {
                padding: 1rem;
            }

            .dashboard-count h2 {
                font-size: 2rem;
            }

            .dashboard-card {
                border-radius: 10px;
            }
        }

        .info-style-card {
            background: #ffffff;
            border-left: 6px solid #0b3a8f;
            border-radius: 0;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
        }

        .info-style-card .dashboard-category {
            color: #0b3a8f;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .info-style-card .dashboard-count div {
            line-height: 1.8;
        }

        .info-style-card-total {
            background: #ffffff;
            border-left: 6px solid #ff0909;
            border-radius: 0;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
        }

        .info-style-card-total .dashboard-category {
            color: #0b3a8f;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .info-style-card-total .dashboard-count div {
            line-height: 1.8;
        }
    </style>
@endsection
