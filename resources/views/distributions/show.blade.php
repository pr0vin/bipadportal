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

            <!-- Printable Content -->
            <div id="printReport" class="m-0 p-0 kalimati-font">
                <h1 class="text-center" style="font-size:20px;">
                     @if ($distribution->type === 'distribute') वितरण
                        @elseif ($distribution->type === 'receive') प्राप्त
                        @elseif ($distribution->type === 'return') फिर्ता
                        @else अज्ञात
                        @endif
                    विवरण
                </h1>

                <div class="py-4">
                    <p class="text-end kalimati-font"><strong>मिति:</strong> {{ $distribution->distributed_date->format('Y-m-d') }}</p> 
                    <p>
                        <strong>आवेदक / संस्था:</strong>
                        {{ $distribution->patient->name ?? $distribution->organization_name ?? '—' }}
                    </p>

                    <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>सामाग्री</th>
                                <th>परिमाण</th>
                                <th>इकाई</th>
                                @if(in_array($distribution->type, ['distribute', 'return']))
                                    <th>स्थिति</th>
                                @endif
                                <th>कैफियत</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($distribution->details as $detail)
                                <tr>
                                    <td>{{ $detail->resource->name ?? '—' }}</td>
                                    <td class="kalimati-font">{{ $detail->quantity }}</td>
                                    <td>{{ $detail->resource->unit->name ?? '—' }}</td>
                                    @if(in_array($distribution->type, ['distribute', 'return']))
                                        <td>
                                            @if($detail->returnable === 1)
                                                <span class="badge bg-warning text-dark">फिर्ता पाउने</span>
                                            @elseif($detail->is_returned === 1)
                                                <span class="badge bg-success">फिर्ता भैसकेको</span>
                                            @elseif($detail->returnable === 0)
                                                <span class="badge bg-primary">वितरण भैसकेको</span>
                                            @endif
                                        </td>
                                    @endif
                                    <td>{{ $detail->remark }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($distribution->remark)
                        <p><strong>कैफियत:</strong> {{ $distribution->remark }}</p>
                    @endif
                </div>
            </div>

            <a href="{{ route('distributions.index') }}" class="btn btn-secondary mt-3 notPrintable">Back</a>
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
