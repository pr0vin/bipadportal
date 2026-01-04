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

        <div id="printReport">

            <h1 style="font-size:20px" class="kalimati-font text-center">
               राहत उद्धार सामग्रीहरुको विवरण
            </h1>

            <div class="py-4">
                <table class="table table-bordered table-sm kalimati-font">
                    <thead class="font-noto">
                        <tr class="text-center" style="font-size: 11px">
                            <th>क्र.स.</th>
                            {{-- <th>नामथर</th> --}}
                            <th>सामग्रीको नाम</th>
                            <th>परिमाण</th>
                            {{-- <th>प्रकार</th> --}}
                            {{-- <th>वितरण मिति</th> --}}
                            <th>कैफियत</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($resourceDetails as $index => $item)
                            <tr style="font-size: 11px">
                                <td class="text-center kalimati-font">{{ $index + 1 }}</td>

                                {{-- <td>
                                    {{ $item->patient->name ?? '-' }}
                                </td> --}}

                                <td class="text-center">
                                    {{ $item->resource->name ?? '-' }}
                                </td>

                                <td class="text-center kalimati-font">
                                    {{ $item->quantity }} {{ $item->resource->unit->name ?? '' }}
                                </td>

                                {{-- <td class="text-center">
                                    {{ $item->type ? 'प्राप्त' : 'वितरण' }}
                                </td> --}}

                                {{-- <td class="text-center">
                                    {{ $item->distributed_date }}
                                </td> --}}

                                <td class="text-center">
                                    {{ $item->remark ?? '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
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
