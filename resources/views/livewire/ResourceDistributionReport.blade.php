@extends('layouts.app')

@section('content')
    <div class="card z-depth-0 printableCard mx-2">
        <div class="card-body">
            <div class="notPrintable " style="margin-bottom: 60px;">
                <form method="GET" action="{{ url()->current() }}" class="row g-2 align-items-end">

                    <div class="col-md-3">
                        <label class="kalimati-font">आर्थिक वर्ष</label>
                        <select name="fiscal_year_id" class="form-control form-control-sm">
                            <option value="">-- सबै --</option>
                            @foreach (\App\FiscalYear::all() as $fy)
                                <option value="{{ $fy->id }}"
                                    {{ request('fiscal_year_id') == $fy->id ? 'selected' : '' }}>
                                    {{ $fy->name ?? $fy->start_ad . ' - ' . $fy->end_ad }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <link
                        href="https://nepalidatepicker.sajanmaharjan.com.np/v5/nepali.datepicker/css/nepali.datepicker.v5.0.6.min.css"
                        rel="stylesheet" />

                    <div class="col-md-3">
                        <label class="kalimati-font">वितरण मिति (देखि)</label>
                        <input type="text" name="from_date" id="nepali-datepicker-from"
                            class="form-control form-control-sm " value="{{ request('from_date') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="kalimati-font">वितरण मिति (सम्म)</label>
                        <input type="text" name="to_date" id="nepali-datepicker-to" class="form-control form-control-sm"
                            value="{{ request('to_date') }}">
                    </div>

                    <script src="https://nepalidatepicker.sajanmaharjan.com.np/v5/nepali.datepicker/js/nepali.datepicker.v5.0.6.min.js">
                    </script>

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            document.getElementById("nepali-datepicker-from").NepaliDatePicker({
                                dateFormat: "YYYY-MM-DD"
                            });

                            document.getElementById("nepali-datepicker-to").NepaliDatePicker({
                                dateFormat: "YYYY-MM-DD"
                            });
                        });
                    </script>

                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary ">
                            फिल्टर गर्नुहोस्
                        </button>

                        <a href="{{ url()->current() }}" class="btn btn-secondary ">
                            रिसेट
                        </a>
                    </div>

                </form>
            </div>


            <div class="d-flex justify-content-end mt-2 notPrintable">
                <button type="button" class="bg-transparent border-0 mr-2" id="report_print">
                    <i class="fa fa-print"></i> Print
                </button>

                @php
                    $fullUrl = request()->fullUrlWithQuery(['excel' => 1]);
                @endphp
                <a href="{{ $fullUrl }}">
                    <i class="fa fa-file-excel mr-1"></i> Excel
                </a>
            </div>


            <div id="printReport">

                <h1 style="font-size:20px" class="kalimati-font text-center mb-3">
                    राहत उद्धार सामग्रीहरुको विवरण
                </h1>

                <div class="py-4">
                    <table class="table table-bordered table-sm kalimati-font">
                        <thead class="font-noto">
                            <tr class="text-center" style="font-size: 11px">
                                <th style="width: 40px">क्र.स.</th>
                                <th>सामग्रीको नाम</th>
                                <th style="width: 120px">परिमाण</th>
                                <th>कैफियत</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($resourceDetails as $index => $item)
                                <tr style="font-size: 11px">
                                    <td class="text-center kalimati-font">
                                        {{ $index + 1 }}
                                    </td>

                                    <td class="text-center">
                                        {{ $item->resource->name ?? '-' }}
                                    </td>

                                    <td class="text-center kalimati-font">
                                        {{ $item->quantity }}
                                        {{ $item->resource->unit->name ?? '' }}
                                    </td>

                                    <td class="text-center">
                                        {{ $item->distribution->patient->name ?? '—' }}
                                        {{ $item->distribution->remark ? ' / ' . $item->distribution->remark : '' }}

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        कुनै पनि विवरण फेला परेन ।
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('report_print').addEventListener('click', function() {
                window.print();
            });
        </script>
    @endpush
@endsection
