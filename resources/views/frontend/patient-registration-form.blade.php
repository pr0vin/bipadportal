@extends('layouts.frontend')

@section('breadcrumb')
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">ड्यासबोर्ड</a></li>
            <li class="breadcrumb-item"><a href="{{ route('frontent.apply') }}">सूची दर्ता</a></li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="container my-form">
        @include('alerts.all')
        <section>
            <div class="card mt-4">
                <div class="card-header bg-white">
                    <h5 class="font-weight-bold">नयाँ बिरामी दर्ता</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('patient.store') }}" method="POST" enctype="multipart/form-data"
                        onsubmit="checkExistData(event)">
                        @csrf
                        <h5 for="" class="font-weight-bold kalimati-font">१. बिरामी उपचार खर्च सूचीको लागि निवेदन
                            दिने व्यक्तिको विवरण :</h5>

                        <section class="mt-3">
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <label for="" class="required"> घटना <span class="text-danger">*</span></label>
                                    <select name="application_type_id" id="application_types" class="form-control" required>
                                        <option value="">घटना छान्नुहोस्</option>
                                        @foreach ($applicationTypes as $applicationType)
                                            <option value="{{ $applicationType->id }}">{{ $applicationType->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                {{-- <div class="col-md-4 mb-2">
                                    <label for="" class="required"> रोगको प्रकार <span
                                            class="text-danger">*</span></label>
                                    <select name="disease_id" id="disease_id" class="form-control" required>
                                        <option value="">रोगको प्रकार छान्नुहोस्</option>
                                    </select>
                                </div> --}}

                                <div class="col-md-4 col-sm-6 mb-2" style="position: relative;">
                                    <label class="required">प्रभाव <span class="text-danger">*</span></label>
                                    <input type="text" id="disease_selector" class="form-control"
                                        placeholder="प्रभाव छनौट गर्नुहोस्" readonly style="cursor: pointer;">

                                    <div id="disease_dropdown" class="border p-2 rounded mt-1 bg-white shadow"
                                        style=" display: none; max-height: 200px; overflow-y: auto; position: absolute; width: 100%; z-index: 9999;">
                                        @foreach ($diseases as $disease)
                                            <div class="form-check">
                                                <input class="form-check-input disease-checkbox" type="checkbox"
                                                    name="disease_id[]" value="{{ $disease->id }}"
                                                    id="disease_{{ $disease->id }}" {{ $loop->first ? 'required' : '' }}>

                                                <label class="form-check-label" for="disease_{{ $disease->id }}">
                                                    {{ $disease->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>

                                    <script>
                                        const selector = document.getElementById('disease_selector');
                                        const dropdown = document.getElementById('disease_dropdown');
                                        const checkboxes = document.querySelectorAll('.disease-checkbox');

                                        // Toggle dropdown
                                        selector.addEventListener('click', function() {
                                            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
                                        });

                                        // Update input text + handle required
                                        checkboxes.forEach(cb => {
                                            cb.addEventListener('change', function() {

                                                let selected = Array.from(document.querySelectorAll('.disease-checkbox:checked'))
                                                    .map(c => c.nextElementSibling.innerText)
                                                    .join(', ');

                                                selector.value = selected;

                                                if (document.querySelectorAll('.disease-checkbox:checked').length > 0) {
                                                    checkboxes.forEach(c => c.required = false);
                                                } else {
                                                    checkboxes[0].required = true;
                                                }
                                            });
                                        });

                                        // Close dropdown when clicking outside
                                        document.addEventListener('click', function(e) {
                                            if (!selector.contains(e.target) && !dropdown.contains(e.target)) {
                                                dropdown.style.display = 'none';
                                            }
                                        });
                                    </script>
                                </div>

                                <div class="col-md-4 mb-2">
                                    <label for="" class="required"> बिरामीको नाम (देवनागिरिमा) <span
                                            class="text-danger">*</span> </label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="" class="required"> बिरामीको नाम (in English) <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name_en" class="form-control" required>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="" class="required"> नागरिकता नं./जन्मदर्ता नं.<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="citizenship_number" id="citizenship_number"
                                        class="form-control kalimati-font" required>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <label for="" class="required"> जन्म मिति :<span class="text-danger">*
                                        </span>
                                    </label>
                                    <input type="text" name="dob" class="form-control kalimati-font date-picker"
                                        data-single="true" required readonly>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <label for="" class="required"> लिङ्ग <span class="text-danger">*</span></label>
                                    <select name="gender" id="" class="form-control" required>
                                        <option value="">छान्नुहोस्</option>
                                        <option value="Male">पुरुष</option>
                                        <option value="Female">महिला</option>
                                        <option value="Other">अन्य</option>
                                    </select>
                                </div>


                                <div class="col-md-4 mb-2">
                                    <label for="" class="required"> प्रदेश <span
                                            class="text-danger">*</span></label>
                                    <select name="province_id" id="province" class="form-control" required>
                                        <option value="">प्रदेश छान्नुहोस्</option>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->province }}">{{ $province->province }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="" class="required"> जिल्ला <span
                                            class="text-danger">*</span></label>
                                    <select name="district_id" id="district" class="form-control" required>
                                        <option value="">जिल्ला छान्नुहोस्</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="" class="required"> नगरपालिका <span
                                            class="text-danger">*</span></label>
                                    <select name="address_id" id="municipality" class="form-control" required>
                                        <option value="">नगरपालिका छान्नुहोस्</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="" class="required"> वडा नम्बर <span
                                            class="text-danger">*</span></label>
                                    <select name="ward_number" class="form-control kalimati-font js-example-basic-single"
                                        id="wardNumber" required>
                                        {{-- @foreach (App\Ward::all('id', 'name', 'name_en') as $item)
                                            <option value="{{ $item->name }}"
                                                {{ old('ward_number') == $item->name ? 'selected' : '' }}>
                                                {{ $item->name }}</option>
                                        @endforeach --}}
                                    </select>
                                    {{-- <input type="number" name="ward_number" class="form-control" required> --}}
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="" class="required"> गाउँ/टोल <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="tole" class="form-control" required>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="" class="required"> सम्पर्क व्यक्ति <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="contact_person" class="form-control" required>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="" class="required"> बिरामीसंगको नाता <span
                                            class="text-danger">*</span></label>
                                    <select name="relation_with_patients" class="form-control" id="">
                                        <option value="">नाता छान्नुहोस्</option>
                                        @foreach ($relations as $relation)
                                            <option value="{{ $relation->name }}">{{ $relation->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('relation_with_patients')
                                        <label class="text-danger">{{ $message }}</label>
                                    @enderror
                                    {{-- <input type="text" list="relationsList" name="relation_with_patients" class="form-control" required>
                                    <datalist id="relationsList">
                                        @foreach ($relations as $relation)
                                            <option value="{{ $relation->name }}">
                                        @endforeach
                                    </datalist> --}}
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="" class="required"> माेबाइल नंं. <span
                                            class="text-danger">*</span></label>
                                    <input type="number" name="mobile_number" id="mobile_number" min="1000000000"
                                        max="9999999999" title="Please enter a 10-digit mobile number"
                                        class="form-control kalimati-font" required>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="" class="required">इमेल </label>
                                    <input type="text" name="email" class="form-control">
                                </div>

                                <div class="col-md-4 mb-2">
                                    <label class="kalimati-font">आवेदन मिति</label>
                                    <input type="text" class="form-control date-picker kalimati-font" readonly
                                        name="applied_date" id="applied_date"
                                        value="{{ formatDate(ad_to_bs(now()->format('Y-m-d'))) }}" data-single="true">
                                </div>

                                <div class="col-md-4 mb-2">
                                    <label class="kalimati-font">क्षति मिति</label>
                                    <input type="text" class="form-control date-picker kalimati-font" readonly
                                        name="kshati_date" id="kshati_date"
                                        value="{{ formatDate(ad_to_bs(now()->format('Y-m-d'))) }}" data-single="true">
                                </div>
                            </div>

                        </section>

                         

                        {{-- <h5 class="font-weight-bold kalimati-font mt-3">२. आवेदन दर्ता हुनको लागि निम्न बमोजिमको प्रमाणपत्र
                            संलग्न गर्नु होला । :</h5>
                        <section class="mt-3">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label>अस्पतालको पुर्जाको फोटोकपी (Optional)</label>
                                    <input type="file" name="hospital_document" class="form-control" id="">
                                </div> 

                               <div class="col-md-6 mb-2">
                                    <label>रोग प्रमाणित कागजात (Optional)</label>
                                    <input type="file" name="disease_proved_document" class="form-control"
                                        id="">
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label>नागरिकता/ जन्मदर्ता / बसाइसराई कागजात / राष्ट्रिय परिचय पत्र (Optional)</label>
                                    <div class="col-md-">
                                         <input type="file" name="citizenship_card" class="form-control" id="">
                                    </div>
                                   
                                </div>
                            </div>
                        </section> --}}

                        <div class="m-0 p-0" id="documents_section">
                            <h5 class="font-weight-bold kalimati-font mt-3">३. आवेदन दर्ता हुनको लागि निम्न बमोजिमको
                                प्रमाण
                                संलग्न गर्नु होला । :</h5>
                            <section class="mt-3">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <div id="kshati_container">
                                            <label>क्षतिको फोटो (Optional)</label>
                                            <div class="file-input-group mb-2 d-flex align-items-center">
                                                <input type="file" name="kshati_document[]" class="form-control">
                                                <button type="button" class="btn btn-danger btn-sm ms-2 py-1"
                                                    onclick="removeFile(this)">X</button>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-sm btn-primary" onclick="addFile()">+
                                            अझै थप्नुहोस्</button>
                                        <script>
                                            function addFile() {
                                                let container = document.getElementById('kshati_container');

                                                let div = document.createElement('div');
                                                div.className = "file-input-group mb-2 d-flex align-items-center";

                                                div.innerHTML = `
                                                    <input type="file" name="kshati_document[]" class="form-control">
                                                    <button type="button" class="btn btn-danger btn-sm ms-2" onclick="removeFile(this)">X</button>
                                                `;

                                                container.appendChild(div);
                                            }

                                            function removeFile(btn) {
                                                btn.parentElement.remove();
                                            }
                                        </script>
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <label>नागरिकता/ जन्मदर्ता / बसाइसराई कागजात / राष्ट्रिय परिचय पत्र
                                            (Optional)</label>
                                        <div>
                                            <input type="file" name="citizenship_card" class="form-control"
                                                id="">

                                        </div>

                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-info">पेश गर्नुहाेस्</button>
                        </div>

                        <h5 class="font-weight-bold kalimati-font mt-3">३. विवरण :</h5>
                        <section class="mt-3">
                            <label>कैफियत </label>
                            <textarea name="description" class="form-control" id="" cols="30" rows="1"></textarea>
                        </section>
                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-info">पेश गर्नुहाेस्</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <div id="custom-confirm" style="display: none;">
        <div class="modal-content" style="width: 350px">
            <p id="confirm-message">यो नागरिकता नं./माेबाइल नंं. को विरामी दर्ता भइसकेको छ, पुनः दर्ता गर्न चाहनुहुन्छ ?
            </p>
            <div class="d-flex justify-content-center">
                <div class="d-block">
                    <button id="confirm-yes" class="btn btn-success">हुन्छ</button>
                    <button id="confirm-no" class="btn btn-danger">हुदैन</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.7.5/axios.min.js"></script>

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
                        const selectElement = $(
                            '#district');
                        selectElement.empty();
                        selectElement.append($('<option>', {
                            value: "",
                            text: "जिल्ला छान्नुहोस्"

                        }));
                        $.each(dataResult, function(index, item) {

                            selectElement.append($('<option>', {
                                value: item.district,
                                text: item.district

                            }));

                        });
                    }
                });
            })

            $("#district").on('change', function() {
                let id = $(this).val();
                var url = "{{ route('get.municipality', ':id') }}";
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
                            '#municipality');
                        selectElement.empty();
                        selectElement.append($('<option>', {
                            value: "",
                            text: "नगरपालिका छान्नुहोस्"

                        }));
                        $.each(dataResult, function(index, item) {

                            selectElement.append($('<option>', {
                                value: item.municipality,
                                text: item.municipality

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
            });

            document.getElementById('mobile_number').addEventListener('input', function(e) {
                let value = e.target.value;
                if (value.length > 10) {
                    e.target.value = value.slice(0, 10);
                }
            });

        })

        function checkExistData(e) {
            e.preventDefault();
            let citizenship_number = $('#citizenship_number').val();
            let mobile_number = $("#mobile_number").val();
            // let url="{{ route('checkData') }}?citizenship_number="+citizenship_number+"&mobile_number="mobile_number;
            let url = "{{ route('checkData') }}?citizenship_number=" + citizenship_number + "&mobile_number=" +
                mobile_number;

            axios.get(url).then((response) => {
                if (response.data.status) {
                    showCustomConfirm(
                        'यो नागरिकता नं./माेबाइल नंं. को विरामी दर्ता भइसकेको छ,  पुनः दर्ता गर्न चाहनुहुन्छ ?',
                        function(confirmed) {
                            if (confirmed) {
                                e.target.submit(); // Submit the form if the user confirms
                            }
                        });
                } else {
                    // If data doesn't exist, submit the form
                    e.target.submit();
                }
            })
            // confirm('Data already exist1')

        }

        function showCustomConfirm(message, callback) {
            // Set the message in the dialog
            document.getElementById('confirm-message').textContent = message;

            // Show the dialog
            document.getElementById('custom-confirm').style.display = 'flex';

            // Handle the "Yes" button click
            document.getElementById('confirm-yes').onclick = function() {
                document.getElementById('custom-confirm').style.display = 'none';
                callback(true); // Proceed with the action
            };

            // Handle the "No" button click
            document.getElementById('confirm-no').onclick = function() {
                document.getElementById('custom-confirm').style.display = 'none';
                callback(false); // Cancel the action
            };
        }
    </script>
@endpush
