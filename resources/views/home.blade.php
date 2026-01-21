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
        {{-- Page Title --}}
        <div class="dashboard-header mb-5">
            <h5 class="fw-bold text-secondary mb-0 dashboard-title">
                Dashboard Overview
            </h5>
        </div>

        {{-- Stats Cards --}}
        <div class="row g-4">
            @foreach ($applicationTypeCounts as $row)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card dashboard-card h-100 border-0 shadow-sm hover-shadow transition-all">
                        <div class="card-body d-flex flex-column p-4">
                            {{-- Category --}}
                            <div class="dashboard-category text-muted text-uppercase small fw-semibold mb-2">
                                {{ $row->application_type->name }}
                            </div>

                            {{-- Count --}}
                            <div class="dashboard-count mt-auto">
                                <h2 class="fw-bold text-dark mb-0 display-5">
                                    {{ number_format($row->total_patients) }}
                                </h2>
                                <p class="text-muted small mb-0 mt-1">Total Patients</p>
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
        border-radius: 12px;
        background: #fff;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: 1px solid rgba(0,0,0,0.05);
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
</style>
@endsection
{{-- <style>
    .dashboard-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
        transition: all 0.25s ease;
    }

    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
    }

    .dashboard-card h2 {
        font-size: 2.2rem;
    }
</style> --}}
