@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-deep-blue text-dark">
            <h4 class="mb-0">वितरण फारम</h4>
        </div>

        <div class="card-body">
            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('distributions.save') }}">
                @csrf
                <input type="hidden" name="decision_id" value="{{ $decision->id }}">

                <div class="row mb-4">
                    <link
                        href="https://nepalidatepicker.sajanmaharjan.com.np/v5/nepali.datepicker/css/nepali.datepicker.v5.0.6.min.css"
                        rel="stylesheet" type="text/css" />
                    <div class="col-md-3 mb-3">
                        <label>मिति</label>
                        <input type="text" id="nepali-datepicker" name="distributed_date"
                            class="form-control kalimati-font"
                            value="{{ old('distributed_date', isset($distribution) ? optional($distribution->distributed_date)->format('Y-m-d') : '') }}"
                            required>
                    </div>

                    <script
                        src="https://nepalidatepicker.sajanmaharjan.com.np/v5/nepali.datepicker/js/nepali.datepicker.v5.0.6.min.js"
                        type="text/javascript"></script>
                    <script type="text/javascript">
                        window.onload = function () {
                            var mainInput = document.getElementById("nepali-datepicker");
                            mainInput.NepaliDatePicker();
                        };
                    </script>

                    <div class="col-md-4">
                        <label>शीर्षक</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>क्र.सं.</th>
                                <th>नाम</th>
                                <th>आनुमानित रकम</th>
                                <th>भुक्तानी रकम</th>
                                <th>कैफियत</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sifarishList as $index => $sifarish)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <strong>{{ $sifarish->patient->name }}</strong><br>
                                    {{ $sifarish->patient->mobile_number ?? '' }}
                                </td>
                                <td>{{ $sifarish->patient->estimated_amount ?? '' }}</td>
                                <td>
                                    <input type="hidden" name="patients[{{ $index }}][id]"
                                        value="{{ $sifarish->patient->id }}">
                                    <input type="number" name="patients[{{ $index }}][paid_amount]" class="form-control"
                                        value="{{ $sifarish->paying_amount }}">
                                </td>
                                <td>
                                    <input type="text" name="patients[{{ $index }}][remark]" class="form-control" value="{{ old('patients.' . $index . '.remark') }}">

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">सेभ गर्नुहोस्</button>
                    <button type="button" class="btn btn-secondary" onclick="window.history.back()">रद्द
                        गर्नुहोस्</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script
    src="https://nepalidatepicker.sajanmaharjan.com.np/v5/nepali.datepicker/js/nepali.datepicker.v5.0.6.min.js"></script>
<script>
    window.onload = function () {
        document.getElementById("nepali-datepicker").NepaliDatePicker();
    };
</script>
@endsection