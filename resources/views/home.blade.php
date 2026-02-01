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





            {{-- <div class="row g-4">
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
            </div> --}}

            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3 kalimati-font">आवेदनहरूको तुलनात्मक विवरण</h5>
                            <div class="chart-container" style="position: relative; height: 400px;">
                                <canvas id="applicationChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @push('scripts')
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const ctx = document.getElementById('applicationChart').getContext('2d');

                        // Prepare data from PHP variable
                        const appTypes = @json($applicationTypeCounts->pluck('application_type.name'));
                        const totalPatients = @json($applicationTypeCounts->pluck('total_patients'));
                        const verifiedPatients = @json($applicationTypeCounts->pluck('verified_patients'));
                        const unverifiedPatients = @json($applicationTypeCounts->pluck('unverified_patients'));

                        // Filter out empty data (where total patients is 0)
                        const filteredData = [];
                        const filteredAppTypes = [];
                        const filteredTotalPatients = [];
                        const filteredVerifiedPatients = [];
                        const filteredUnverifiedPatients = [];

                        appTypes.forEach((type, index) => {
                            if (totalPatients[index] > 0) {
                                filteredAppTypes.push(type);
                                filteredTotalPatients.push(totalPatients[index]);
                                filteredVerifiedPatients.push(verifiedPatients[index]);
                                filteredUnverifiedPatients.push(unverifiedPatients[index]);
                            }
                        });

                        // If all data is empty, show a message
                        if (filteredAppTypes.length === 0) {
                            document.getElementById('applicationChart').parentElement.innerHTML =
                                '<div class="text-center py-5">' +
                                '<i class="bi bi-bar-chart display-1 text-muted"></i>' +
                                '<p class="mt-3 text-muted kalimati-font">तुलना गर्न को लागी आवेदनहरू उपलब्ध छैनन्</p>' +
                                '</div>';
                            return;
                        }

                        const applicationChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: filteredAppTypes,
                                datasets: [{
                                        label: 'कुल आवेदनहरू',
                                        data: filteredTotalPatients,
                                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                                        borderColor: 'rgba(54, 162, 235, 1)',
                                        borderWidth: 1
                                    },
                                    {
                                        label: 'दर्ता भएका',
                                        data: filteredVerifiedPatients,
                                        backgroundColor: 'rgba(75, 192, 192, 0.7)',
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        borderWidth: 1
                                    },
                                    {
                                        label: 'नयाँ आवेदनहरू',
                                        data: filteredUnverifiedPatients,
                                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                                        borderColor: 'rgba(255, 99, 132, 1)',
                                        borderWidth: 1
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                        labels: {
                                            font: {
                                                family: 'Kalimati, sans-serif'
                                            }
                                        }
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                return `${context.dataset.label}: ${context.parsed.y.toLocaleString()}`;
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            callback: function(value) {
                                                return value.toLocaleString();
                                            },
                                            font: {
                                                family: 'Kalimati, sans-serif'
                                            }
                                        },
                                        title: {
                                            display: true,
                                            text: 'आवेदन संख्या',
                                            font: {
                                                family: 'Kalimati, sans-serif',
                                                size: 12,
                                                weight: 'bold'
                                            }
                                        }
                                    },
                                    x: {
                                        ticks: {
                                            font: {
                                                family: 'Kalimati, sans-serif'
                                            }
                                        },
                                        title: {
                                            display: true,
                                            text: 'आवेदन प्रकार',
                                            font: {
                                                family: 'Kalimati, sans-serif',
                                                size: 12,
                                                weight: 'bold'
                                            }
                                        }
                                    }
                                }
                            },
                            // Custom plugin to show data labels only for non-zero values
                            plugins: [{
                                id: 'datalabels',
                                afterDatasetsDraw: function(chart) {
                                    const ctx = chart.ctx;
                                    chart.data.datasets.forEach(function(dataset, i) {
                                        const meta = chart.getDatasetMeta(i);
                                        if (!meta.hidden) {
                                            meta.data.forEach(function(element, index) {
                                                const value = dataset.data[index];

                                                // Skip drawing label if value is 0
                                                if (value === 0) {
                                                    return;
                                                }

                                                ctx.fillStyle = '#000';
                                                const fontSize = 10;
                                                const fontStyle = 'bold';
                                                const fontFamily = 'Kalimati, sans-serif';
                                                ctx.font = Chart.helpers.fontString(
                                                    fontSize, fontStyle, fontFamily);
                                                ctx.textAlign = 'center';
                                                ctx.textBaseline = 'bottom';

                                                const padding = 5;
                                                const position = element.tooltipPosition();
                                                const text = value.toLocaleString();

                                                // Draw text background for better readability
                                                ctx.fillStyle = 'rgba(255, 255, 255, 0.7)';
                                                const textWidth = ctx.measureText(text)
                                                    .width;
                                                const textHeight = fontSize;
                                                ctx.fillRect(
                                                    position.x - textWidth / 2 - 2,
                                                    position.y - textHeight - padding -
                                                    2,
                                                    textWidth + 4,
                                                    textHeight + 4
                                                );

                                                // Draw text
                                                ctx.fillStyle = '#000';
                                                ctx.fillText(text, position.x, position.y -
                                                    padding);
                                            });
                                        }
                                    });
                                }
                            }]
                        });
                    });
                </script>
            @endpush



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
