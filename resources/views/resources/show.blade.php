@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card z-depth-0 printableCard">
        <div class="card-body">

            <!-- Print Button -->
            <div class="d-flex justify-content-end mt-2 notPrintable">
                <button type="button" class="bg-transparent border-0 mr-2" id="report_print">
                    <i class="fa fa-print" aria-hidden="true"></i> Print
                </button>
            </div>

            <div class="my-3"></div>

            <!-- Printable Content -->
            <div id="printReport" class="m-0 p-0 kalimati-font">
                <h1 class="text-center" style="font-size:20px;">
                    सामाग्री टाइमलाइन: {{ $resource->name }}
                </h1>

                <div class="py-4">
                    <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>मिति</th>
                                <th>प्रकार</th>
                                <th>आवेदक / संस्था</th>
                                <th>मात्रा</th>
                                <th>इकाई</th>
                                <th>कैफियत</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($timeline as $item)
                                <tr>
                                    <td>{{ optional($item->distribution->distributed_date)->format('Y-m-d') }}</td>
                                    <td>
                                        @if($item->distribution->type === 'distribute')
                                            वितरण
                                        @elseif($item->distribution->type === 'receive')
                                            प्राप्त
                                        @elseif($item->distribution->type === 'return')
                                            फिर्ता
                                        @else
                                            अज्ञात
                                        @endif
                                    </td>
                                    <td>
                                        {{ $item->distribution->patient->name ?? $item->distribution->organization_name ?? '—' }}
                                    </td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->resource->unit->name ?? '—' }}</td>
                                    <td>{{ $item->remark ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        कुनै टाइमलाइन भेटिएन
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <a href="{{ route('resources.index') }}" class="btn btn-secondary mt-3 notPrintable">Back</a>
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
        .table-bordered th, .table-bordered td {
            border: 1px solid #000 !important;
        }
    }
</style>
@endpush

@endsection
