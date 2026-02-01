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

            {{-- <div class="row mb-4">
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
            </div> --}}

             <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card info-style-card-total h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <i class="bi bi-clipboard-data fs-3 text-danger me-3"></i>
                                <div class="fw-bold fs-4 text-danger kalimati-font">
                                    जम्मा आवेदनहरू
                                </div>
                            </div>
                            <div class="normal">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-people-fill fs-5 text-primary me-3"></i>
                                    <div class="text-primary fw-semibold fs-5 kalimati-font">
                                        कुल आवेदनहरू: {{ number_format($allPatientsCount) }}
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-person-plus fs-5 text-danger me-3"></i>
                                    <div class="text-danger fw-semibold fs-5 kalimati-font">
                                        नयाँ आवेदनहरू: {{ number_format($allunverifiedPatientsCount) }}
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-journal-check fs-5 text-success me-3"></i>
                                    <div class="text-success fw-semibold fs-5 kalimati-font">
                                        दर्ता भएका: {{ number_format($allverifiedPatientsCount) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card info-style-card-total h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <i class="bi bi-box-seam fs-3 text-primary me-3"></i>
                                <div class="fw-bold fs-4 text-primary kalimati-font">
                                    सामाग्री विवरण
                                </div>
                            </div>

                            <div class="normal">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-boxes fs-5 text-dark me-3"></i>
                                    <div class="text-dark fw-semibold fs-5 kalimati-font">
                                        जम्मा सामाग्री: {{ number_format($totalResources) }}
                                    </div>
                                </div>

                                <div class="d-flex align-items-center">
                                    <i class="bi bi-arrow-return-right fs-5 text-warning me-3"></i>
                                    <div class="text-warning fw-semibold fs-5 kalimati-font">
                                        फिर्ता पाउने सामाग्री: {{ number_format($returnableResources) }}
                                    </div>
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

                        // Calculate the maximum value from all datasets
                        const maxDataValue = Math.max(
                            ...filteredTotalPatients,
                            ...filteredVerifiedPatients,
                            ...filteredUnverifiedPatients
                        );

                        // Function to determine optimal step size for Y-axis
                        function getOptimalStepSize(maxValue) {
                            const steps = [1, 2, 5, 10, 20, 50, 100, 200, 500, 1000, 2000, 5000];
                            const targetNumberOfTicks = 6;
                            const roughStep = maxValue / targetNumberOfTicks;

                            for (let step of steps) {
                                if (step >= roughStep) return step;
                            }
                            return Math.ceil(roughStep / 1000) * 1000;
                        }

                        // Function to format Y-axis labels in Nepali readable format
                        function formatYAxisLabel(value) {
                            // Convert to Nepali numerals if needed
                            const toNepaliNumeral = (num) => {
                                const nepaliDigits = ['०', '१', '२', '३', '४', '५', '६', '७', '८', '९'];
                                return num.toString().replace(/\d/g, (digit) => nepaliDigits[digit]);
                            };

                            // Format based on the maximum value in dataset
                            if (maxDataValue >= 1000000) {
                                const valueInMillions = (value / 1000000).toFixed(1);
                                return toNepaliNumeral(valueInMillions) + 'M';
                            }
                            if (maxDataValue >= 10000) {
                                const valueInThousands = (value / 1000).toFixed(0);
                                return toNepaliNumeral(valueInThousands) + 'K';
                            }
                            if (maxDataValue >= 1000) {
                                const valueInThousands = (value / 1000).toFixed(1);
                                return toNepaliNumeral(valueInThousands) + 'K';
                            }
                            return toNepaliNumeral(value.toLocaleString());
                        }

                        // Function to format tooltip values (always show actual numbers)
                        function formatTooltipValue(value) {
                            const nepaliDigits = ['०', '१', '२', '३', '४', '५', '६', '७', '८', '९'];
                            return value.toString().replace(/\d/g, (digit) => nepaliDigits[digit]);
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
                                                family: 'Kalimati, sans-serif',
                                                size: 12
                                            },
                                            color: '#333'
                                        }
                                    },
                                    tooltip: {
                                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                                        titleColor: '#000',
                                        bodyColor: '#000',
                                        borderColor: '#ddd',
                                        borderWidth: 1,
                                        titleFont: {
                                            family: 'Kalimati, sans-serif',
                                            size: 12,
                                            weight: 'bold'
                                        },
                                        bodyFont: {
                                            family: 'Kalimati, sans-serif',
                                            size: 12
                                        },
                                        padding: 10,
                                        callbacks: {
                                            label: function(context) {
                                                const label = context.dataset.label || '';
                                                const value = context.parsed.y;
                                                return `${label}: ${formatTooltipValue(value)}`;
                                            }
                                        }
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            callback: formatYAxisLabel,
                                            font: {
                                                family: 'Kalimati, sans-serif',
                                                size: 11
                                            },
                                            color: '#555',
                                            stepSize: getOptimalStepSize(maxDataValue),
                                            maxTicksLimit: 6
                                        },
                                        title: {
                                            display: true,
                                            text: maxDataValue >= 1000 ? 'आवेदन संख्या (हजारमा)' : 'आवेदन संख्या',
                                            font: {
                                                family: 'Kalimati, sans-serif',
                                                size: 12,
                                                weight: 'bold'
                                            },
                                            color: '#333',
                                            padding: {
                                                top: 10,
                                                bottom: 10
                                            }
                                        },
                                        grid: {
                                            color: 'rgba(0, 0, 0, 0.05)',
                                            drawBorder: true,
                                            borderColor: '#ddd'
                                        },
                                        // Add grace to prevent bar from touching top
                                        grace: '10%',
                                        // Set max value with some padding
                                        suggestedMax: function() {
                                            const max = Math.ceil(maxDataValue * 1.1);
                                            return max;
                                        }
                                    },
                                    x: {
                                        ticks: {
                                            font: {
                                                family: 'Kalimati, sans-serif',
                                                size: 11
                                            },
                                            color: '#555',
                                            maxRotation: 45,
                                            minRotation: 0
                                        },
                                        title: {
                                            display: true,
                                            text: 'आवेदन प्रकार',
                                            font: {
                                                family: 'Kalimati, sans-serif',
                                                size: 12,
                                                weight: 'bold'
                                            },
                                            color: '#333',
                                            padding: {
                                                top: 10,
                                                bottom: 10
                                            }
                                        },
                                        grid: {
                                            display: false
                                        }
                                    }
                                },
                                animation: {
                                    duration: 1000,
                                    easing: 'easeOutQuart'
                                }
                            },
                            // Custom plugin to show data labels on bars with Nepali numerals
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

                                                // Convert to Nepali numerals
                                                const toNepaliNumeral = (num) => {
                                                    const nepaliDigits = ['०', '१', '२',
                                                        '३', '४', '५', '६', '७',
                                                        '८', '९'
                                                    ];
                                                    return num.toString().replace(/\d/g,
                                                        (digit) => nepaliDigits[
                                                            digit]);
                                                };

                                                ctx.fillStyle = '#000';
                                                const fontSize = 10;
                                                const fontStyle = 'bold';
                                                const fontFamily = 'Kalimati, sans-serif';
                                                ctx.font = Chart.helpers.fontString(
                                                    fontSize, fontStyle, fontFamily
                                                );
                                                ctx.textAlign = 'center';
                                                ctx.textBaseline = 'bottom';

                                                const padding = 5;
                                                const position = element.tooltipPosition();

                                                // Format number based on size
                                                let displayText;
                                                if (value >= 1000000) {
                                                    displayText = toNepaliNumeral((value /
                                                        1000000).toFixed(1)) + 'M';
                                                } else if (value >= 1000) {
                                                    displayText = toNepaliNumeral((value /
                                                        1000).toFixed(1)) + 'K';
                                                } else {
                                                    displayText = toNepaliNumeral(value);
                                                }

                                                // Draw text background for better readability
                                                const textWidth = ctx.measureText(
                                                    displayText).width;
                                                const textHeight = fontSize;
                                                ctx.fillStyle = 'rgba(255, 255, 255, 0.8)';
                                                ctx.fillRect(
                                                    position.x - textWidth / 2 - 3,
                                                    position.y - textHeight - padding -
                                                    3,
                                                    textWidth + 6,
                                                    textHeight + 6
                                                );

                                                // Draw border for background
                                                ctx.strokeStyle = 'rgba(0, 0, 0, 0.1)';
                                                ctx.lineWidth = 1;
                                                ctx.strokeRect(
                                                    position.x - textWidth / 2 - 3,
                                                    position.y - textHeight - padding -
                                                    3,
                                                    textWidth + 6,
                                                    textHeight + 6
                                                );

                                                // Draw text
                                                ctx.fillStyle = '#000';
                                                ctx.fillText(displayText, position.x,
                                                    position.y - padding);
                                            });
                                        }
                                    });
                                }
                            }]
                        });
                    });
                </script>
            @endpush

            <style>
                /* Optional: Add some custom styles for better appearance */
                .kalimati-font {
                    font-family: 'Kalimati', sans-serif;
                }

                .card {
                    border: 1px solid #e0e0e0;
                    border-radius: 8px;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
                }

                .card-title {
                    color: #2c3e50;
                    font-weight: 600;
                }

                .chart-container {
                    background-color: #fff;
                    border-radius: 4px;
                    padding: 10px;
                }
            </style>



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
