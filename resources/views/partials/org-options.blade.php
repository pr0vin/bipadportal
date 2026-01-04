<style>
    .nav-link1 {
        box-shadow: none !important;
        background-color: #F2F7FB;
        font-weight: bold;
    }

    .nav-link1.active {
        background-color: #1C4267 !important;
    }

    .nav-link1:hover {
        background-color: #1C4267 !important;
        color: #fff;
    }

    .my-btn {
        padding: 20px;
        background-color: #F2F7FB !important;
        box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px !important;
        display: flex;
        align-items: center;
        font-size: 20px;
        font-weight: bold;
    }

    .circle {
        height: 35px;
        width: 35px;
        border-radius: 50%;

    }

    input[type="number"] {
        font-family: kalimati-font !important;
    }

    .myFont {
        font-family: 'kalimati-font' !important;
    }
</style>
@php
    $isAllDocument = false;
@endphp
@php
    $applicationType = $patient->disease->id;
    $isBankEnabled = false;
@endphp

@if ($errors->any())
    @push('myScript')
        <script>
            $("#exampleModalCenter").modal('show')
        </script>
    @endpush
@endif
<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item col-6" role="presentation">
        <button class="btn col-12 py-4 nav-link nav-link1  active" id="pills-home-tab" data-bs-toggle="pill"
            data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
            aria-selected="true">मुख्य</button>
    </li>
    <li class="nav-item col-6 " role="presentation">
        <button class="btn nav-link nav-link1 py-4 col-12" id="pills-profile-tab" data-bs-toggle="pill"
            data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
            aria-selected="false">चिठीपत्र</button>
    </li>

</ul>
<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show px-3 active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
        <div class="d-flex">

            <a href="{{ route('patient.edit', $patient) }}" class="btn my-btn">
                <i class="fas fa-edit pr-3"></i>
                सम्पादन</a>

            @if (!$patient->isRecommended)
                <button type="button" class="btn my-btn" id="registerModal" data-toggle="modal"
                    data-target="#exampleModalCenter">
                    <i class="fas fa-plus pr-3"></i>
                    दर्ता गर्नुहोस
                </button>
            @endif

            @if ($patient->registered_date)
                <button type="button" class="btn my-btn" data-toggle="modal" data-target="#reApply">
                    <i class="fas fa-retweet pr-3"></i> पुनः आबेदन गर्नुहोस
                </button>
            @endif

            @if ($patient->registered_date)
                <button type="button" class="btn bg-info text-white" data-toggle="modal"
                    data-target="#paymentModal-{{ $patient->id }}">
                    <i class="fas fa-plus pr-3"></i>
                    भुक्तानी विवरण
                </button>
            @endif
        </div>
    </div>
    <div class="tab-pane fade px-3" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
        <div class="d-flex">

            <a href="{{ route('suchi-print-application', $patient) }}" class="btn my-btn" type="button" id="">
                <i class="fas fa-print pr-3"></i>Print token letter
            </a>

            <a href="{{ route('schedule.one', $patient) }}" class="btn my-btn" type="button" id="">
                <i class="fas fa-file pr-3"></i>अनुसूची १
            </a>
            <a href="{{ route('schedule.two', $patient) }}" class="btn my-btn" type="button" id="">
                <i class="fas fa-file pr-3"></i>अनुसूची २
            </a>
        </div>
    </div>
</div>


<div class="d-flex">
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        {{ $patient->disease->id == 1 ? 'दर्ता ' : 'सिफारिस ' }} गर्नुहोस /
                        कागजात थप्नुहोस
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form enctype="multipart/form-data" method="POST" id="RegForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" value="{{ $patient->disease->id }}" name="application_type_id">
                        <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                        <div class="row">
                            @can('dirgha.register')
                                <div class="col-12">
                                    <div class="form-group mx-0 px-0 col-12">
                                        <label for="">क)

                                            दर्ता मिति</label>
                                        <input type="text" name="date_from" id="input-date-from" data-single="true"
                                            class="form-control nepali-date rounded-0 kalimati-font"
                                            value="{{ $patient->date_from ? ad_to_bs($patient->date_from) : '' }}">
                                        @error('registered_date')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mx-0 px-0 col-12">
                                        <label for="">ख)

                                            दर्ता नम्बर</label>
                                        <div class="d-flex">
                                            <input type="text" name="registration_number"
                                                class="form-control rounded-0 kalimati-font" style="width: 100px"
                                                value="{{ $registrationNumber }}" readonly>
                                            <input type="text" name="reg_number"
                                                class="form-control rounded-0 kalimati-font"
                                                value="{{ $patient->reg_number ?? '' }}">
                                        </div>
                                        @error('registration_number')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>


                                @php
                                    $isBankEnabled = true;
                                @endphp
                                <div class="col-12">
                                    <div class="form-group">

                                        <label for="">ग) बैंक खाता नम्बर</label>
                                        <input type="text" name="bank_account_number" id="bank_account_number"
                                            class="form-control rounded-0 kalimati-font"
                                            value="{{ old('bank_account_number', $patient->bank_account_number) }}"
                                            oninput="bankAccountNumberChange()">
                                        @error('bank_account_number')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                        <input type="hidden" name="yearly_payment" class="form-control rounded-0"
                                            value="{{ $patient->disease->amount }}">
                                    </div>
                                </div>

                                <div class="col-12">

                                    <label class="" id="kagjat">{{ $isBankEnabled ? 'घ' : 'ग' }}) कागजातहरु
                                        :</label> <br>
                                </div>
                            @endcan
                            @can('application')
                                @if (!$patient->application)
                                    <div class="col-md-6 mb-2">
                                        <label>निबेदन</label>
                                        <input type="file" name="application" class="form-control dirgha"
                                            id="" onchange="applicationChange(event)">
                                        @error('application')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                @endif
                            @endcan


                            @can('doctor_recomandation')


                                @can('bank_cheque')
                                    @if (!$patient->bank_cheque)
                                        <div class="col-md-6 mb-2">
                                            <label>बैंक चेक बुक</label>
                                            <input type="file" name="bank_cheque" class="form-control dirgha"
                                                id="" onchange="bankchequeChange(event)">
                                            @error('bank_cheque')
                                                <label class="text-danger">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    @endif
                                @endcan
                                @endif

                                @can('citizenship_card')

                                    @if (!$patient->citizenship_card)
                                        <div class="col-md-12 mb-2">
                                            <label>नागरिकता/ जन्मदर्ता / बसाइसराई कागजात / राष्ट्रिय परिचय पत्र</label>
                                            <input type="file" name="citizenship_card" class="form-control"
                                                id="" onchange="citizenshipCardChange(event)">
                                            @error('citizenship_card')
                                                <label class="text-danger">{{ $message }}</label>
                                            @enderror
                                        </div>
                                    @endif
                                @endcan
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">रद्द गर्नुहोस</button>
                            @if ($patient->hospital_document && $patient->disease_proved_document && $patient->citizenship_card)
                                @php
                                    $isAllDocument = true;
                                @endphp
                            @endif
                            <button type="button" onclick="registerDoc({{ $patient->id }})"
                                class="btn btn-primary btnRegister" id="btnRegister" style="width: 200px">
                                {{ 'दर्ता' }}
                                गर्नुहोस</button>
                            <button type="button" style="width: 100px" onclick="docUpload({{ $patient->id }})"
                                class="btn btn-primary">ड्राफ्ट</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">दर्ता गर्नुहोस</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('patient.registration', $patient) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">दर्ता मिति</label>
                                <input type="text" name="registered_date" id="nepali-datepicker"
                                    class="form-control  rounded-0" placeholder="yyyy-mm-dd" readonly
                                    value="{{ ad_to_bs(now()->format('Y-m-d')) }}">
                            </div>

                            <div class="form-group">
                                <label for="">दर्ता नम्बर</label>
                                <input type="number" name="registration_number" class="form-control" required>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        {{-- Re-apply --}}
        <div class="modal fade" id="reApply" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">पुनः आबेदन गर्नुहोस</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('reApply') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            @php
                                $applicationTypes = App\ApplicationType::latest()->get();
                            @endphp
                            <div class="form-group">
                                <label>आबेदन मिति</label>
                                <input type="text" class="form-control date-picker kalimati-font" readonly
                                    value="{{ formatDate(ad_to_bs(now()->format('Y-m-d'))) }}" name="applied_date"
                                    id="applied_date" data-single="true">
                            </div>

                            <div class="col-sm-12 mb-2 p-0">
                                <input type="hidden" value="{{ $patient->id }}" name="patient_id">
                                <label for="" class="required"> आवेदनको प्रकार <span
                                        class="text-danger">*</span></label>

                                <select name="application_type_id" id="application_types" class="form-control" required>
                                    <option value="">आवेदनको प्रकार छान्नुहोस्</option>
                                    @foreach ($applicationTypes as $applicationType)
                                        @if ($applicationType->id == 1)
                                            @can('dirgha.create')
                                                <option value="{{ $applicationType->id }}">{{ $applicationType->name }}
                                                </option>
                                            @endcan
                                        @endif
                                        @if ($applicationType->id == 2)
                                            @can('bipanna.create')
                                                <option value="{{ $applicationType->id }}">{{ $applicationType->name }}
                                                </option>
                                            @endcan
                                        @endif
                                        @if ($applicationType->id == 3)
                                            @can('samajik.create')
                                                <option value="{{ $applicationType->id }}">{{ $applicationType->name }}
                                                </option>
                                            @endcan
                                        @endif

                                        @if ($applicationType->id == 4)
                                            @can('nagarpalika.create')
                                                <option value="{{ $applicationType->id }}">
                                                    {{ $applicationType->name }}
                                                </option>
                                            @endcan
                                        @endif
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-sm-12 mb-2 p-0">
                                <label for="" class="required"> घटनाको प्रकार <span
                                        class="text-danger">*</span></label>
                                <select name="disease_id" id="disease_id" class="form-control" required>
                                    <option value="">घटनाको प्रकार छान्नुहोस्</option>

                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">रद्द गर्नुहोस</button>
                            <button type="submit" class="btn btn-primary" style="width: 150px">आबेदन गर्नुहोस</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="modal fade" id="paymentModal-{{ $patient->id }}" tabindex="-1" role="dialog"
            aria-labelledby="paymentModalTitle-{{ $patient->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action="{{ route('patients.updatePayment', $patient->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="paymentModalTitle-{{ $patient->id }}" style="font-weight:bold">
                                भुक्तानी विवरण
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="paid_amount-{{ $patient->id }}">भुक्तानी रकम :</label>
                                <input type="text" name="paid_amount" id="paid_amount-{{ $patient->id }}"
                                    class="form-control kalimati-font" step="0.01"
                                    value="{{ $patient->paid_amount ?? '' }}" required>
                            </div>

                            <div class="form-group">
                                <label for="paid_date-{{ $patient->id }}">भुक्तानी मिति :</label>
                                <input type="text" name="paid_date" id="paid_date-{{ $patient->id }}"
                                    class="form-control date-picker kalimati-font"
                                    value="{{ formatDate(ad_to_bs(now()->format('Y-m-d'))) }}" data-single="true"
                                    readonly required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">रद्द गर्नुहोस्</button>
                            <button type="submit" class="btn btn-primary" style="width: 150px">सेभ गर्नुहोस्</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.7.3/axios.min.js"></script>
    <script>
        $("#select_hospital_name").on('change', () => {
            let id = $("#select_hospital_name").val();
            let urlTemplate =
                "{{ route('hospital.getDisease', ':id') }}"; // Ensure this is properly outputted by your template engine
            let url = urlTemplate.replace(':id', id);
            axios.get(url).then((response) => {
                $("#txtDeases").val(response.data.diseases)
                $("#txtDeases").removeClass('d-none')
            })
        });

        $("#doc_upload").on('click', () => {

        })
    </script>
    @push('myScript')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.7.7/axios.min.js"></script>
        <script>
            function registerDoc(id) {
                let action = "{{ route('patient.recommendation') }}";
                const form = document.getElementById('RegForm');
                form.action = action;
                form.submit();
                // alert(id);
            }

            function docUpload(id) {
                let action = "{{ route('documentUpload', ':id') }}".replace(':id', id);
                const form = document.getElementById('RegForm');
                form.action = action;
                form.submit();
            }

            let data = [];
            fetchPatientData()

            function fetchPatientData() {
                let patient = @json($patient);
                // if (patient.disease.application_types[0].id == 1) {
                if (patient.bank_account_number) {
                    data['bank_account_number'] = patient.bank_account_number;
                }
                if (patient.application) {
                    data['application'] = patient.application;
                }
                if (patient.doctor_recomandation) {
                    data['doctor_recomandation'] = patient.doctor_recomandation;
                }
                if (patient.bank_cheque) {
                    data['bank_cheque'] = patient.bank_cheque;
                }
                if (patient.hospital_document) {
                    data['hospital_document'] = patient.hospital_document;
                }
                if (patient.disease_proved_document) {
                    data['disease_proved_document'] = patient.disease_proved_document;
                }
                if (patient.citizenship_card) {
                    data['citizenship_card'] = patient.citizenship_card;
                }
                if (patient.decision_document) {
                    data['decision_document'] = patient.decision_document;
                }
                // }
            }
            fetchPatientData();

            function bankAccountNumberChange() {
                // alert("Hello");
                let accountNum = $("#bank_account_number").val();
                if (accountNum.length > 0) {
                    data['bank_account_number'] = "patient.bank_account_number";
                } else {
                    data['bank_account_number'] = null;
                }
                disableButton();
            }

            function applicationChange(event) {
                const file = event.target.files[0];
                if (file) {
                    data['application'] = "patient.application";
                } else {
                    data['application'] = null;
                }
                disableButton();
            }

            function doctorRecomandationChange(event) {
                const file = event.target.files[0];
                if (file) {
                    data['doctor_recomandation'] = "patient.doctor_recomandation";
                } else {
                    data['doctor_recomandation'] = null;
                }
                disableButton();
            }

            function bankchequeChange(event) {
                const file = event.target.files[0];
                if (file) {
                    data['bank_cheque'] = "patient.bank_cheque";

                } else {
                    data['bank_cheque'] = null;
                }
                disableButton();
            }

            function decisionDocumentChange(event) {
                // alert('sdf')
                const file = event.target.files[0];
                if (file) {
                    data['decision_document'] = "patient.decision_document";
                } else {
                    data['decision_document'] = null;
                }
                disableButton();
            }

            function hospitalDocument(event) {
                const file = event.target.files[0];
                if (file) {
                    data['hospital_document'] = "patient.hospital_document";
                } else {
                    data['hospital_document'] = null;
                }
                disableButton();
            }

            function diseaseProvedDocumentChange(event) {
                const file = event.target.files[0];
                if (file) {
                    data['disease_proved_document'] = "patient.disease_proved_document";
                } else {
                    data['disease_proved_document'] = null;
                }
                disableButton();
            }

            function citizenshipCardChange(event) {
                const file = event.target.files[0];
                if (file) {

                    data['citizenship_card'] = "patient.citizenship_card";
                } else {
                    data['citizenship_card'] = null;

                }
                disableButton();
            }
            disableButton();


            function disableButton() {
                return;
            }


            $("#registerModal").click(() => {
                let patient = @json($patient);
                if (patient.disease.application_types[0].id == 1) {

                    bankAccountNumberChange();
                    applicationChange();
                    doctorRecomandationChange();
                    bankchequeChange(event);
                    decisionDocumentChange();
                    hospitalDocument();
                    diseaseProvedDocumentChange();
                    citizenshipCardChange();
                } else {
                    applicationChange();
                    alert('sad')
                    decisionDocumentChange();
                    hospitalDocument();
                    diseaseProvedDocumentChange();
                    citizenshipCardChange();
                }
                disableButton();
            });

            $("#nmc_number").on('input', function() {
                let id = $("#nmc_number").val();
                let url = `{{ route('getDoctor', ':id') }}`.replace(':id', id);
                axios.get(url).then((response) => {
                    if (response.data.status) {
                        $("#post").val(response.data.data.post);
                        $("#name").val(response.data.data.user.name)
                    } else {
                        $("#post").val("");
                        $("#name").val("")
                    }
                })
            })
        </script>
    @endpush

    @push('scripts')
        <script>
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
        </script>
    @endpush
