@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card mb-4">
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

                    <div class="col-md-3 mb-3">
                        <label>मिति</label>
                        <input type="text" id="nepali-datepicker" name="distributed_date"
                               value="{{ old('distributed_date', $distribution->distributed_date ?? '') }}"
                               class="form-control kalimati-font" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>प्रकार</label>
                        <select name="type" id="type-select" class="form-control" required>
                            <option value="0" @selected(old('type', $distribution->type ?? '') == 0)>वितरण</option>
                            <option value="1" @selected(old('type', $distribution->type ?? '') == 1)>प्राप्त</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>आवेदक (नाम / टोकन)</label>
                        <input list="patients-list" name="patient_display"
                               value="{{ old('patient_display', $distribution->patient->name ?? '') }}"
                               class="form-control kalimati-font"
                               placeholder="नाम वा टोकन खोज्नुहोस्"
                               autocomplete="off">

                        <datalist id="patients-list">
                            @foreach ($patients as $patient)
                                <option value="{{ $patient->name }} ({{ $patient->onlineApplication->token_number ?? '' }})"
                                        data-id="{{ $patient->id }}"></option>
                            @endforeach
                        </datalist>

                        <input type="hidden" name="patient_id" id="patient-id"
                               value="{{ old('patient_id', $distribution->patient_id ?? '') }}">
                    </div>

                    <div class="col-md-3 mb-3" id="organization-wrapper">
                        <label>संस्थाको नाम</label>
                        <input type="text" name="organization"
                               value="{{ old('organization', $distribution->organization ?? '') }}"
                               class="form-control">
                    </div>
                </div>

                <hr>

                <h6>सामाग्री विवरण</h6>

                @php
                    $details = old('resources', isset($distribution) ? $distribution->details : [null]);
                @endphp

                <div id="resource-container">
                    @foreach ($details as $i => $detail)
                        <div class="resource-row row mb-2">

                            <div class="col-md-4">
                                <label>सामाग्री</label>
                                <input list="resources-list"
                                       name="resources[{{ $i }}][resource_display]"
                                       class="form-control resource-display"
                                       value="{{ old("resources.$i.resource_display", $detail?->resource?->name) }}"
                                       autocomplete="off" required>

                                <datalist id="resources-list">
                                    @foreach ($resources as $resource)
                                        <option value="{{ $resource->name }}"
                                                data-id="{{ $resource->id }}"
                                                data-has-unit="{{ $resource->unit ? 1 : 0 }}">
                                            {{ $resource->name }} ({{ $resource->quantity }}{{ $resource->unit ? ' ' . $resource->unit->name : '' }})
                                        </option>
                                    @endforeach
                                </datalist>

                                <input type="hidden"
                                       name="resources[{{ $i }}][resource_id]"
                                       class="resource-id"
                                       value="{{ old("resources.$i.resource_id", $detail?->resource_id) }}">
                            </div>

                            <div class="col-md-3 unit-wrapper">
                                <label>ईकाई</label>
                                <input type="text"
                                       name="resources[{{ $i }}][unit]"
                                       class="form-control unit-input"
                                       value="{{ old("resources.$i.unit", $detail?->unit) }}">
                            </div>

                            <div class="col-md-3">
                                <label>परिमाण</label>
                                <input type="number"
                                       name="resources[{{ $i }}][quantity]"
                                       min="1"
                                       class="form-control"
                                       value="{{ old("resources.$i.quantity", $detail?->quantity) }}"
                                       required>
                            </div>

                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" class="btn btn-danger remove-row">✕</button>
                            </div>

                        </div>
                    @endforeach
                </div>

                <button type="button" id="add-resource" class="btn btn-primary mt-2">
                    + अर्को सामाग्री थप्नुहोस्
                </button>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <label>कैफियत</label>
                        <input type="text" name="remark"
                               value="{{ old('remark', $distribution->remark ?? '') }}"
                               class="form-control">
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button class="btn btn-success">पेस गर्नुहोस्</button>
                    <a href="{{ route('distributions.index') }}" class="btn btn-secondary">फर्किनुहोस्</a>
                </div>

            </form>
        </div>
    </div>
</div>


<link href="https://nepalidatepicker.sajanmaharjan.com.np/v5/nepali.datepicker/css/nepali.datepicker.v5.0.6.min.css" rel="stylesheet">
<script src="https://nepalidatepicker.sajanmaharjan.com.np/v5/nepali.datepicker/js/nepali.datepicker.v5.0.6.min.js"></script>

<script>
window.onload = function () {
    document.getElementById("nepali-datepicker").NepaliDatePicker();
};
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const typeSelect = document.getElementById('type-select');
    const organizationWrapper = document.getElementById('organization-wrapper');
    const unitWrappers = document.querySelectorAll('.unit-wrapper');

    function toggleType() {
        if (typeSelect.value === '0') {
            organizationWrapper.style.display = 'none';
            unitWrappers.forEach(u => u.style.display = 'none');
        } else {
            organizationWrapper.style.display = 'block';
            unitWrappers.forEach(u => u.style.display = 'block');
        }
    }

    toggleType();
    typeSelect.addEventListener('change', toggleType);

    const patientInput = document.querySelector('[name="patient_display"]');
    const patientIdInput = document.getElementById('patient-id');

    patientInput.addEventListener('input', function () {
        const option = document.querySelector(`#patients-list option[value="${this.value}"]`);
        patientIdInput.value = option ? option.dataset.id : '';
    });
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {

    let index = {{ count($details) }};

    document.getElementById('add-resource').addEventListener('click', function () {
        const container = document.getElementById('resource-container');
        const row = document.querySelector('.resource-row').cloneNode(true);

        row.querySelectorAll('input').forEach(input => {
            input.value = '';
            input.name = input.name.replace(/\[\d+\]/, `[${index}]`);
            input.removeAttribute('readonly');
        });

        container.appendChild(row);
        index++;
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-row')) {
            e.target.closest('.resource-row').remove();
        }
    });

    document.addEventListener('input', function (e) {
        if (!e.target.classList.contains('resource-display')) return;

        const option = document.querySelector(`#resources-list option[value="${e.target.value}"]`);
        const row = e.target.closest('.resource-row');
        const idInput = row.querySelector('.resource-id');
        const unitInput = row.querySelector('.unit-input');

        if (option) {
            idInput.value = option.dataset.id;
            option.dataset.hasUnit == 1
                ? unitInput.setAttribute('readonly', true)
                : unitInput.removeAttribute('readonly');
        } else {
            idInput.value = '';
            unitInput.removeAttribute('readonly');
        }
    });
});
</script>

@endsection
