@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="card">
            <div class="card-header bg-deep-blue text-dark">
                {{ isset($distribution) ? 'वितरण सम्पादन' : 'नयाँ वितरण' }}
            </div>

            <div class="card-body">
                <form method="POST"
                    action="{{ isset($distribution) ? route('distributions.update', $distribution) : route('distributions.store') }}">
                    @csrf
                    @isset($distribution)
                        @method('PUT')
                    @endisset

                    <div class="row">

                        <link
                            href="https://nepalidatepicker.sajanmaharjan.com.np/v5/nepali.datepicker/css/nepali.datepicker.v5.0.6.min.css"
                            rel="stylesheet" type="text/css" />
                        <div class="col-md-3 mb-3">
                            <label>मिति</label>
                            <input type="text" id="nepali-datepicker" name="distributed_date" class="form-control kalimati-font"
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

                        <div class="col-md-3 mb-3">
                            <label>आवेदक</label>
                            <input list="patients-list" name="patient_display" class="form-control kalimati-font"
                                placeholder="-- आवेदक छान्नुहोस् --" autocomplete="off"
                                value="{{ old('patient_display', isset($distribution) && $distribution->patient ? $distribution->patient->name . ' (ID: ' . $distribution->patient->reg_number . ')' : '') }}">
                            <datalist id="patients-list">
                                @foreach ($patients as $patient)
                                    <option value="{{ $patient->name }} ( {{ $patient->onlineApplication->token_number }})" data-id="{{ $patient->id }}">
                                        {{ $patient->name }} ( {{ $patient->onlineApplication->token_number }})
                                    </option>
                                @endforeach
                            </datalist>
                            <input type="hidden" name="patient_id" id="patient-id-input"
                                value="{{ old('patient_id', $distribution->patient_id ?? '') }}">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>सामाग्री</label>
                            <input list="resources-list" name="resource_display" class="form-control kalimati-font"
                                placeholder="-- सामाग्री छान्नुहोस् --" required autocomplete="off"
                                value="{{ old('resource_display', isset($distribution) && $distribution->resource ? $distribution->resource->name . ' (स्टक: ' . $distribution->resource->quantity . ')' : '') }}">
                            <datalist id="resources-list">
                                @foreach ($resources as $resource)
                                    <option value="{{ $resource->name }} (स्टक: {{ $resource->quantity }})"
                                        data-id="{{ $resource->id }}">
                                        {{ $resource->name }} (स्टक: {{ $resource->quantity }})
                                    </option>
                                @endforeach
                            </datalist>
                            <input type="hidden" name="resource_id" id="resource-id-input"
                                value="{{ old('resource_id', $distribution->resource_id ?? '') }}">
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                // For patients
                                const patientDisplayInput = document.querySelector('input[name="patient_display"]');
                                const patientIdInput = document.getElementById('patient-id-input');

                                // Set initial value based on hidden input on page load
                                if (patientIdInput.value) {
                                    // Find the corresponding option and set display value
                                    const patientOption = document.querySelector('#patients-list option[data-id="' + patientIdInput
                                        .value + '"]');
                                    if (patientOption) {
                                        patientDisplayInput.value = patientOption.value;
                                    }
                                }

                                patientDisplayInput.addEventListener('input', function() {
                                    const selectedOption = document.querySelector('#patients-list option[value="' + this.value +
                                        '"]');
                                    if (selectedOption) {
                                        patientIdInput.value = selectedOption.getAttribute('data-id');
                                    } else {
                                        patientIdInput.value = '';
                                    }
                                });

                                // For resources
                                const resourceDisplayInput = document.querySelector('input[name="resource_display"]');
                                const resourceIdInput = document.getElementById('resource-id-input');

                                // Set initial value based on hidden input on page load
                                if (resourceIdInput.value) {
                                    // Find the corresponding option and set display value
                                    const resourceOption = document.querySelector('#resources-list option[data-id="' + resourceIdInput
                                        .value + '"]');
                                    if (resourceOption) {
                                        resourceDisplayInput.value = resourceOption.value;
                                    }
                                }

                                resourceDisplayInput.addEventListener('input', function() {
                                    const selectedOption = document.querySelector('#resources-list option[value="' + this
                                        .value + '"]');
                                    if (selectedOption) {
                                        resourceIdInput.value = selectedOption.getAttribute('data-id');
                                    } else {
                                        resourceIdInput.value = '';
                                    }
                                });

                                // Also handle when user selects from dropdown
                                patientDisplayInput.addEventListener('change', function() {
                                    const selectedOption = document.querySelector('#patients-list option[value="' + this.value +
                                        '"]');
                                    if (selectedOption) {
                                        patientIdInput.value = selectedOption.getAttribute('data-id');
                                    }
                                });

                                resourceDisplayInput.addEventListener('change', function() {
                                    const selectedOption = document.querySelector('#resources-list option[value="' + this
                                        .value + '"]');
                                    if (selectedOption) {
                                        resourceIdInput.value = selectedOption.getAttribute('data-id');
                                    }
                                });
                            });
                        </script>

                        <div class="col-md-3 mb-3">
                            <label>प्रकार</label>
                            <select name="type" class="form-control" required>

                                <option value="0"
                                    {{ old('type', $distribution->type ?? '') === 0 ? 'selected' : '' }}>
                                    वितरण
                                </option>
                                <option value="1" {{ old('type', $distribution->type ?? '') == 1 ? 'selected' : '' }}>
                                    प्राप्त
                                </option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>परिमाण</label>
                            <input type="number" name="quantity" min="1" class="form-control kalimati-font"
                                value="{{ old('quantity', $distribution->quantity ?? '') }}" required>
                            @error('quantity')
                                <span class="text-danger " style="font-size:12px">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-5">
                            <label>कैफियत</label>
                            <input type="text" name="remark" value="{{ old('remark', $distribution->remark ?? '') }}" class="form-control" rows="2">
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button class="btn btn-success">
                            {{ isset($distribution) ? 'अपडेट गर्नुहोस्' : 'पेस गर्नुहोस्' }}
                        </button>

                        <a href="{{ route('distributions.index') }}" class="btn btn-secondary">
                            फर्किनुहोस्
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
