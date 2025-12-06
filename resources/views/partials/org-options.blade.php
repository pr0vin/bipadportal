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
            {{-- ==================================== --}}
            {{-- @if ($patient->disease->id == 1)
            @can('dirgha.edit') --}}
            <a href="{{ route('patient.edit', $patient) }}" class="btn my-btn">
                <i class="fas fa-edit pr-3"></i>
                सम्पादन</a>
            {{-- @endcan
            @endif --}}

            {{-- @if ($patient->disease->id == 2)
            @can('bipanna.edit')
            <a href="{{ route('patient.edit', $patient) }}" class="btn my-btn">
                <i class="fas fa-edit pr-3"></i>
                सम्पादन</a>
            @endcan
            @endif

            @if ($patient->disease->id == 3)
            @can('samajik.edit')
            <a href="{{ route('patient.edit', $patient) }}" class="btn my-btn">
                <i class="fas fa-edit pr-3"></i>
                सम्पादन</a>
            @endcan
            @endif

            @if ($patient->disease->id == 4)
            @can('nagarpalika.edit')
            <a href="{{ route('patient.edit', $patient) }}" class="btn my-btn">
                <i class="fas fa-edit pr-3"></i>
                सम्पादन</a>
            @endcan
            @endif --}}
            {{-- ======================================= --}}
            @if (!$patient->isRecommended)
                {{-- @if ($patient->disease->id == 1) --}}
                {{-- @canany(['dirgha.register', 'hospital_document', 'disease_proved_document', 'citizenship_card',
                'application', 'doctor_recomandation', 'bank_cheque', 'decision_document']) --}}
                <button type="button" class="btn my-btn" id="registerModal" data-toggle="modal"
                    data-target="#exampleModalCenter">
                    <i class="fas fa-plus pr-3"></i>
                    दर्ता गर्नुहोस
                </button>
                {{-- @endcanany --}}
                {{-- @endif --}}



                {{-- @if ($patient->disease->id == 2)
                @can('bipanna.register')
                <button type="button" class="btn my-btn" id="registerModal" data-toggle="modal"
                    data-target="#exampleModalCenter">
                    <i class="fas fa-plus pr-3"></i>
                    सिफारिस गर्नुहोस / कागजात थप्नुहोस
                </button>
                @endcan
                @endif
                @if ($patient->disease->id == 3)
                @can('samajik.register')
                <button type="button" class="btn my-btn" id="registerModal" data-toggle="modal"
                    data-target="#exampleModalCenter">
                    <i class="fas fa-plus pr-3"></i>
                    सिफारिस गर्नुहोस / कागजात थप्नुहोस
                </button>
                @endcan
                @endif
                @if ($patient->disease->id == 4)
                @can('nagarpalika.register')
                <button type="button" class="btn my-btn" id="registerModal" data-toggle="modal"
                    data-target="#exampleModalCenter">
                    <i class="fas fa-plus pr-3"></i>
                    सिफारिस गर्नुहोस / कागजात थप्नुहोस
                </button>
                @endcan
                @endif --}}

            @endif

            @if ($patient->registered_date)
                <button type="button" class="btn my-btn" data-toggle="modal" data-target="#reApply">
                    <i class="fas fa-retweet pr-3"></i> पुनः आबेदन गर्नुहोस
                </button>
                {{-- @if ($patient->disease->id == 1)
                @can('dirgha.renew')
                <button type="button" class="btn my-btn" data-toggle="modal" data-target="#nabikaran">
                    <i class="fas fa-retweet pr-3"></i> नवीकरण गर्नुहोस
                </button>
                @endcan

                @can('dirgha.close')
                <button type="button" class="btn my-btn" data-toggle="modal" data-target="#closed">
                    <i class="far fa-times-circle pr-3"></i> लागतकट्टा गर्नुहोस
                </button>
                @endcan
                @endif --}}
            @endif
            {{-- @if ($patient->disease->id == 1) --}}
            <button type="button border" class="btn {{ $patient->doctor ? 'my-btn' : 'bg-danger text-white' }}" id=""
                data-toggle="modal" data-target="#doctorModal">
                <i class="fas fa-plus pr-3"></i>
                अधकारीको विवरण
            </button>
              @if ($patient->registered_date)
            <button type="button" class="btn bg-info text-white"
                 data-toggle="modal" data-target="#paymentModal-{{ $patient->id }}">
                <i class="fas fa-plus pr-3"></i>
                भुक्तानी विवरण
            </button>
            @endif
           

            {{-- @endif --}}
        </div>
    </div>
    <div class="tab-pane fade px-3" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
        <div class="d-flex">
            {{-- @if ($patient->disease->id == 1) --}}
            {{-- @can('dirgha.tokenletter') --}}
            <a href="{{ route('suchi-print-application', $patient) }}" class="btn my-btn" type="button" id="">
                <i class="fas fa-print pr-3"></i>Print token letter
            </a>
            {{-- @endcan --}}
            <a href="{{ route('schedule.one', $patient) }}" class="btn my-btn" type="button" id="">
                <i class="fas fa-file pr-3"></i>अनुसूची १
            </a>
            <a href="{{ route('schedule.two', $patient) }}" class="btn my-btn" type="button" id="">
                <i class="fas fa-file pr-3"></i>अनुसूची २
            </a>
            {{-- @endif --}}
            {{-- @if ($patient->disease->id == 2)
            @can('bipanna.TokenLetter')
            <a href="{{ route('suchi-print-application', $patient) }}" class="btn my-btn" type="button" id="">
                <i class="fas fa-print pr-3"></i>Print token letter
            </a>
            @endcan
            @endif
            @if ($patient->disease->id == 3)
            @can('samajik.TokenLetter')
            <a href="{{ route('suchi-print-application', $patient) }}" class="btn my-btn" type="button" id="">
                <i class="fas fa-print pr-3"></i>Print token letter
            </a>
            @endcan
            @endif
            @if ($patient->disease->id == 4)
            @can('nagarpalika.TokenLetter')
            <a href="{{ route('suchi-print-application', $patient) }}" class="btn my-btn" type="button" id="">
                <i class="fas fa-print pr-3"></i>Print token letter
            </a>
            @endcan
            @endif --}}

            @can('bipanna.DecisionPrint')
                @if ($patient->disease->id == 2)
                    <a href="{{ route('decision.document') }}?patient_id={{ $patient->id }}" class="btn my-btn"><i
                            class="fas fa-print pr-3"></i> बिपन्न निर्णय प्रिन्ट गर्नुहोस्</a>
                @endif
            @endcan
            @if ($patient->disease->id == 3)
                @can('samajik.DecisionPrint')
                    <a href="{{ route('decision.document') }}?patient_id={{ $patient->id }}" class="btn my-btn"><i
                            class="fas fa-print pr-3"></i> निर्णय प्रिन्ट गर्नुहोस्</a>
                @endcan
            @endif
            @if ($patient->disease->id == 4)
                @can('nagarpalika.DecisionPrint')
                    <a href="{{ route('decision.document') }}?patient_id={{ $patient->id }}" class="btn my-btn"><i
                            class="fas fa-print pr-3"></i> निर्णय प्रिन्ट गर्नुहोस्</a>
                @endcan
            @endif
            @if ($patient->registered_date)
                @if ($patient->disease->id == 1)
                    {{-- दिर्घ --}}
                @elseif($patient->disease->id == 2)
                    {{-- बिपन्न --}}
                    {{-- <a href="{{ route('hospitalSifaris', $patient) }}" class="btn btn-info" type="button" id="">
                        सिफारिस पत्र (अस्पताल)
                    </a> --}}
                    @can('bipanna.SifarisPrint')
                        <button type="button" class="btn my-btn" data-toggle="modal" data-target="#exampleModalCenter">
                            <i class="fas fa-print pr-3"></i>सिफारिस पत्र प्रिन्ट गर्नुहोस
                        </button>
                    @endcan

                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">अस्पताललाई सिफारिस गर्नुहोस
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('assignHospital', $patient) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <select name="hospital_id" class="form-control js-example-basic-single"
                                            id="select_hospital_name">
                                            <option value="">अस्पताल छान्नुहोस्</option>
                                            @foreach (App\Hospital::latest()->get() as $hospital)
                                                <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                                            @endforeach
                                        </select>
                                        <textarea name="" id="txtDeases" class="form-control mt-3 d-none" readonly></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">रद्द
                                            गर्नुहोस</button>
                                        <button type="submit" class="btn btn-primary" style="width:150px">सिफारिस
                                            गर्नुहोस</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- @elseif($patient->disease->id == 3) --}}
                    {{-- सामाजिक --}}
                    <a href="{{ route('SocialRecommandation', $patient) }}" class="btn my-btn">
                        <i class="fas fa-print pr-3"></i>सिफारिस पत्र प्रिन्ट गर्नुहोस
                    </a>
                    {{-- @else --}}
                    {{-- नगरपालिका --}}
                @endif
            @endif
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
                                            {{-- {{ $patient->disease->id == 1 ? 'दर्ता ' : 'सिफारिस ' }} --}}
                                            दर्ता मिति</label>
                                        <input type="text" name="date_from" id="input-date-from" data-single="true"
                                            class="form-control nepali-date rounded-0 kalimati-font"
                                            value="{{$patient->date_from ? ad_to_bs($patient->date_from) : ''}}">
                                        @error('registered_date')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mx-0 px-0 col-12">
                                        <label for="">ख)
                                            {{-- {{ $patient->disease->id == 1 ? 'दर्ता ' : 'सिफारिस ' }} --}}
                                            दर्ता नम्बर</label>
                                        <div class="d-flex">
                                            <input type="text" name="registration_number"
                                                class="form-control rounded-0 kalimati-font" style="width: 100px"
                                                value="{{ $registrationNumber }}" readonly>
                                            <input type="text" name="reg_number"
                                                class="form-control rounded-0 kalimati-font"
                                                value="{{$patient->reg_number ?? ''}}">
                                        </div>
                                        @error('registration_number')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>

                                @if ($applicationType == 1)
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
                                @endif
                                <div class="col-12">

                                    <label class="" id="kagjat">{{ $isBankEnabled ? 'घ' : 'ग' }}) कागजातहरु
                                        :</label> <br>
                                </div>
                            @endcan
                            @can('application')
                                {{-- @if ($applicationType == 1 || $applicationType == 2 || $applicationType == 3 ||
                                $applicationType == 4) --}}
                                @if (!$patient->application)
                                    <div class="col-md-6 mb-2">
                                        <label>अनुसूची २ बमोजिमको निबेदन</label>
                                        <input type="file" name="application" class="form-control dirgha" id=""
                                            onchange="applicationChange(event)">
                                        @error('application')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                @endif
                                {{-- @endif --}}
                            @endcan

                            {{-- @if ($applicationType == 1) --}}
                            @can('doctor_recomandation')
                            @if (!$patient->doctor_recomandation)
                                <div class="col-md-6 mb-2">
                                    <label>अनुसूची १ अधिकृतको सिफारिस</label>
                                    <input type="file" name="doctor_recomandation" class="form-control dirgha" id=""
                                        onchange="doctorRecomandationChange(event)">
                                    @error('doctor_recomandation')
                                        <label class="text-danger">{{ $message }}</label>
                                    @enderror
                                </div>
                            @endif
                            {{-- @endcan --}}
                            @can('bank_cheque')
                                @if (!$patient->bank_cheque)
                                    <div class="col-md-6 mb-2">
                                        <label>बैंक चेक बुक</label>
                                        <input type="file" name="bank_cheque" class="form-control dirgha" id=""
                                            onchange="bankchequeChange(event)">
                                        @error('bank_cheque')
                                            <label class="text-danger">{{ $message }}</label>
                                        @enderror
                                    </div>
                                @endif
                            @endcan
                            @endif

                            {{-- @can('decision_document')

                            @if ($applicationType != 1)
                            @if (!$patient->decision_document)
                            <div class="col-md-6 mb-2">
                                <label>निर्णय</label>
                                <input type="file" name="decision_document" class="form-control dirgha" id=""
                                    onchange="decisionDocumentChange(event)">
                                @error('decision_document')
                                <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                            @endif
                            @endif
                            @endcan --}}
                            {{-- @can('hospital_document')

                            @if (!$patient->hospital_document)
                            <div class="col-md-6 mb-2">
                                <label>अस्पतालको पुर्जाको फोटोकपी</label>
                                <input type="file" name="hospital_document" class="form-control" id=""
                                    onchange="hospitalDocument(event)">
                                @error('hospital_document')
                                <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                            @endif
                            @endcan --}}

                            {{-- @can('disease_proved_document')

                            @if (!$patient->disease_proved_document)
                            <div class="col-md-12 mb-2">
                                <label>पिडित प्रमाणित कागजात</label>
                                <input type="file" name="disease_proved_document" class="form-control" id=""
                                    onchange="diseaseProvedDocumentChange(event)">
                                @error('disease_proved_document')
                                <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                            @endif
                            @endcan --}}

                            @can('citizenship_card')

                                @if (!$patient->citizenship_card)
                                    <div class="col-md-12 mb-2">
                                        <label>नागरिकता/ जन्मदर्ता / बसाइसराई कागजात / राष्ट्रिय परिचय पत्र</label>
                                        <input type="file" name="citizenship_card" class="form-control" id=""
                                            onchange="citizenshipCardChange(event)">
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
                        {{-- @can('dirgha.register') --}}
                        <button type="button" onclick="registerDoc({{ $patient->id }})"
                            class="btn btn-primary btnRegister" id="btnRegister" style="width: 200px">
                            {{-- {{ $patient->disease->id == 1 ? 'दर्ता' : 'सिफारिस' }} --}}
                            {{ 'दर्ता'}}
                            गर्नुहोस</button>
                        {{-- @endcan --}}

                        {{-- @canany(['hospital_document', 'disease_proved_document', 'citizenship_card', 'application',
                        'doctor_recomandation', 'bank_cheque', 'decision_document']) --}}
                        <button type="button" style="width: 100px" onclick="docUpload({{ $patient->id }})"
                            class="btn btn-primary">ड्राफ्ट</button>
                        {{-- @endcanany --}}
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


    <!-- Nabikaran -->
    <div class="modal fade" id="nabikaran" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">नवीकरण गर्नुहोस</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('patient.renew', $patient) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        @php
                            $oldRenew = App\Renew::where('patient_id', $patient->id)
                                ->latest()
                                ->first();
                        @endphp
                        {{-- @if ($oldRenew)
                        <div class="form-group">
                            <label for="">नवीकरण मिति</label>
                            <input type="text" name="renew_date" onchange="test()"
                                class="form-control date-picker  rounded-0 kalimati-font" placeholder="yyyy-mm-dd"
                                data-single="true" value="" id="renew_date" required>
                        </div>
                        @endif --}}
                        <div class="form-group">
                            <label for="">नवीकरण</label>
                            @php
                                $year = Carbon\Carbon::parse(currentFiscalYear()->start)->format('Y');
                                $quarterOne = new DateTime($year . '-6-30');
                                $quarterTwo = new DateTime($year . '-9-30');
                                $quarterThree = new DateTime($year . '-12-30');
                                $quarterFour = new DateTime($year + 1 . '-3-30');
                                $currentDate = new DateTime(currentQuarterEndDate());
                            @endphp
                            <select name="quarter" id="" class="form-control">
                                <option value="">नवीकरण त्रैमासिक छान्नुहोस्</option>
                                <option value="1" {{-- {{ renewquarter(collect($patient->
                                    renews)->max('next_renew_date')) == 1 ? 'selected' : '' }} --}}
                                    {{ $quarterOne > $currentDate ? 'disabled' : '' }}>
                                    प्रथम त्रैमासिक
                                </option>
                                <option value="2" {{-- {{ renewquarter(collect($patient->
                                    renews)->max('next_renew_date')) == 2 ? 'selected' : '' }} --}}
                                    {{ $quarterTwo > $currentDate ? 'disabled' : '' }}>
                                    द्वितीय त्रैमासिक
                                </option>
                                <option value="3" {{-- {{ renewquarter(collect($patient->
                                    renews)->max('next_renew_date')) == 3 ? 'selected' : '' }} --}}
                                    {{ $quarterThree > $currentDate ? 'disabled' : '' }}>
                                    तृतीय त्रैमासिक
                                </option>
                                <option value="4" {{-- {{ renewquarter(collect($patient->
                                    renews)->max('next_renew_date')) == 4 ? 'selected' : '' }} --}}
                                    {{ $quarterFour > $currentDate ? 'disabled' : '' }}>
                                    चतुर्थ त्रैमासिक
                                </option>
                            </select>
                            {{-- <input type="text" name="renewed_date"
                                class="form-control  rounded-0 date-picker kalimati-font" placeholder="yyyy-mm-dd"
                                readonly
                                value="{{ $patient->renews()->latest('created_at')->value('next_renew_date') }}"
                                required> --}}
                        </div>
                        <div class="form-group">
                            <label for="">उपचार भैरहेको अस्पतालको कागजात</label>
                            <input type="file" name="renewing_document" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">रद्द गर्नुहोस</button>
                        <button type="submit" class="btn btn-primary" style="width: 150px">नबिकरण गर्नुहोस</button>
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
                            <input type="hidden" value="{{$patient->id}}" name="patient_id">
                            <label for="" class="required"> आवेदनको प्रकार <span class="text-danger">*</span></label>

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
                            <label for="" class="required"> घटनाको प्रकार <span class="text-danger">*</span></label>
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
    <!-- Nabikaran -->
    <div class="modal fade" id="closed" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">लागतकट्टा गर्नुहोस</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('patient.closed', $patient) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">लागतकट्टा गरेको मिति</label>
                            <input type="text" name="closed_date" class="form-control date-picker rounded-0"
                                placeholder="yyyy-mm-dd" readonly value="{{ ad_to_bs(now()->format('Y-m-d')) }}">
                        </div>
                        <div class="form-group">
                            <label for="">लागतकट्टा गर्नुको कारण</label>
                            {{-- <input type="file" name="closing_document" required class="form-control"> --}}
                            <select name="closing_document" id="" class="form-control" required>
                                <option value="">लागतकट्टा गर्नुको कारणहरु</option>
                                @foreach (App\Reason::latest()->get() as $reason)
                                    <option value="{{ $reason->reason }}">{{ $reason->reason }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">रद्द गर्नुहोस</button>
                        <button type="submit" class="btn btn-primary" style="width: 150px">लागतकट्टा
                            गर्नुहोस</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!----Doctor----->
    <div class="modal fade" id="doctorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title " style="font-weight:bold" id="exampleModalLongTitle">अधिकारीको विवरण </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('patient.doctor', $patient) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for=""> अधिकृत प्रमाणपत्र नं. :</label>
                            <input type="text" name="nmc_no" id="nmc_number"
                                value="{{ $patient->doctor ? $patient->doctor->nmc_no : '' }}"
                                class="form-control kalimati-font" required>
                        </div>
                        <div class="form-group">
                            <label for="">पुरा नाम थर : </label>
                            <input type="text" name="name" class="form-control" id="name"
                                value="{{ $patient->doctor ? $patient->doctor->name : '' }}" required>


                        </div>
                        <div class="form-group">
                            <label for=""> पद :</label>
                            <input type="text" name="post" class="form-control" id="post"
                                value="{{ $patient->doctor ? $patient->doctor->post : '' }}" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">रद्द गर्नुहोस</button>
                        <button type="submit" class="btn btn-primary" style="width: 150px"> सेभ गर्नुहोस् </button>
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
                                class="form-control kalimati-font" step="0.01" value="{{ $patient->paid_amount ?? '' }}" required>
                        </div>
                       
                        {{-- <div class="form-group">
                            <label for="paid_date-{{ $patient->id }}">भुक्तानी मिति :</label>
                            <input type="date" name="paid_date" id="paid_date-{{ $patient->id }}" class="form-control"
                                value="{{ $patient->paid_date ?? date('Y-m-d') }}" required>   
                        </div> --}}

                        {{-- <div class="form-group">
                                <label for="paid_date-{{ $patient->id }}">भुक्तानी मिति :</label>
                                <input type="text" name="paid_date" id="paid_date-{{ $patient->id }}"
                                       class="form-control date-picker kalimati-font"
                                       data-single="true" readonly required>
                                       <script>
                                $(document).ready(function () {
                                    let paidDateInput = $('#paid_date-{{ $patient->id }}');
                                    
                                    // AD date from DB or today
                                    let initialADDate = "{{ $patient->paid_date ?? now()->format('Y-m-d') }}";
                                    
                                    // Convert AD to BS for display
                                    let initialBSDate = ad_to_bs(initialADDate);
                                    
                                    // Initialize Nepali date picker with default date
                                    paidDateInput.nepaliDatePicker({
                                        npdMonth: true,
                                        npdYear: true,
                                        npdYearCount: 10,
                                        ndpDefaultDate: initialBSDate, // <-- Use ndpDefaultDate instead of val()
                                        onChange: function() {
                                            // Optional: you can handle changes here
                                        }
                                    });
                                });
                            </script>

                            </div> --}}

                    <div class="form-group">
                        <label for="paid_date-{{ $patient->id }}">भुक्तानी मिति :</label>
                        <input type="text" name="paid_date" id="paid_date-{{ $patient->id }}"
                               class="form-control date-picker kalimati-font"
                               value="{{ formatDate(ad_to_bs(now()->format('Y-m-d'))) }}"
                               data-single="true" readonly required>
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

    // function disableButton() {
    //     let patient = @json($patient);
    //     if (patient.disease.application_types[0].id == 1) {
    //         if (data.bank_account_number && data.application && data.doctor_recomandation && data.bank_cheque && data
    //             .hospital_document && data.disease_proved_document && data.citizenship_card) {
    //             $("#btnRegister").addClass('active');
    //         } else {
    //             $("#btnRegister").removeClass('active');
    //         }
    //     }

    //     if (patient.disease.application_types[0].id == 2) {
    //         // alert('sd')
    //         if (data.application && data.decision_document && data.hospital_document && data.disease_proved_document &&
    //             data.citizenship_card) {
    //             $("#btnRegister").addClass('active');
    //         } else {
    //             $("#btnRegister").removeClass('active');
    //         }
    //     }

    //     if (patient.disease.application_types[0].id == 3) {
    //         if (data.application && data.decision_document && data.hospital_document && data.disease_proved_document &&
    //             data.citizenship_card) {
    //             $("#btnRegister").addClass('active');
    //         } else {
    //             $("#btnRegister").removeClass('active');
    //         }
    //     }
    //     if (patient.disease.application_types[0].id == 4) {
    //         if (data.application && data.decision_document && data.hospital_document && data.disease_proved_document &&
    //             data.citizenship_card) {
    //             $("#btnRegister").addClass('active');
    //         } else {
    //             $("#btnRegister").removeClass('active');
    //         }
    //     }

    // }

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

    $("#nmc_number").on('input', function () {
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

{{--
<script>
    $("#renew_date").change(() => {
        alert('Hello')
    })
    const dateInput = document.getElementById('renew_date');

    // Add event listener for change event
    dateInput.addEventListener('change', function () {
        test();
    });

    function test() {
        alert("Hello")
    }
</script> --}}
@endpush

@push('styles')
<style>
    /* .btnRegister {
            display: none;
            width: 200px;
        }

        .btnRegister.active {
            display: block !important;
        } */
</style>
@endpush

@push('scripts')
<script>
    $("#application_types").on('change', function () {
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
            success: function (dataResult) {
                const selectElement = $(
                    '#disease_id');
                selectElement.empty();
                selectElement.append($('<option>', {
                    value: "",
                    text: "रोग छान्नुहोस्"

                }));
                $.each(dataResult.diseases, function (index, item) {
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