{{-- @extends('layouts.app')

@section('content')

<div class="container">
    @include('alerts.all')
</div>

<div class="container">
    <x-organization-form :organization="$organization"></x-organization-form>
</div>

@endsection --}}
@php
    $address = App\Address::find(municipalityId());
@endphp
@extends('layouts.app')

@section('content')
    <div class="container-fluid my-form">
        @include('alerts.all')
        {{-- {{$wards}} --}}
        <section>
            <div class="card mt-4">
                <div class="card-header bg-white">
                    {{-- <h4 class="text-center font-weight-bold">{{App\Municipality::find(municipalityId())->name}}</h4> --}}
                    <h5 class="text-center font-weight-bold">{{ $patient->disease->name }}</h5>
                    <label class="col-12 text-center">{{ $patient->name }}</label>
                </div>
                <div class="card-body">
                    <form action="{{ route('patient.update', $patient) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <h5 for="" class="font-weight-bold kalimati-font">१. दिर्घरोगी उपचार खर्च सूचीको लागि निवेदन
                            दिने व्यक्तिको विवरण :</h5>
                        <section class="mt-3">
                            <div class="row">
                               <div class="col-md-4 col-sm-6 mb-2">
    <label for="" class="required"> घटनाको प्रकार <span class="text-danger">*</span></label>
    <select name="application_type_id" class="form-control" required>
        <option value="">छान्नुहोस्</option>
        @foreach ($applicationTypes as $applicationType)
            <option value="{{ $applicationType->id }}"
                {{ isset($patientApplication) && $patientApplication->application_type_id == $applicationType->id ? 'selected' : '' }}>
                {{ $applicationType->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="col-md-4 col-sm-6 mb-2" style="position: relative;">
    <label class="required">प्रकोप <span class="text-danger">*</span></label>

    <input type="text" id="disease_selector" class="form-control"
           placeholder="प्रकोप छनौट गर्नुहोस्" readonly style="cursor: pointer;">

    <div id="disease_dropdown"
         class="border p-2 rounded mt-1 bg-white shadow"
         style="display: none; max-height: 200px; overflow-y: auto; position: absolute; width: 100%; z-index: 9999;">

        @foreach ($diseases as $disease)
            <div class="form-check">
                <input class="form-check-input disease-checkbox"
                       type="checkbox"
                       name="disease_id[]"
                       value="{{ $disease->id }}"
                       id="disease_{{ $disease->id }}"
                       {{ in_array($disease->id, $selectedDiseaseIds ?? []) ? 'checked' : '' }}>

                <label class="form-check-label" for="disease_{{ $disease->id }}">
                    {{ $disease->name }}
                </label>
            </div>
        @endforeach
    </div>
</div>

<script>
const selector = document.getElementById('disease_selector');
const dropdown = document.getElementById('disease_dropdown');
const checkboxes = document.querySelectorAll('.disease-checkbox');

// Open/Close dropdown
selector.addEventListener('click', () => {
    dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
});

// Update selected names
function updateSelected() {
    let selected = Array.from(document.querySelectorAll('.disease-checkbox:checked'))
        .map(c => c.nextElementSibling.innerText.trim()) // trim spaces
        .join(', ');

    selector.value = selected;
}


// Initialize selected values on page load
updateSelected();

// Update on change
checkboxes.forEach(cb => cb.addEventListener('change', updateSelected));

// Click outside close
document.addEventListener('click', function(e) {
    if (!selector.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.style.display = 'none';
    }
});
</script>


                                {{-- <div class="col-md-4 mb-2">
                                <label for="" class="required"> आवेदनको प्रकार <span class="text-danger">*</span></label>
                                <select name="application_type_id" id="application_types" class="form-control" required multiple>
                                    <option value="">आवेदनको प्रकार छान्नुहोस्</option>


                                </select>
                            </div> --}}
                                <div class="col-md-4 mb-2">
                                    <label for="" class="required"> बिरामीको नाम (देवनागिरिमा) <span
                                            class="text-danger">*</span> </label>
                                    <input type="text" name="name" value="{{ old('name', $patient->name) }}"
                                        class="form-control" id="name_np" required>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="" class="required"> बिरामीको नाम (in English) <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name_en" value="{{ old('name_en', $patient->name_en) }}"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="" class="required"> नागरिकता नं. <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="citizenship_number"
                                        value="{{ old('citizenship_number', $patient->citizenship_number) }}"
                                        class="form-control kalimati-font" required>
                                </div>
                                {{-- <div class="col-md-2 mb-2">
                                    <label for="" class="required"> उमेर <span class="text-danger">*</span></label>
                                    <input type="number" name="age" value="{{ old('age', $patient->age) }}"
                                        class="form-control kalimati-font" required>
                                </div> --}}
                                <div class="col-md-2 col-sm-6 mb-2">
                                    <label for="" class="required"> जन्म मिति :<span class="text-danger">*
                                        </span>
                                    </label>
                                    <input type="text" name="dob" class="form-control kalimati-font date-picker"
                                        value="{{ old('dob', $patient->dob) }}" required readonly data-single="true">
                                </div>
                                <div class="col-md-2 mb-2">

                                    <label for="" class="required"> लिङ्ग <span class="text-danger">*</span></label>
                                    <select name="gender" id="" class="form-control" required>
                                        <option value="">लिङ्ग छान्नुहोस्</option>
                                        <option value="Male"
                                            {{ strtolower($patient->gender) == 'male' ? 'selected' : '' }}>पुरुष
                                        </option>
                                        <option value="Female"
                                            {{ strtolower($patient->gender) == 'female' ? 'selected' : '' }}>महिला
                                        </option>
                                        <option value="Other"
                                            {{ strtolower($patient->gender) == 'other' ? 'selected' : '' }}>अन्य</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-2">
                                    <label for="" class="required"> प्रदेश <span
                                            class="text-danger">*</span></label>
                                    <select name="province_id" id="province" class="form-control" required disabled>
                                        <option value="">प्रदेश छान्नुहोस्</option>

                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->province }}"
                                                {{ $patient->address->province == $province->province ? 'selected' : '' }}>
                                                {{ $province->province }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="" class="required"> जिल्ला <span
                                            class="text-danger">*</span></label>
                                    <select name="district_id" id="district" class="form-control" required disabled>
                                        <option value="">जिल्ला छान्नुहोस्</option>

                                        @foreach ($districts as $district)
                                            <option value="{{ $district->district }}"
                                                {{ $patient->address->district == $district->district ? 'selected' : '' }}>
                                                {{ $district->district }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="" class="required"> नगरपालिका <span
                                            class="text-danger">*</span></label>
                                    <select name="address_id" id="municipality" class="form-control" required disabled>
                                        <option value="">नगरपालिका छान्नुहोस्</option>

                                        @foreach ($municipalities as $municipalitie)
                                            <option value="{{ $municipalitie->municipality }}"
                                                {{ $patient->address->municipality == $municipalitie->municipality ? 'selected' : '' }}>
                                                {{ $municipalitie->municipality }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="" class="required"> वार्ड नम्बर <span
                                            class="text-danger">*</span></label>
                                    {{-- <input type="number" name="ward_number"
                                        value="{{ old('ward_number', $patient->ward_number) }}" class="form-control"
                                        required> --}}
                                    <select name="ward_number" class="form-control js-example-basic-single kalimati-font"
                                        id="wardNumber" required>
                                        @for ($item = 1; $item <= $address->total_ward_number; $item++)
                                            <option value="{{ $item }}"
                                                {{ old('ward_number', $patient->ward_number) == $item ? 'selected' : '' }}>
                                                वडा {{ $item }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="" class="required"> गाउँ/टोल <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="tole" value="{{ old('tole', $patient->tole) }}"
                                        class="form-control" required>
                                </div>
                                {{-- <div class="col-md-4 mb-2">
                                    <label for="" class="required"> सम्पर्क व्यक्ति <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="contact_person"
                                        value="{{ old('contact_person', $patient->contact_person) }}"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="" class="required"> बिरामीसंगको नाता <span
                                            class="text-danger">*</span></label>
                                    <select name="relation_with_patients" class="form-control" id="">
                                        <option value="">नाता छान्नुहोस्</option>
                                        @foreach ($relations as $relation)
                                            <option value="{{ $relation->name }}"
                                                {{ $patient->relation_with_patients == $relation->name ? 'selected' : '' }}>
                                                {{ $relation->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('relation_with_patients')
                                        <label class="text-danger">{{ $message }}</label>
                                    @enderror

                                </div> --}}
                                <div class="col-md-4 col-sm-6 mb-2">
                                    <label for="" class="required"> सम्पर्क व्यक्ति <span
                                            class="text-danger">*</span></label>
                                    <div class="d-flex mt-1">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="self" id="self"
                                                name="person" {{ $patient->relation_with_patients ? '' : 'checked' }}>
                                            <label class="form-check-label" for="self">
                                                आफै
                                            </label>
                                        </div>
                                        <div class="form-check ml-3">
                                            <input class="form-check-input" type="radio" value="other" id="other"
                                                name="person" {{ $patient->relation_with_patients ? 'checked' : '' }}>
                                            <label class="form-check-label" for="other">
                                                अन्य
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>सम्पर्क व्यक्तिको नाम</label>
                                    <input type="text" name="contact_person" class="form-control"
                                        id="contact_person_name"
                                        value="{{ old('contact_person', $patient->contact_person) }}" required
                                        {{ $patient->relation_with_patients ? '' : 'readonly' }}>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-2">
                                    <label for="" class="required"> बिरामीसंगको नाता <span
                                            class="text-danger">*</span></label>

                                    <select name="relation_with_patients" class="form-control" id="relation"
                                        {{ $patient->relation_with_patients ? '' : 'disabled' }} required>
                                        <option value="">नाता छान्नुहोस्</option>
                                        <option value="" selected>आफै</option>
                                        @foreach ($relations as $relation)
                                            <option value="{{ $relation->name }}">{{ $relation->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('relation_with_patients')
                                        <label class="text-danger">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label for="" class="required"> माेबाइल नंं. <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="mobile_number"
                                        value="{{ old('mobile_number', $patient->mobile_number) }}"
                                        class="form-control kalimati-font" required>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label for="" class="required">इमेल </label>
                                    <input type="text" name="email" value="{{ old('email', $patient->email) }}"
                                        class="form-control">
                                </div>
                            </div>
                        </section>
                        @php
                            $isAllDocuments = false;

                            if (
                                $patient->kshati_document &&
                                $patient->hospital_document &&
                                $patient->disease_proved_document &&
                                $patient->citizenship_card
                            ) {
                                $isAllDocuments = true;
                            }
                        @endphp
                        @if (!$isAllDocuments)
                            <h5 class="font-weight-bold kalimati-font mt-3">२. आवेदन दर्ता हुनको लागि निम्न बमोजिमको
                                प्रमाणपत्र
                                संलग्न गर्नु होला । :</h5>
                        @endif
                        <section class="mt-3">
                            <div class="row">
                                 @if (!$patient->kshati_document)
                                    <div class="col-md-6 mb-2">
                                        <label>क्षतिको फोटो(Optional)</label>
                                        <input type="file" name="kshati_document" class="form-control" id="">
                                    </div>
                                @endif

                                @if (!$patient->hospital_document)
                                    <div class="col-md-6 mb-2">
                                        <label>आस्पतालको पुर्जाको फोटोकपी (Optional)</label>
                                        <input type="file" name="hospital_document" class="form-control"
                                            id="">
                                    </div>
                                @endif

                                @if (!$patient->disease_proved_document)
                                    <div class="col-md-6 mb-2">
                                        <label>पिडित प्रमाणित कागजात (Optional)</label>
                                        <input type="file" name="disease_proved_document" class="form-control"
                                            id="">
                                    </div>
                                @endif

                                @if (!$patient->citizenship_card)
                                    <div class="col-md-6 mb-2">
                                        <label>नागरिकता/ जन्मदर्ता / बसाइसराई कागजात (Optional)</label>
                                        <input type="file" name="citizenship_card" class="form-control" id="">
                                    </div>
                                @endif

                            </div>
                        </section>
                    <h5 class="font-weight-bold kalimati-font mt-3">३. विवरण :</h5>
                        <div class="row">
                             <div class="col-md-4">
                            <label>आबेदन मिति</label>
                            <input type="text" class="form-control date-picker kalimati-font" readonly
                                value="{{ formatDate(ad_to_bs($patient->applied_date)) }}" name="applied_date"
                                data-single="true">
                        </div>

                      
                        <div class=" col-md-4">
                            <label>क्षति मिति</label>
                            <input type="text" class="form-control date-picker kalimati-font" readonly
                                value="{{ formatDate(($patient->kshati_date)) }}" name="kshati_date"
                                data-single="true">
                        </div>

                          <div class=" col-md-4">
                            <label>आनुमानित क्षति रकम (रू)</label>
                            <input type="text" class="form-control  kalimati-font" 
                                value="{{ old('estimated_amount', $patient->estimated_amount) }}" name="estimated_amount"
                                data-single="true">
                        </div>

                        </div>
                       
                        @if ($patient->registered_date)
                            <div class="form-group">
                                <label>{{ $patient->disease->id == 1 ? 'दर्ता ' : 'सिफारिस ' }}
                                    मिति</label>
                                <input type="text" class="form-control date-picker kalimati-font" readonly
                                    value="{{ $patient->registered_date }}" name="registered_date" data-single="true">
                            </div>

                            <div class="form-group">
                                <label>{{ $patient->disease->id == 1 ? 'दर्ता ' : 'सिफारिस ' }}
                                    नम्बर</label>
                                <input type="text" class="form-control kalimati-font"
                                    value="{{ $patient->reg_number }}" name="reg_number">
                            </div>
                        @endif
                        <section class="mt-3">
                            <label>कैफियत </label>
                            <textarea name="description" class="form-control" id="" cols="30" rows="1">{{ $patient->description }}</textarea>
                        </section>
                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-info">पेश गर्नुहाेस्</button>
                        </div>
                    </form>
                </div>
            </div>
            {{-- <suchi-form :suchi="{{ $suchi }}" :wards="{{ $wards }}" :suchi-types="{{ $suchiTypes }}"></suchi-form> --}}
        </section>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $("#province").on('change', function() {
                let id = $(this).val();
                var url = "{{ route('get.district', ':id') }}";
                url = url.replace(':id', id);

                $.ajax({
                    url: url,
                    type: "GET",
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    cache: false,
                    dataType: 'json',
                    success: function(dataResult) {
                        console.log(dataResult)
                        // location.reload();
                        const selectElement = $(
                            '#district');
                        selectElement.empty();
                        selectElement.append($('<option>', {
                            value: "",
                            text: "जिल्ला छान्नुहोस्"

                        }));
                        $.each(dataResult, function(index, item) {

                            selectElement.append($('<option>', {
                                value: item.district.id,
                                text: item.district.name

                            }));

                        });
                    }
                });
            })

            $("#district").on('change', function() {
                let id = $("#district").val();
                var url = "{{ route('get.municipality', ':id') }}";
                url = url.replace(':id', id);
                alert(url)
                $.ajax({
                    url: url,
                    type: "GET",
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    cache: false,
                    dataType: 'json',
                    success: function(dataResult) {
                        console.log(dataResult)
                        const selectElement = $(
                            '#municipality');
                        selectElement.empty();
                        selectElement.append($('<option>', {
                            value: "",
                            text: "नगरपालिका छान्नुहोस्"

                        }));
                        $.each(dataResult, function(index, item) {

                            selectElement.append($('<option>', {
                                value: item.municipality.id,
                                text: item.municipality.name

                            }));

                        });
                    }
                });
            })
            $("#municipality").on('change', function() {
                let id = $(this).val();
                var url = "{{ route('get.ward', ':id') }}";
                url = url.replace(':id', id);

                $.ajax({
                    url: url,
                    type: "GET",
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    cache: false,
                    dataType: 'json',
                    success: function(dataResult) {
                        let totalWard = dataResult.total_ward_number;
                        const selectElement = $(
                            '#wardNumber');
                        selectElement.empty();
                        selectElement.append($('<option>', {
                            value: "",
                            text: "वाड छान्नुहोस्"

                        }));
                        for (let wardNumber = 1; wardNumber <= totalWard; wardNumber++) {
                            console.log(
                                wardNumber); // This will print the ward number in the console
                            selectElement.append($('<option>', {
                                value: wardNumber,
                                text: `वडा  ${wardNumber}`
                            }));
                        }
                    }
                });
            })
            $("#application_types").on('change', function() {
                let id = $(this).val();
                var url = "{{ route('disease.getAll', ':id') }}";
                url = url.replace(':id', id);

                $.ajax({
                    url: url,
                    type: "GET",
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    cache: false,
                    dataType: 'json',
                    success: function(dataResult) {
                        const selectElement = $(
                            '#disease_id');
                        selectElement.empty();
                        selectElement.append($('<option>', {
                            value: "",
                            text: "रोग छान्नुहोस्"

                        }));
                        $.each(dataResult.diseases, function(index, item) {
                            console.log()
                            selectElement.append($('<option>', {
                                value: item.id,
                                text: item.name

                            }));

                        });
                    }
                });
            })
        })
    </script>

    <script>
        // Select both radio buttons
        const selfRadio = document.getElementById('self');
        const otherRadio = document.getElementById('other');
        const nameNp = document.getElementById('name_np');
        const contactPersonName = document.getElementById('contact_person_name');
        const relation = document.getElementById('relation');

        // Function to handle the change event
        function handleRadioChange() {
            if (selfRadio.checked) {
                contactPersonName.value = nameNp.value;
                contactPersonName.readOnly = true;

                var option = document.createElement("option");
                option.text = "आफै";
                option.value = "आफै";
                relation.appendChild(option);
                option.selected = true;
                relation.disabled = true;
                // relation.setAttribute('read')
            } else if (otherRadio.checked) {
                contactPersonName.readOnly = false;
                relation.disabled = false;

                const optionToRemove = Array.from(relation.options).find(opt => opt.value === "आफै");
                if (optionToRemove) {
                    relation.remove(optionToRemove.index);
                }
            }
        }

        // Attach the change event listener to both radio buttons
        selfRadio.addEventListener('change', handleRadioChange);
        otherRadio.addEventListener('change', handleRadioChange);

        nameNp.addEventListener('input', setName);

        function setName() {
            if (selfRadio.checked) {
                contactPersonName.value = nameNp.value;
            }
            // alert("Hello")
        }
    </script>
@endpush
