@extends('layouts.app')

@push('styles')
    <style>
        #org-details-table th,
        #org-details-table td {
            padding: 0.75rem 1rem;
            /* font-weight: 600; */
            color: #343a40;
        }
    </style>
@endpush

@section('content')
    <div class="container">

        @include('alerts.all')

        @if (!$patient->closed_date)
            <div class="card z-depth-0 border">
                <div class="card-body">
                    @include('partials.org-options', [
                        'nextRegNumber' => $nextRegNumber,
                       
                    ])

                </div>
            </div>
        @endif
        <div class="my-4"></div>

        <div class="card z-depth-0 border">
            <div class="card-body">
                <div class="text-center mb-4 border-bottom pb-2 font-nep">
                    <h3 class="h2-reponsive font-weight-bold text-primary">
                        {{ $patient->patientApplication->first()->application_type->name ?? '' }}
                    </h3>

                    <h5 class="text-secondary kalimati-font">
                        आवेदन टोकन नं.: {{ $patient->onlineApplication->token_number }}
                    </h5>

                    @if (!$patient->registered_date && !$patient->closed_date)
                        <small class="text-danger">( दर्ता नभएको )</small>
                    @else
                        @if ($patient->status === 0 && !$patient->closed_date)
                            <small class="text-success">( सिफारीस भएको )</small>
                        @elseif($patient->status === 1 && !$patient->closed_date)
                            <small class="text-primary">( भुक्तानी भएको )</small>
                        @else
                            <small class="text-primary">( दर्ता भएको )</small>
                        @endif
                    @endif
                </div>
                <div class="px-5">

                    <div class="row">
                        <div class="col-md-6">
                            <table id="org-details-table">
                                <thead>

                                    <tr>
                                        <td class="font-weight-bold">नाम</td>
                                        <td>{{ $patient->name }} <i>({{ $patient->name_en }})</i></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">ठेगाना</td>
                                        <td class="kalimati-font">
                                            {{ $patient->address->municipality }} - {{ $patient->ward_number }}
                                            {{ $patient->tole }} ,{{ $patient->address->district }}


                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold"></td>
                                        <td>
                                            {{ $patient->address->province }}, नेपाल
                                        </td>
                                    </tr>


                                    <tr>
                                        <td class="font-weight-bold">उमेर</td>
                                        <td class="kalimati-font">{{ $patient->age }}</td>

                                    <tr>
                                        <td class="font-weight-bold">लिंग</td>
                                        <td>
                                            @if (strtolower($patient->gender) == 'male')
                                                पुरुष
                                            @elseif(strtolower($patient->gender) == 'female')
                                                महिला
                                            @else
                                                अन्य
                                            @endif
                                        </td>

                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">फोन नं</td>
                                        <td class="kalimati-font">{{ $patient->mobile_number }}</td>
                                    </tr>

                                    <tr>
                                        <td class="font-weight-bold">इमेल</td>
                                        <td>{{ $patient->email }}</td>
                                    </tr>


                                    <tr>
                                        <td class="font-weight-bold">सम्पर्क व्यक्ति</td>
                                        <td>
                                            {{ $patient->contact_person }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">क्षति मिति</td>
                                        <td class="kalimati-font">{{ $patient->kshati_date }}</td>
                                    </tr>



                                    <tr>
                                        <td class="font-weight-bold">आनुमानित क्षति रकम</td>
                                        <td class="kalimati-font">{{ $patient->estimated_amount }}</td>
                                    </tr>

                                    <tr>
                                        <td class="font-weight-bold">भुक्तानी मिति</td>
                                        <td class="kalimati-font">{{ $patient->paid_date }}</td>
                                    </tr>

                                    <tr>
                                        <td class="font-weight-bold">भुक्तानी रकम</td>
                                        <td class="kalimati-font">{{ $patient->paid_amount }}</td>
                                    </tr>


                                    <tr>
                                        <td class="font-weight-bold">कैफियत</td>
                                        <td>{{ $patient->description }}</td>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <table id="org-details-table">
                                <thead>
                                    <tr>
                                        <td class="font-weight-bold">
                                            दर्ता नम्बर
                                        </td>
                                        <td class="kalimati-font">
                                            @if ($patient->registration_number)
                                                <span class=" py-1 kalimati-font">
                                                    {{ $patient->reg_number }} ({{ $patient->registration_number }})
                                                </span>
                                            @else
                                                <span class="px-2 py-1 text-danger border border-danger rounded-lg">

                                                    दर्ता नभएको
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">नागरिकता नं.</td>
                                        <td class="kalimati-font">{{ $patient->citizenship_number }}</td>
                                    </tr>


                                    <tr>
                                        <td class="font-weight-bold">प्रकोप</td>
                                        <td>
                                            @php
                                                $diseases = $patient->patientApplication->flatMap(
                                                    fn($app) => $app->patientApplicationDisease->pluck('disease.name'),
                                                );
                                            @endphp
                                            {{ $diseases->join(', ') }}
                                        </td>
                                    </tr>


                                    <tr>
                                        <td class="font-weight-bold">आवेदन मिति</td>
                                        <td class="kalimati-font">
                                            {{ $patient->applied_date ? ad_to_bs($patient->applied_date) : '' }}
                                        </td>
                                    </tr>


                                    <tr>
                                        <td class="font-weight-bold">

                                            दर्ता मिति
                                        </td>

                                        <td class="kalimati-font">
                                            @if ($patient->registered_date)
                                                <span class=" py-1  kalimati-font">
                                                    {{ $patient->registered_date ? dateFormat($patient->registered_date) : '' }}
                                                </span>
                                            @else
                                                <span class="px-2 py-1 text-danger border border-danger rounded-lg">
                                                    दर्ता नभएको
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                </thead>
                            </table>

                        </div>
                    </div>
                    {{-- documents --}}
                    <div>

                        <h4 class="mt-5 text-secondary font-nep border-bottom">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                                <path
                                    d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                            </svg> पिडितको कागजातहरु
                        </h4>
                        <div class="row p-2">
                            <table id="org-details-table">
                                <thead>
                                    <tr>
                                        <td class="font-weight-bold">नागरिकता/ जन्मदर्ता / बसाइसराई कागजात</td>
                                        @if ($patient->citizenship_card)
                                            <td class="d-flex justify-content-between m-0 px-3"
                                                id="citizenship_card_document_div">
                                                <a target="__blank" id="citizenship_card_document"
                                                    href="{{ asset('storage') . '/' . $patient->citizenship_card }}"><u
                                                        class="text-info">कागजात हेर्नुहोस</u></a>
                                                <form action="{{ route('reuploadImage', $patient) }}" method="POST"
                                                    enctype="multipart/form-data" class="d-none align-items-center"
                                                    id="citizenship_card_document_form">
                                                    @csrf
                                                    @method('put')
                                                    <input type="file" name="citizenship_card" class="form-control"
                                                        style="width: 250px" required>
                                                    <button class="btn">अपडेट </button>
                                                </form>
                                                @can('citizenship_card')
                                                    <button class="bg-transparent border-0"
                                                        id="citizenship_card_document_edit_btn" title="पुन: अपलोड गर्नुहोस"><i
                                                            class="fas fa-sync-alt"></i>
                                                    </button>
                                                @endcan
                                                <button class="bg-transparent border-0 d-none"
                                                    id="citizenship_card_document_calcel_btn" title="रद्द गर्नुहोस"><i
                                                        class="fas fa-times"></i>
                                                </button>
                                            </td>
                                        @else
                                            <td>
                                                <span class="text-danger">कागजात छैन</span>

                                                <form action="{{ route('reuploadImage', $patient) }}" method="POST"
                                                    enctype="multipart/form-data" class="d-none align-items-center"
                                                    id="citizenship_card_document_form">
                                                    @csrf
                                                    @method('put')
                                                    <input type="file" name="citizenship_card" class="form-control"
                                                        style="width: 250px" required>
                                                    <button class="btn">थप्नुहोस </button>
                                                </form>
                                                @can('citizenship_card')
                                                    <button class="bg-transparent border-0"
                                                        id="citizenship_card_document_edit_btn" title="थप्नुहोस "><i
                                                            class="fas fa-plus"></i>
                                                    </button>
                                                @endcan
                                                <button class="bg-transparent border-0 d-none"
                                                    id="citizenship_card_document_calcel_btn" title="रद्द गर्नुहोस"><i
                                                        class="fas fa-times"></i>
                                                </button>
                                            </td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">निबेदन</td>
                                        @if ($patient->application)
                                            <td class="d-flex justify-content-between m-0 px-3"
                                                id="application_document_div">
                                                <a target="__blank" id="application_document"
                                                    href="{{ asset('storage') . '/' . $patient->application }}"><u
                                                        class="text-info">कागजात हेर्नुहोस</u></a>
                                                <form action="{{ route('reuploadImage', $patient) }}" method="POST"
                                                    enctype="multipart/form-data" class="d-none align-items-center"
                                                    id="application_document_form">
                                                    @csrf
                                                    @method('put')
                                                    <input type="file" name="application" class="form-control"
                                                        style="width: 250px" required>
                                                    <button class="btn">अपडेट </button>
                                                </form>
                                                @can('application')
                                                    <button class="bg-transparent border-0" id="application_document_edit_btn"
                                                        title="पुन: अपलोड गर्नुहोस"><i class="fas fa-sync-alt"></i>
                                                    </button>
                                                @endcan
                                                <button class="bg-transparent border-0 d-none"
                                                    id="application_document_calcel_btn" title="रद्द गर्नुहोस"><i
                                                        class="fas fa-times"></i>
                                                </button>
                                            </td>
                                        @else
                                            <td>
                                                <span class="text-danger">कागजात छैन</span>

                                                <form action="{{ route('reuploadImage', $patient) }}" method="POST"
                                                    enctype="multipart/form-data" class="d-none align-items-center"
                                                    id="application_document_form">
                                                    @csrf
                                                    @method('put')
                                                    <input type="file" name="application" class="form-control"
                                                        style="width: 250px" required>
                                                    <button class="btn">अपलोड </button>
                                                </form>
                                                @can('application')
                                                    <button class="bg-transparent border-0" id="application_document_edit_btn"
                                                        title="पुन: अपलोड गर्नुहोस"><i class="fas fa-plus"></i>
                                                    </button>
                                                @endcan
                                                <button class="bg-transparent border-0 d-none"
                                                    id="application_document_calcel_btn" title="रद्द गर्नुहोस"><i
                                                        class="fas fa-times"></i>
                                                </button>
                                            </td>
                                        @endif
                                    </tr>

                                    @if ($patient->diseaseid == 1)
                                        <tr>
                                            <td class="font-weight-bold">अनुसूची १ डाक्टरको सिफारिस</td>
                                            @if ($patient->doctor_recomandation)
                                                <td class="d-flex justify-content-between m-0 px-3"
                                                    id="doctor_recomandation_document_div">
                                                    <a target="__blank" id="doctor_recomandation_document"
                                                        href="{{ asset('storage') . '/' . $patient->doctor_recomandation }}"><u
                                                            class="text-info">कागजात हेर्नुहोस</u></a>
                                                    <form action="{{ route('reuploadImage', $patient) }}" method="POST"
                                                        enctype="multipart/form-data" class="d-none align-items-center"
                                                        id="doctor_recomandation_document_form">
                                                        @csrf
                                                        @method('put')
                                                        <input type="file" name="doctor_recomandation"
                                                            class="form-control" style="width: 250px" required>
                                                        <button class="btn">अपडेट </button>
                                                    </form>
                                                    @can('doctor_recomandation')
                                                        <button class="bg-transparent border-0"
                                                            id="doctor_recomandation_document_edit_btn"
                                                            title="पुन: अपलोड गर्नुहोस"><i class="fas fa-sync-alt"></i>
                                                        </button>
                                                    @endcan
                                                    <button class="bg-transparent border-0 d-none"
                                                        id="doctor_recomandation_document_calcel_btn"
                                                        title="रद्द गर्नुहोस"><i class="fas fa-times"></i>
                                                    </button>
                                                </td>
                                            @else
                                                <td>
                                                    <span class="text-danger">कागजात छैन</span>

                                                    <form action="{{ route('reuploadImage', $patient) }}" method="POST"
                                                        enctype="multipart/form-data" class="d-none align-items-center"
                                                        id="doctor_recomandation_document_form">
                                                        @csrf
                                                        @method('put')
                                                        <input type="file" name="doctor_recomandation"
                                                            class="form-control" style="width: 250px" required>
                                                        <button class="btn">अपलोड </button>
                                                    </form>
                                                    @can('doctor_recomandation')
                                                        <button class="bg-transparent border-0"
                                                            id="doctor_recomandation_document_edit_btn"
                                                            title="पुन: अपलोड गर्नुहोस"><i class="fas fa-plus"></i>
                                                        </button>
                                                    @endcan
                                                    <button class="bg-transparent border-0 d-none"
                                                        id="doctor_recomandation_document_calcel_btn"
                                                        title="रद्द गर्नुहोस"><i class="fas fa-times"></i>
                                                    </button>
                                                </td>
                                            @endif
                                        </tr>

                                        <tr>
                                            <td class="font-weight-bold">बैंक चेक बुक</td>
                                            @if ($patient->bank_cheque)
                                                <td class="d-flex justify-content-between m-0 px-3"
                                                    id="bank_cheque_document_div">
                                                    <a target="__blank" id="bank_cheque_document"
                                                        href="{{ asset('storage') . '/' . $patient->bank_cheque }}"><u
                                                            class="text-info">कागजात हेर्नुहोस</u></a>
                                                    <form action="{{ route('reuploadImage', $patient) }}" method="POST"
                                                        enctype="multipart/form-data" class="d-none align-items-center"
                                                        id="bank_cheque_document_form">
                                                        @csrf
                                                        @method('put')
                                                        <input type="file" name="bank_cheque" class="form-control"
                                                            style="width: 250px" required>
                                                        <button class="btn">अपडेट </button>
                                                    </form>
                                                    @can('bank_cheque')
                                                        <button class="bg-transparent border-0"
                                                            id="bank_cheque_document_edit_btn" title="पुन: अपलोड गर्नुहोस"><i
                                                                class="fas fa-sync-alt"></i>
                                                        </button>
                                                    @endcan
                                                    <button class="bg-transparent border-0 d-none"
                                                        id="bank_cheque_document_calcel_btn" title="रद्द गर्नुहोस"><i
                                                            class="fas fa-times"></i>
                                                    </button>
                                                </td>
                                            @else
                                                <td>
                                                    <span class="text-danger">कागजात छैन</span>
                                                    <form action="{{ route('reuploadImage', $patient) }}" method="POST"
                                                        enctype="multipart/form-data" class="d-none align-items-center"
                                                        id="bank_cheque_document_form">
                                                        @csrf
                                                        @method('put')
                                                        <input type="file" name="bank_cheque" class="form-control"
                                                            style="width: 250px" required>
                                                        <button class="btn">अपलोड </button>
                                                    </form>

                                                    @can('bank_cheque')
                                                        <button class="bg-transparent border-0"
                                                            id="bank_cheque_document_edit_btn" title="पुन: अपलोड गर्नुहोस"><i
                                                                class="fas fa-plus"></i>
                                                        </button>
                                                    @endcan
                                                    <button class="bg-transparent border-0 d-none"
                                                        id="bank_cheque_document_calcel_btn" title="रद्द गर्नुहोस"><i
                                                            class="fas fa-times"></i>
                                                    </button>
                                                </td>
                                            @endif
                                        </tr>
                                    @else
                                        <tr>
                                            <td class="font-weight-bold">निर्णय</td>
                                            @if ($patient->decision_document)
                                                <td class="d-flex justify-content-between m-0 px-3"
                                                    id="decision_document_document_div">
                                                    <a target="__blank" id="decision_document_document"
                                                        href="{{ asset('storage') . '/' . $patient->decision_document }}"><u
                                                            class="text-info">कागजात हेर्नुहोस</u></a>
                                                    <form action="{{ route('reuploadImage', $patient) }}" method="POST"
                                                        enctype="multipart/form-data" class="d-none align-items-center"
                                                        id="decision_document_document_form">
                                                        @csrf
                                                        @method('put')
                                                        <input type="file" name="decision_document"
                                                            class="form-control" style="width: 250px" required>
                                                        <button class="btn">अपडेट </button>
                                                    </form>
                                                    @can('decision_document')
                                                        <button class="bg-transparent border-0"
                                                            id="decision_document_document_edit_btn"
                                                            title="पुन: अपलोड गर्नुहोस"><i class="fas fa-sync-alt"></i>
                                                        </button>
                                                    @endcan
                                                    <button class="bg-transparent border-0 d-none"
                                                        id="decision_document_document_calcel_btn"
                                                        title="रद्द गर्नुहोस"><i class="fas fa-times"></i>
                                                    </button>
                                                </td>
                                            @else
                                                <td>
                                                    <span class="text-danger">कागजात छैन</span>

                                                    <form action="{{ route('reuploadImage', $patient) }}" method="POST"
                                                        enctype="multipart/form-data" class="d-none align-items-center"
                                                        id="decision_document_document_form">
                                                        @csrf
                                                        @method('put')
                                                        <input type="file" name="decision_document"
                                                            class="form-control" style="width: 250px" required>
                                                        <button class="btn">अपलोड </button>
                                                    </form>
                                                    @can('decision_document')
                                                        <button class="bg-transparent border-0"
                                                            id="decision_document_document_edit_btn"
                                                            title="पुन: अपलोड गर्नुहोस"><i class="fas fa-plus"></i>
                                                        </button>
                                                    @endcan
                                                    <button class="bg-transparent border-0 d-none"
                                                        id="decision_document_document_calcel_btn"
                                                        title="रद्द गर्नुहोस"><i class="fas fa-times"></i>
                                                    </button>
                                                </td>
                                            @endif
                                        </tr>
                                    @endif

                                    @if ($patient->renewing_document)
                                        <tr>
                                            <td class="font-weight-bold">उपचार भैरहेको अस्पतालको कागजात</td>
                                            <td class="d-flex justify-content-between m-0 px-3"
                                                id="renewing_document_div">
                                                <a target="__blank" id="renewing_document"
                                                    href="{{ asset('storage') . '/' . $patient->renewing_document }}"><u
                                                        class="text-info">कागजात हेर्नुहोस</u></a>
                                                <form action="{{ route('reuploadImage', $patient) }}" method="POST"
                                                    enctype="multipart/form-data" class="d-none align-items-center"
                                                    id="renewing_document_form">
                                                    @csrf
                                                    @method('put')
                                                    <input type="file" name="renewing_document" class="form-control"
                                                        style="width: 250px" required>
                                                    <button class="btn">अपडेट </button>
                                                </form>
                                                <button class="bg-transparent border-0" id="renewing_document_edit_btn"
                                                    title="पुन: अपलोड गर्नुहोस"><i class="fas fa-sync-alt"></i>
                                                </button>
                                                <button class="bg-transparent border-0 d-none"
                                                    id="renewing_document_calcel_btn" title="रद्द गर्नुहोस"><i
                                                        class="fas fa-times"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endif
                                </thead>
                            </table>

                            <div>
                                <p class="text-dark fs-6 font-nep">क्षतिको फोटो</p>

                                @php
                                    $photos = $patient->kshati_document
                                        ? json_decode($patient->kshati_document, true)
                                        : [];
                                @endphp

                                @if (count($photos) > 0)
                                    <div class="row mt-2">

                                        @foreach ($photos as $index => $photo)
                                            <div class="col-4 col-md-3 col-lg-2 mb-3 position-relative">

                                                <!-- Photo Card -->
                                                <div class="position-relative shadow-sm rounded overflow-hidden"
                                                    style="height:120px; cursor:pointer;">

                                                    <a href="{{ asset('storage/' . $photo) }}" target="_blank">
                                                        <img src="{{ asset('storage/' . $photo) }}" class="w-100 h-100"
                                                            style="object-fit: cover;">
                                                    </a>

                                                    <!-- Edit Icon -->
                                                    <label for="edit_photo_{{ $index }}"
                                                        class="position-absolute top-0 start-0 m-1 bg-primary text-white rounded-circle p-1"
                                                        style="cursor:pointer; width:28px; height:28px; display:flex; align-items:center; justify-content:center;">
                                                        <i class="bi bi-pencil-fill"></i>
                                                    </label>

                                                    <!-- Delete Icon -->
                                                    <form
                                                        action="{{ route('kshati.delete.single', [$patient->id, $index]) }}"
                                                        method="POST" class="position-absolute top-0 end-0 m-1">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            onclick="return confirm('हटाउन चाहनुहुन्छ?')"
                                                            class="bg-danger text-white rounded-circle border-0 p-1"
                                                            style="width:28px; height:28px;">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>
                                                    </form>

                                                </div>

                                                <!-- Hidden Update Form -->
                                                <form action="{{ route('kshati.update.single', [$patient->id, $index]) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <input type="file" id="edit_photo_{{ $index }}"
                                                        name="new_photo" class="d-none" onchange="this.form.submit()">
                                                </form>

                                            </div>
                                        @endforeach

                                        <!-- Add New Photo -->
                                        <div class="col-4 col-md-3 col-lg-2 mb-3">
                                            <form action="{{ route('kshati.add', $patient->id) }}" method="POST"
                                                enctype="multipart/form-data"
                                                class="border border-secondary rounded d-flex flex-column justify-content-center align-items-center p-3"
                                                style="height:120px; cursor:pointer;">
                                                @csrf

                                                <label for="add_new_photo" class="text-center text-secondary"
                                                    style="cursor:pointer;">
                                                    <i class="bi bi-plus-circle fs-1"></i>
                                                    <p class="m-0 fs-6">फोटो थप्नुहोस्</p>
                                                </label>

                                                <input id="add_new_photo" type="file" name="new_photo" class="d-none"
                                                    onchange="this.form.submit()" required>
                                            </form>
                                        </div>

                                    </div>
                                @else
                                    <!-- No photos -->
                                    <form action="{{ route('kshati.add', $patient->id) }}" method="POST"
                                        enctype="multipart/form-data" class="mt-2">
                                        @csrf
                                        <input type="file" name="new_photo"
                                            class="form-control form-control-sm w-50 mb-2" required>
                                        <button class="btn btn-sm btn-success">फोटो थप्नुहोस्</button>
                                    </form>
                                @endif
                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>

        <div class="my-4"></div>


    </div>
@endsection
