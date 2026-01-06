@extends('layouts.app')

@section('content')
    <style>
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
            text-align: center;
            vertical-align: middle;
        }

        .table td {
            vertical-align: middle;
        }

        .estimated-amount {
            font-weight: bold;
            color: #198754;
        }

        #totalEstimated,
        #totalSupplied {
            color: #0d6efd;
            font-size: 1.1em;
        }

        .supplied-amount:focus {
            border-color: #198754;
            box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
        }

        .form-check-input:checked {
            background-color: #198754;
            border-color: #198754;
        }

        .btn-success {
            background-color: #198754;
            border-color: #198754;
            padding: 10px 30px;
            font-weight: 600;
        }

        .btn-success:hover {
            background-color: #157347;
            border-color: #146c43;
        }

        .is-invalid {
            border-color: #dc3545 !important;
        }

        .kalimati-font {
            font-family: 'Kalimati', 'Preeti', 'Mangal', sans-serif;
            font-size: 16px;
        }
    </style>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-deep-blue text-dark">
                <h4 class="mb-0">वितरण फारम</h4>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('distributions.save') }}" id="distributionForm">
                    @csrf
                    <input type="hidden" name="decision_id" value="{{ $decision->id }}">

                    @csrf

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

                        <script src="https://nepalidatepicker.sajanmaharjan.com.np/v5/nepali.datepicker/js/nepali.datepicker.v5.0.6.min.js"
                            type="text/javascript"></script>
                        <script type="text/javascript">
                            window.onload = function() {
                                var mainInput = document.getElementById("nepali-datepicker");
                                mainInput.NepaliDatePicker();
                            };
                        </script>

                        <div class="col-md-4">
                            <label for="title" class="form-label">शीर्षक</label>
                            <input type="text" name="title" id="title" class="form-control kalimati-font"
                                value="{{ old('title') }}" placeholder="वितरणको शीर्षक प्रविष्ट गर्नुहोस्" required>
                            @error('title')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="upload" class="form-label">फाइल अपलोड</label>
                            <input type="file" name="upload" id="upload" class="form-control kalimati-font"
                                value="{{ old('upload') }}" required>
                            @error('upload')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>



                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="distributionTable">
                            <thead class="bg-light">
                                <tr>
                                    <th width="50">क्र.सं.</th>
                                    <th width="300">नाम थर</th>
                                    <th width="300">आनुमानित रकम</th>
                                    <th width="150">भुक्तानी गरिने रकम</th>
                                    <th width="200">कैफियत</th>
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

                                            <input type="number" name="patients[{{ $index }}][supplied_amount]"
                                                class="form-control  kalimati-font" value="{{ $sifarish->paying_amount }}"
                                                placeholder="रकम">
                                            @error("patients.{$index}.supplied_amount")
                                                <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </td>


                                        <td>
                                            <input type="text" name="patients[{{ $index }}][remark]"
                                                class="form-control kalimati-font" placeholder="कैफियत">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>जम्मा:</strong></td>
                                    <td colspan="2"><strong id="totalSupplied">रु 0.00</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>


                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fas fa-save"></i> सेभ गर्नुहोस्
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="window.history.back()">
                            <i class="fas fa-times"></i> रद्द गर्नुहोस्
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
