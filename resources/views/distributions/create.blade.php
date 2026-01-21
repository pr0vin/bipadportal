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
                                class="form-control kalimati-font"
                                value="{{ old('distributed_date', isset($distribution) ? $distribution->distributed_date->format('Y-m-d') : '') }}"
                                required>
                        </div>


                        <div class="col-md-3 mb-3">
                            <label>प्रकार</label>
                            <select name="type" id="type-select" class="form-control" required>
                                <option value="distribute" @selected(old('type', $distribution->type ?? '') === 'distribute')>वितरण</option>
                                <option value="receive" @selected(old('type', $distribution->type ?? '') === 'receive')>प्राप्त</option>
                                <option value="return" @selected(old('type', $distribution->type ?? '') === 'return')>फिर्ता</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3 type-distribute-receive">
                            <label>आवेदक (नाम / टोकन)</label>
                            <input list="patients-list" name="patient_display" id="patient-display"
                                class="form-control kalimati-font" autocomplete="off"
                                value="{{ old('patient_display', $distribution->patient->name ?? '') }}">

                            <datalist id="patients-list">
                                @foreach ($patients as $patient)
                                    <option
                                        value="{{ $patient->name }} ({{ $patient->onlineApplication->token_number ?? '' }})"
                                        data-id="{{ $patient->id }}">
                                        {{ $patient->name }}
                                    </option>
                                @endforeach
                            </datalist>

                            <input type="hidden" name="patient_id" id="patient-id"
                                value="{{ old('patient_id', $distribution->patient_id ?? '') }}">
                        </div>


                        <div class="col-md-3 mb-3 type-distribute-receive">
                            <label>संस्थाको नाम</label>
                            <input type="text" name="organization" class="form-control"
                                value="{{ old('organization', $distribution->organization_name ?? '') }}">
                        </div>


                        {{-- <div class="col-md-3 mb-3 type-return">
                            <label>पिडित</label>
                            <select name="return_patient_id" class="form-control">
                                <option value="">-- छान्नुहोस् --</option>
                                @foreach ($returnablePatients as $patient)
                                    <option value="{{ $patient->id }}">
                                        {{ $patient->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-3 mb-3 type-return">
                            <label>संस्था</label>
                            <select name="return_organization" class="form-control">
                                <option value="">-- छान्नुहोस् --</option>
                                @foreach ($returnableOrganizations as $org)
                                    <option value="{{ $org }}">{{ $org }}</option>
                                @endforeach
                            </select>
                        </div> --}}


                        <div class="col-md-3 mb-3 type-return">
                            <label>आवेदक (नाम / टोकन)</label>

                            <input type="text" id="return-patient-display" class="form-control" autocomplete="off"
                                placeholder="नाम वा टोकन लेख्नुहोस्">

                            <input type="hidden" name="return_patient_id" id="return-patient-id">

                            <div class="dropdown-menu " id="return-patient-dropdown">
                                @foreach ($returnablePatients as $patient)
                                    <div class="dropdown-item patient-option" data-id="{{ $patient->id }}">
                                        {{ $patient->name }}({{ $patient->onlineApplication->token_number ?? '' }})
                                    </div>
                                @endforeach
                            </div>
                        </div>


                        <div class="col-md-3 mb-3 type-return">
                            <label>संस्था</label>

                            <input type="text" id="return-org-display" class="form-control" autocomplete="off"
                                placeholder="संस्थाको नाम लेख्नुहोस्">

                            <input type="hidden" name="return_organization" id="return-org-name">

                            <div class="dropdown-menu  w-100" id="return-org-dropdown">

                                @foreach ($returnableOrganizations as $org)
                                    <div class="dropdown-item org-option">
                                        {{ $org }}
                                    </div>
                                @endforeach
                            </div>
                        </div>





                    </div>

                    <hr>

                    @php
                        $details = old('resources', isset($distribution) ? $distribution->details->toArray() : [[]]);
                    @endphp

                    <div class="resource-distribute-receive">

                        <div id="resource-container">
                            @foreach ($details as $i => $detail)
                                <div class="resource-row row mb-2">

                                    <div class="col-md-3">
                                        <label>सामाग्रीको नाम</label>
                                        <input list="resources-list"
                                            name="resources[{{ $i }}][resource_display]"
                                            class="form-control resource-display" autocomplete="off" required
                                            value="{{ old("resources.$i.resource_display", $detail['resource']['name'] ?? '') }}">

                                        <datalist id="resources-list">
                                            @foreach ($resources as $resource)
                                                <option value="{{ $resource->name }}" data-id="{{ $resource->id }}"
                                                    data-has-unit="{{ $resource->unit ? 1 : 0 }}"
                                                    data-unit="{{ $resource->unit?->name ?? '' }}">
                                                    {{ $resource->name }}
                                                    ({{ $resource->quantity }} {{ $resource->unit?->name }})
                                                </option>
                                            @endforeach
                                        </datalist>

                                        <input type="hidden" name="resources[{{ $i }}][resource_id]"
                                            class="resource-id"
                                            value="{{ old("resources.$i.resource_id", $detail['resource_id'] ?? '') }}">
                                    </div>

                                    <div class="col-md-2">
                                        <label>ईकाई</label>
                                        <input list="units-list" name="resources[{{ $i }}][unit]"
                                            class="form-control unit-input"
                                            value="{{ old("resources.$i.unit", $detail['resource']['unit']['name'] ?? '') }}">
                                    </div>

                                    <div class="col-md-2">
                                        <label>परिमाण</label>
                                        <input type="number" name="resources[{{ $i }}][quantity]"
                                            class="form-control" min="1" required
                                            value="{{ old("resources.$i.quantity", $detail['quantity'] ?? '') }}">
                                    </div>

                                    <div class="col-md-1 d-flex align-items-end">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="resources[{{ $i }}][is_checked]" value="1"
                                                {{ old("resources.$i.is_checked", $detail['returnable'] ?? false) ? 'checked' : '' }}>
                                            <label class="form-check-label">फिर्ता हुने</label>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label>कैफियत</label>
                                        <input type="text" name="resources[{{ $i }}][remark]"
                                            class="form-control"
                                            value="{{ old("resources.$i.remark", $detail['remark'] ?? '') }}">
                                    </div>

                                    <div class="col-md-1 d-flex align-items-end">
                                        <button type="button" class="btn btn-danger remove-row">✕</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="button" id="add-resource" class="btn btn-primary mt-2">
                            + अर्को सामाग्री थप्नुहोस्
                        </button>

                    </div>

                    {{-- <div class="resource-return">

                        <div class="resource-row row mb-2">
                            <div class="col-md-3">
                                <label>सामाग्रीको नाम</label>
                                <input type="text" name="resources[0][resource_id]" class="form-control resource-id">
                            </div>

                            <div class="col-md-2">
                                <label>ईकाई</label>
                                <input list="units-list" name="resources[0][unit]" class="form-control unit-input">
                            </div>

                            <div class="col-md-2">
                                <label>परिमाण</label>
                                <input type="number" name="resources[0][quantity]" class="form-control" min="1"
                                    required>
                            </div>

                            <div class="col-md-1 d-flex align-items-end">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="resources[0][is_checked]"
                                        value="1">
                                    <label class="form-check-label">फिर्ता हुने</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label>कैफियत</label>
                                <input type="text" name="resources[0][remark]" class="form-control">
                            </div>

                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger remove-row">✕</button>
                            </div>
                        </div>

                    </div> --}}

                    <div class="resource-return">
                        <div id="return-resource-container"></div>
                    </div>


                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <label>कैफियत</label>
                            <input type="text" name="remark" class="form-control"
                                value="{{ old('remark', $distribution->remark ?? '') }}">
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-success">पेस गर्नुहोस्</button>
                        <a href="{{ route('distributions.index') }}" class="btn btn-secondary">फर्किनुहोस्</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <link href="https://nepalidatepicker.sajanmaharjan.com.np/v5/nepali.datepicker/css/nepali.datepicker.v5.0.6.min.css"
        rel="stylesheet">
    <script src="https://nepalidatepicker.sajanmaharjan.com.np/v5/nepali.datepicker/js/nepali.datepicker.v5.0.6.min.js">
    </script>

    <script>
        window.onload = function() {
            document.getElementById("nepali-datepicker").NepaliDatePicker();
        };
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Patient selection functionality
            const patientInput = document.getElementById('patient-display');
            const patientIdInput = document.getElementById('patient-id');
            const datalistOptions = document.querySelectorAll('#patients-list option');

            patientInput.addEventListener('input', function() {
                const value = this.value.trim();
                let foundPatientId = '';

                // Find matching option
                datalistOptions.forEach(option => {
                    if (option.value === value) {
                        foundPatientId = option.getAttribute('data-id');
                    }
                });

                patientIdInput.value = foundPatientId;
            });

        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let index = {{ count($details) }};
            // Add resource row
            document.getElementById('add-resource').addEventListener('click', function() {
                const container = document.getElementById('resource-container');
                const firstRow = document.querySelector('.resource-row');
                const newRow = firstRow.cloneNode(true);

                // Clear all input values
                newRow.querySelectorAll('input').forEach(input => {
                    if (input.type === 'text' || input.type === 'number') {
                        input.value = '';
                    }
                    if (input.type === 'checkbox') {
                        input.checked = false;
                    }

                    // Update the name attribute with new index
                    const nameAttr = input.getAttribute('name');
                    if (nameAttr) {
                        input.setAttribute('name', nameAttr.replace(/\[\d+\]/, `[${index}]`));
                    }
                });

                container.appendChild(newRow);
                index++;
            });

            // Remove resource row
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-row')) {
                    const row = e.target.closest('.resource-row');
                    const totalRows = document.querySelectorAll('.resource-row').length;

                    if (totalRows > 1) {
                        row.remove();
                    } else {
                        alert('कम्तीमा एक सामाग्री हुनु पर्छ');
                    }
                }
            });

            // Resource selection and unit handling
            document.addEventListener('input', function(e) {
                if (e.target.classList.contains('resource-display')) {
                    const resourceInput = e.target;
                    const row = resourceInput.closest('.resource-row');
                    const resourceIdInput = row.querySelector('.resource-id');
                    const unitInput = row.querySelector('.unit-input');
                    const datalistOptions = document.querySelectorAll('#resources-list option');

                    const value = resourceInput.value.trim();
                    let foundResourceId = '';
                    let hasUnit = false;
                    let unitName = '';

                    // Find matching resource
                    datalistOptions.forEach(option => {
                        if (option.value === value) {
                            foundResourceId = option.getAttribute('data-id');
                            hasUnit = option.getAttribute('data-has-unit') === '1';
                            unitName = option.getAttribute('data-unit') || '';
                        }
                    });

                    // Set resource ID
                    resourceIdInput.value = foundResourceId;

                    // Handle unit input
                    if (foundResourceId && hasUnit && unitName) {
                        unitInput.value = unitName;
                        unitInput.setAttribute('readonly', true);
                    } else {
                        unitInput.value = '';
                        unitInput.removeAttribute('readonly');
                    }
                }
            });

            // Initialize unit fields on page load
            function initializeUnitFields() {
                document.querySelectorAll('.resource-display').forEach(input => {
                    const event = new Event('input');
                    input.dispatchEvent(event);
                });
            }

            initializeUnitFields();
        });
    </script>

    <script>
        document.addEventListener('input', function(e) {
            if (!e.target.classList.contains('resource-display')) return;

            const input = e.target;
            const row = input.closest('.row');
            const resourceIdInput = row.querySelector('.resource-id');
            const unitInput = row.querySelector('.unit-input');

            const resourcesList = document.getElementById('resources-list');
            const option = Array.from(resourcesList.options).find(opt => opt.value === input.value);

            if (option) {
                // Existing resource
                resourceIdInput.value = option.dataset.id;
                if (option.dataset.hasUnit === "1") {
                    unitInput.value = option.dataset.unit;
                    unitInput.readOnly = true;
                } else {
                    unitInput.readOnly = false;
                }
            } else {
                // New resource
                resourceIdInput.value = '';
                unitInput.readOnly = false;
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type-select');

            const distributeReceiveFields = document.querySelectorAll('.type-distribute-receive');
            const returnFields = document.querySelectorAll('.type-return');

            const distributeReceiveSection = document.querySelector('.resource-distribute-receive');
            const returnSection = document.querySelector('.resource-return');

            function toggleAll() {
                const type = typeSelect.value;

                if (type === 'return') {
                    // hide distribute/receive
                    distributeReceiveFields.forEach(el => el.style.display = 'none');
                    distributeReceiveSection.style.display = 'none';

                    //  disable inputs inside hidden section
                    distributeReceiveSection.querySelectorAll('input, select')
                        .forEach(el => {
                            el.disabled = true;
                            el.removeAttribute('required');
                        });

                    // show return
                    returnFields.forEach(el => el.style.display = 'block');
                    returnSection.style.display = 'block';

                    returnSection.querySelectorAll('input, select')
                        .forEach(el => el.disabled = false);
                } else {
                    // show distribute/receive
                    distributeReceiveFields.forEach(el => el.style.display = 'block');
                    distributeReceiveSection.style.display = 'block';

                    distributeReceiveSection.querySelectorAll('input, select')
                        .forEach(el => el.disabled = false);

                    // hide return
                    returnFields.forEach(el => el.style.display = 'none');
                    returnSection.style.display = 'none';

                    returnSection.querySelectorAll('input, select')
                        .forEach(el => el.disabled = true);
                }
            }


            toggleAll(); // Run on load
            typeSelect.addEventListener('change', toggleAll);
        });
    </script>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {

            const patientSelect = document.querySelector('.type-return select[name="return_patient_id"]');
            const orgSelect = document.querySelector('.type-return select[name="return_organization"]');
            const returnContainer = document.getElementById('return-resource-container');

            function fetchReturnableDetails() {
                const patientId = patientSelect.value;
                const organization = orgSelect.value;

                if (!patientId && !organization) {
                    returnContainer.innerHTML = '';
                    return;
                }

                const params = new URLSearchParams({
                    patient_id: patientId,
                    organization: organization
                });

                fetch(`/distributions/returnable-details?${params.toString()}`)
                    .then(res => res.json())
                    .then(data => {
                        returnContainer.innerHTML = '';

                        if (data.length === 0) {
                            returnContainer.innerHTML =
                                `<p class="text-danger">फिर्ता योग्य सामग्री भेटिएन।</p>`;
                            return;
                        }

                        data.forEach((detail, index) => {
                            const row = `
                        <div class="resource-row row mb-2">
                            <div class="col-md-3">
                                <label>सामाग्रीको नाम</label>
                                <input type="hidden" name="resources[${index}][resource_id]" value="${detail.resource.id}">
                                <input type="text" class="form-control" value="${detail.resource.name}" readonly>
                            </div>

                            <div class="col-md-2">
                                <label>ईकाई</label>
                                <input type="text" class="form-control" value="${detail.resource.unit?.name ?? ''}" readonly>
                            </div>

                            <div class="col-md-2">
                                <label>परिमाण</label>
                                <input type="number" name="resources[${index}][quantity]" class="form-control"
                                    value="${detail.quantity}" min="1" max="${detail.quantity}" required>
                            </div>

                            <div class="col-md-3">
                                <label>कैफियत</label>
                                <input type="text" name="resources[${index}][remark]" class="form-control">
                            </div>

                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-sm cancel-row">
                                    ✕ 
                                </button>
                            </div>
                        </div>
                    `;
                            returnContainer.insertAdjacentHTML('beforeend', row);
                        });
                    });
            }

            // Event delegation for cancel button
            returnContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('cancel-row')) {
                    e.target.closest('.resource-row').remove();
                }
            });

            patientSelect.addEventListener('change', fetchReturnableDetails);
            orgSelect.addEventListener('change', fetchReturnableDetails);
        });
    </script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const patientHidden = document.getElementById('return-patient-id');
            const orgHidden = document.getElementById('return-org-name');
            const returnContainer = document.getElementById('return-resource-container');

            function fetchReturnableDetails() {
                const patientId = patientHidden.value;
                const organization = orgHidden.value;

                if (!patientId && !organization) {
                    returnContainer.innerHTML = '';
                    return;
                }

                const params = new URLSearchParams({
                    patient_id: patientId,
                    organization: organization
                });

                fetch(`/distributions/returnable-details?${params.toString()}`)
                    .then(res => res.json())
                    .then(data => {
                        returnContainer.innerHTML = '';

                        if (!data.length) {
                            returnContainer.innerHTML =
                                `<p class="text-danger">फिर्ता योग्य सामग्री भेटिएन।</p>`;
                            return;
                        }

                        data.forEach((detail, index) => {
                            returnContainer.insertAdjacentHTML('beforeend', `
                        <div class="resource-row row mb-2">
                            <div class="col-md-3">
                                <label>सामाग्रीको नाम</label>
                                <input type="hidden"
                                       name="resources[${index}][resource_id]"
                                       value="${detail.resource.id}">
                                <input type="text"
                                       class="form-control"
                                       value="${detail.resource.name}"
                                       readonly>
                            </div>

                            <div class="col-md-2">
                                <label>ईकाई</label>
                                <input type="text"
                                       class="form-control"
                                       value="${detail.resource.unit?.name ?? ''}"
                                       readonly>
                            </div>

                            <div class="col-md-2">
                                <label>परिमाण</label>
                                <input type="number"
                                       name="resources[${index}][quantity]"
                                       class="form-control"
                                       min="1"
                                       max="${detail.quantity}"
                                       value="${detail.quantity}"
                                       required>
                            </div>

                            <div class="col-md-3">
                                <label>कैफियत</label>
                                <input type="text"
                                       name="resources[${index}][remark]"
                                       class="form-control">
                            </div>

                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button"
                                        class="btn btn-danger btn-sm cancel-row">
                                    ✕
                                </button>
                            </div>
                        </div>
                    `);
                        });
                    });
            }

            //  Trigger fetch when hidden values change
            patientHidden.addEventListener('change', fetchReturnableDetails);
            orgHidden.addEventListener('change', fetchReturnableDetails);

            //  Also observe value changes programmatically
            const observer = new MutationObserver(fetchReturnableDetails);
            observer.observe(patientHidden, {
                attributes: true,
                attributeFilter: ['value']
            });
            observer.observe(orgHidden, {
                attributes: true,
                attributeFilter: ['value']
            });

            // Remove row
            returnContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('cancel-row')) {
                    e.target.closest('.resource-row').remove();
                }
            });
            d

        });


        document.querySelectorAll('.patient-option').forEach(item => {
            item.addEventListener('click', function() {
                const name = this.innerText;
                const id = this.dataset.id;

                document.getElementById('return-patient-display').value = name;
                document.getElementById('return-patient-id').value = id;

                // 🔥 clear organization
                document.getElementById('return-org-display').value = '';
                document.getElementById('return-org-name').value = '';

                document.getElementById('return-patient-dropdown').classList.remove('show');

                fetchReturnableDetails();
            });
        });

        document.querySelectorAll('.org-option').forEach(item => {
            item.addEventListener('click', function() {
                const orgName = this.innerText;

                document.getElementById('return-org-display').value = orgName;
                document.getElementById('return-org-name').value = orgName;

                // 🔥 clear patient
                document.getElementById('return-patient-display').value = '';
                document.getElementById('return-patient-id').value = '';

                document.getElementById('return-org-dropdown').classList.remove('show');

                fetchReturnableDetails();
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ---------- PATIENT ----------
            const patientInput = document.getElementById('return-patient-display');
            const patientHidden = document.getElementById('return-patient-id');
            const patientDropdown = document.getElementById('return-patient-dropdown');
            const patientOptions = patientDropdown.querySelectorAll('.patient-option');

            patientInput.addEventListener('focus', () => patientDropdown.classList.add('show'));
            patientInput.addEventListener('input', () => {
                const val = patientInput.value.toLowerCase();
                patientOptions.forEach(opt => {
                    opt.style.display = opt.textContent.toLowerCase().includes(val) ? 'block' :
                        'none';
                });
            });

            patientOptions.forEach(opt => {
                opt.addEventListener('click', () => {
                    patientInput.value = opt.textContent.trim();
                    patientHidden.value = opt.dataset.id;
                    patientDropdown.classList.remove('show');
                });
            });

            // ---------- ORGANIZATION ----------
            const orgInput = document.getElementById('return-org-display');
            const orgHidden = document.getElementById('return-org-name');
            const orgDropdown = document.getElementById('return-org-dropdown');
            const orgOptions = orgDropdown.querySelectorAll('.org-option');

            orgInput.addEventListener('focus', () => orgDropdown.classList.add('show'));
            orgInput.addEventListener('input', () => {
                const val = orgInput.value.toLowerCase();
                orgOptions.forEach(opt => {
                    opt.style.display = opt.textContent.toLowerCase().includes(val) ? 'block' :
                        'none';
                });
                orgHidden.value = orgInput.value;
            });

            orgOptions.forEach(opt => {
                opt.addEventListener('click', () => {
                    orgInput.value = opt.textContent.trim();
                    orgHidden.value = opt.textContent.trim();
                    orgDropdown.classList.remove('show');
                });
            });

            // Hide dropdown on outside click
            document.addEventListener('click', e => {
                if (!e.target.closest('.type-return')) {
                    patientDropdown.classList.remove('show');
                    orgDropdown.classList.remove('show');
                }
            });

        });
    </script>

    <style>
        /* Common dropdown styling for return forms */
        .type-return .dropdown-menu {
            max-height: 300px;

            overflow-y: auto;

            overflow-x: hidden;
            width: 100%;
            padding: 0;
        }

        /* Allow long text to wrap */
        .type-return .dropdown-item {
            white-space: normal;
            /* important */
            word-break: break-word;
            cursor: pointer;
        }
    </style>
@endsection
