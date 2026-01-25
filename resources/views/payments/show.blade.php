@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="card z-depth-0 printableCard">
            <div class="card-body">

                <!-- Print / Export Buttons -->
                <div class="d-flex justify-content-end mt-2 notPrintable">
                    <button type="button" class="bg-transparent border-0 mr-2" id="report_print">
                        <i class="fa fa-print" aria-hidden="true"></i> Print
                    </button>
                </div>

                <div class="my-3"></div>


                <div id="printReport" class="m-0 p-0 kalimati-font">
                    <div class="py-4">
                        <h4 class="text-center kalimati-font mb-5">
                            भुक्तानी विवरण तालिका
                        </h4>
                        <table class="table table-bordered table-sm mt-3">
                            <thead class="table-light">
                                <tr>
                                    <th>क्रम</th>
                                    <th>भुक्तानी मिति</th>
                                    <th>पिडितको नाम</th>
                                    <th>बैंक</th>
                                    <th>खाता नं</th>
                                    <th>भुक्तानी रकम</th>
                                    <th>कैफियत</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payment->paymentDetails as $key => $detail)
                                    <tr>
                                        <td class="kalimati-font">{{ $key + 1 }}</td>

                                        <td  class="kalimati-font">{{ optional($payment->paid_date)->format('Y-m-d') }}</td>

                                        <td class="kalimati-font">{{ $detail->patient->name ?? '—' }}
                                            <div class="kalimati-font">
                                                {{ $detail->patient->mobile_number ?? '—' }}
                                            </div>
                                        </td>

                                        <td>{{ $detail->patient->bank_name ?? '—' }}</td>


                                        <td class="kalimati-font">{{ $detail->patient->bank_account_number ?? '—' }}</td>


                                        <td class=" kalimati-font">
                                            {{ number_format($detail->paid_amount, 2) }}
                                        </td>


                                        <td class="kalimati-font">{{ $detail->remark ?? '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <a href="{{ route('payments.index') }}" class="btn btn-secondary mt-3 notPrintable">Back</a>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const printBtn = document.getElementById('report_print');
                printBtn.addEventListener('click', function() {
                    window.print();
                });
            });
        </script>
    @endpush


    @push('styles')
        <style>
            @media print {
                .notPrintable {
                    display: none !important;
                }

                body {
                    -webkit-print-color-adjust: exact;
                }

                .table-bordered th,
                .table-bordered td {
                    border: 1px solid #000 !important;
                }
            }
        </style>
    @endpush
@endsection
