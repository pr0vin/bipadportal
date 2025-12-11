@extends('layouts.app')

@section('content')

<div class="card z-depth-0 printableCard">
    <div class="card-body">

        <div class="d-flex justify-content-end mt-2 notPrintable">
            <button type="button" class="bg-transparent border-0 mr-2" id="report_print">
                <i class="fa fa-print"></i> Print
            </button>

            @php
                $fullUrl = url()->full() . '&excel=1';
            @endphp

            <a href="{{ $fullUrl }}" class="bg-transparent border-0">
                <i class="fa fa-file-excel"></i> Excel
            </a>
        </div>

        <div id="printReport" class="m-0 p-0">

            <h1 style="font-size:20px" class="kalimati-font text-center">
                वितरण गरिएका राहतको विवरण:
            </h1>

            <div class="py-4">
                <table class="table table-bordered table-sm kalimati-font">
                    <thead class="font-noto">
                        <tr class="text-center" style="font-size: 11px">
                            <th class="text-center kalimati-font">क्र.स.</th>
                            <th class="text-center kalimati-font">नामथर</th>
                            <th class="text-center kalimati-font">वडा नं.</th>
                            <th class="text-center kalimati-font">सम्पर्क नं.</th>
                            <th class="text-center kalimati-font">क्षती भएको कारण</th>
                            <th class="text-center kalimati-font">क्षती मिति</th>
                            <th class="text-center kalimati-font">अनुमानित क्षतिकम</th>
                            <th class="text-center kalimati-font">प्रदान रकम</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($reliefDetails as $index => $item)
                            <tr style="font-size: 11px">
                                <td class="text-center kalimati-font">{{ $index + 1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td class="text-center kalimati-font">{{ $item->ward_number }}</td>
                                <td class="text-center kalimati-font">{{ $item->mobile_number }}</td>
                                <td class="text-center kalimati-font">{{ $item->description }}</td>
                                <td class="text-center kalimati-font">{{ $item->kshati_date }}</td>
                                <td class="text-center kalimati-font">{{ number_format($item->estimated_amount) }}</td>
                                <td class="text-center kalimati-font">{{ number_format($item->paid_amount) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center font-noto">
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
    $("#report_print").click(function () {
        window.print();
    });
</script>
@endpush
@endsection