@php
$address = App\Address::find(municipalityId());
@endphp
<div class="card z-depth-0 border-0">

    <div class="card-body">
        <form action="{{ route(\Request::route()->getName()) }}" method="GET">
            <div class="row">
                @if (request('all') == 1)
                <input type="hidden" name="all" value="1" id="">
                <input type="hidden" name="fiscal_year" value="{{ request('fiscal_year') }}" id="">
                @endif
                <input type="hidden" name="diseaseType" value="{{ request('diseaseType') }}">
                @if (\Request::route()->getName() == 'organization.report.index')
                <div class="col-md-3">
                    <input type="text" name="name" class="form-control rounded-0 mb-2"
                        value="{{ request()->query('name') }}" placeholder="पिडितको नाम">
                </div>
                <div class="col-md-3">
                    @if (request('disease_id'))
                    <select name="disease_id" id="" class="custom-select rounded-0 mb-2">
                        <option value="">सबै प्रकोपहरु</option>
                        @foreach ($diseases as $disease)
                        <option value="{{ $disease->id }}"
                            {{ request('disease_id') == $disease->id ? 'selected' : '' }}>
                            {{ $disease->name }}
                        </option>
                        @endforeach
                    </select>
                    @else
                    <select name="disease_id" id="" class="custom-select rounded-0 mb-2">
                        <option value="">सबै प्रकोपहरु</option>
                        @foreach ($diseases as $disease)
                        <option value="{{ $disease->id }}">{{ $disease->name }}</option>
                        @endforeach
                    </select>
                    @endif
                </div>

                @if (request('fiscal_year'))

                <div class="col-md-2">
                    <select name="fiscal_year" class="custom-select kalimati-font rounded-0 mb-2">
                        <option value="">सबै आर्थिक बर्ष</option>
                        @foreach (\App\FiscalYear::latest()->get() as $fiscalYear)
                        <option value="{{ $fiscalYear->id }}"
                            {{ request('fiscal_year') == $fiscalYear->id ? 'selected' : '' }}>
                            {{ englishToNepaliLetters($fiscalYear->name) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @else
                <div class="col-md-2">
                    <select name="fiscal_year" class="custom-select kalimati-font rounded-0 mb-2">
                        <option value="">सबै आर्थिक बर्ष</option>
                        @foreach (\App\FiscalYear::latest()->get() as $fiscalYear)
                        <option value="{{ $fiscalYear->id }}"
                            {{ currentFiscalYear()->id == $fiscalYear->id ? 'selected' : '' }}>
                            {{ englishToNepaliLetters($fiscalYear->name) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @endif

                <div class="col-md-2">
                    @if (request('ward'))
                    <select name="ward" class="form-control mb-2 " id="">
                        <option value="">सबै वाड</option>
                        @for ($item = 1; $item <= $address->total_ward_number; $item++)
                            <option value="{{ $item }}"
                                {{ request('ward') == $item ? 'selected' : '' }}>
                                वडा {{ $item }}</option>
                            @endfor
                    </select>
                    @else
                    <select name="ward" class="form-control mb-2" id="">
                        <option value="">वाड छान्नुहोस्</option>
                        @for ($item = 1; $item <= $address->total_ward_number; $item++)
                            <option value="{{ $item }}">
                                वडा {{ $item }}</option>
                            @endfor
                    </select>
                    @endif

                </div>
                <div class="col-md-2">
                    @if (request('gender'))
                    <select name="gender" class="form-control mb-2" id="">
                        <option value="">लिङ्ग छान्नुहोस्</option>
                        <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>पुरुष
                        </option>
                        <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>महिला
                        </option>
                        <option value="Other" {{ request('gender') == 'Other' ? 'selected' : '' }}>अन्य
                        </option>
                    </select>
                    @else
                    <select name="gender" class="form-control mb-2" id="">
                        <option value="">लिङ्ग छान्नुहोस्</option>
                        <option value="Male">पुरुष</option>
                        <option value="Female">महिला</option>
                        <option value="Other">अन्य</option>
                    </select>
                    @endif
                </div>

                

                @php
                $url = url()->current() . '?diseaseType=' . request('diseaseType');
                @endphp
                @elseif (\Request::route()->getName() == 'organization.report.dirghaReport')
                <div class="col-md-3">
                    <input type="text" name="name" class="form-control rounded-0 mb-2"
                        value="{{ request()->query('name') }}" placeholder="बिरामीको नाम">
                </div>
                <div class="col-md-3">
                    @if (request('disease_id'))
                    <select name="disease_id" id="" class="custom-select rounded-0 mb-2">
                        <option value="">सबै प्रकोपहरु</option>
                        @foreach ($diseases as $disease)
                        <option value="{{ $disease->id }}"
                            {{ request('disease_id') == $disease->id ? 'selected' : '' }}>
                            {{ $disease->name }}
                        </option>
                        @endforeach
                    </select>
                    @else
                    <select name="disease_id" id="" class="custom-select rounded-0 mb-2">
                        <option value="">सबै प्रकोपहरु</option>
                        @foreach ($diseases as $disease)
                        <option value="{{ $disease->id }}">{{ $disease->name }}</option>
                        @endforeach
                    </select>
                    @endif
                </div>
                <div class="col-md-2">
                    @if (request('quarter'))
                    <select name="quarter" id="" class="form-control">

                        <option value="1" {{ request('quarter') == 1 ? 'selected' : '' }}>प्रथम त्रैमासिक
                        </option>
                        <option value="2" {{ request('quarter') == 2 ? 'selected' : '' }}>द्वितीय
                            त्रैमासिक</option>
                        <option value="3" {{ request('quarter') == 3 ? 'selected' : '' }}>तृतीय त्रैमासिक
                        </option>
                        <option value="4" {{ request('quarter') == 4 ? 'selected' : '' }}>चौथो त्रैमासिक
                        </option>
                    </select>
                    @else
                    <select name="quarter" id="" class="form-control">

                        <option value="1" {{currentquarter() == 1 ? 'selected' : ''}}>प्रथम त्रैमासिक</option>
                        <option value="2" {{currentquarter() == 2 ? 'selected' : ''}}>द्वितीय त्रैमासिक</option>
                        <option value="3" {{currentquarter() == 3 ? 'selected' : ''}}>तृतीय त्रैमासिक</option>
                        <option value="4" {{currentquarter() == 4 ? 'selected' : ''}}>चौथो त्रैमासिक</option>
                    </select>
                    @endif
                </div>
                @if (request('fiscal_year'))

                <div class="col-md-2">
                    <select name="fiscal_year" class="custom-select kalimati-font rounded-0 mb-2">
                        <option value="">सबै आर्थिक बर्ष</option>
                        @foreach (\App\FiscalYear::latest()->get() as $fiscalYear)
                        <option value="{{ $fiscalYear->id }}"
                            {{ request('fiscal_year') == $fiscalYear->id ? 'selected' : '' }}>
                            {{ englishToNepaliLetters($fiscalYear->name) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @else
                <div class="col-md-2">
                    <select name="fiscal_year" class="custom-select kalimati-font rounded-0 mb-2">
                        <option value="">सबै आर्थिक बर्ष</option>
                        @foreach (\App\FiscalYear::latest()->get() as $fiscalYear)
                        <option value="{{ $fiscalYear->id }}"
                            {{ currentFiscalYear()->id == $fiscalYear->id ? 'selected' : '' }}>
                            {{ englishToNepaliLetters($fiscalYear->name) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @endif

                <div class="col-md-2">
                    @if (request('ward'))
                    <select name="ward" class="form-control mb-2 " id="">
                        <option value="">सबै वाड</option>
                        @for ($item = 1; $item <= $address->total_ward_number; $item++)
                            <option value="{{ $item }}"
                                {{ request('ward') == $item ? 'selected' : '' }}>
                                वडा {{ $item }}</option>
                            @endfor
                    </select>
                    @else
                    <select name="ward" class="form-control mb-2" id="">
                        <option value="">वाड छान्नुहोस्</option>
                        @for ($item = 1; $item <= $address->total_ward_number; $item++)
                            <option value="{{ $item }}">
                                वडा {{ $item }}</option>
                            @endfor
                    </select>
                    @endif

                </div>

                <div class="col-md-2 ">
    <select name="status" class="form-control mb-2">
        <option value="">नविकरण स्थिति </option>
        <option value="renewed" {{ request('status') == 'renewed' ? 'selected' : '' }}>नविकरण भएका</option>
        <option value="not_renewed" {{ request('status') == 'not_renewed' ? 'selected' : '' }}>नविकरण नभएका </option>
    </select>
</div>
<div class="col-md-2 col-sm-6 px-1" style="min-width:140px">
    <select name="payment_status" class="form-control mb-2">
        <option value="">भुक्तानी स्थिति </option>
        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>भुक्तानी भएको</option>
        <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>भुक्तानी नभएको</option>
    </select>
</div>
                <div class="col-md-2">
                    @if (request('gender'))
                    <select name="gender" class="form-control mb-2" id="">
                        <option value="">लिङ्ग छान्नुहोस्</option>
                        <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>पुरुष
                        </option>
                        <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>महिला
                        </option>
                        <option value="Other" {{ request('gender') == 'Other' ? 'selected' : '' }}>अन्य
                        </option>
                    </select>
                    @else
                    <select name="gender" class="form-control mb-2" id="">
                        <option value="">लिङ्ग छान्नुहोस्</option>
                        <option value="Male">पुरुष</option>
                        <option value="Female">महिला</option>
                        <option value="Other">अन्य</option>
                    </select>
                    @endif
                </div>

                @php
                $url = url()->current() . '?diseaseType=' . request('diseaseType');
                @endphp
                @else
                {{-- <div class="form-group"> --}}
                @if (\Request::route()->getName() == 'newApplication')
                <div class="col-md-2 col-sm-6 px-1" style="min-width:105px">
                    <input type="text" name="token_number"
                        class="form-control mb-2 rounded-0 kalimati-font"
                        value="{{ request()->query('token_number') }}" placeholder="टोकन न.">
                </div>
                @else
                <div class="col-md-2 col-sm-6 px-1" style="min-width:105px">
                    <input type="text" name="registration_number"
                        class="form-control mb-2 rounded-0 kalimati-font"
                        value="{{ request()->query('registration_number') }}" placeholder="दर्ता नं.">
                </div>
                @endif
                <div class="col-md-3 col-sm-6 px-1" style="min-width:134px">
                    <input type="text" name="name" class="form-control rounded-0 mb-2"
                        value="{{ request()->query('name') }}" placeholder="पिडितको नाम">
                </div>
                <div class="col-md-3 col-sm-6 px-1" style="min-width:140px">
                    <input type="text" name="nno" class="form-control rounded-0 mb-2 kalimati-font"
                        value="{{ request()->query('nno') }}" placeholder=" नागरिकता नं.">
                </div>
                <div class="col-md-2 col-sm-6 px-1" style="min-width:120px">
                    <input type="text" name="mobile" class="form-control rounded-0 mb-2 kalimati-font"
                        value="{{ request()->query('mobile') }}" placeholder="मोबाइल नं.">
                </div>
                @if (request('all') == 1)
                <div class="col-md-2 col-sm-6 px-1" style="min-width:140px">
                    <select name="fiscal_year" class="custom-select kalimati-font rounded-0 mb-2">
                        <option value="">सबै आर्थिक बर्ष</option>
                        @foreach (\App\FiscalYear::latest()->get() as $fiscalYear)
                        <option value="{{ $fiscalYear->id }}"
                            {{ request('fiscal_year') == $fiscalYear->id ? 'selected' : '' }}
                            {{ $irRunning->id == $fiscalYear->id ? 'selected' : '' }}>
                            {{ englishToNepaliLetters($fiscalYear->name) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @else
                <div class="col-md-2 col-sm-6 px-1" style="min-width:140px">
                    <select name="fiscal_year" class="custom-select kalimati-font rounded-0 mb-2">
                        <option value="">सबै आर्थिक बर्ष</option>
                        @foreach (\App\FiscalYear::latest()->get() as $fiscalYear)
                        <option value="{{ $fiscalYear->id }}"
                            @if (request('fiscal_year')==$fiscalYear->id) selected @endif>
                            {{ englishToNepaliLetters($fiscalYear->name) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @endif
                @if (!request('all'))
                <div class="col-md-2 col-sm-6 px-1" style="min-width:140px">
                    @if (request('disease_id'))
                    <select name="disease_id" id="" class="custom-select rounded-0 mb-2">
                        <option value="">सबै प्रकोपहरु</option>
                        @foreach ($diseases as $disease)
                        <option value="{{ $disease->id }}"
                            {{ request('disease_id') == $disease->id ? 'selected' : '' }}>
                            {{ $disease->name }}
                        </option>
                        @endforeach
                    </select>
                    @else
                    <select name="disease_id" id="" class="custom-select rounded-0 mb-2">
                        <option value="">सबै प्रकोपहरु</option>
                        @foreach ($diseases as $disease)
                        <option value="{{ $disease->id }}">{{ $disease->name }}</option>
                        @endforeach
                    </select>
                    @endif

                </div>
                @else
                <div class="col-md-2 col-sm-6 px-1" style="min-width:120px">
                    <select name="application_type" id="applicationType" class="form-control mb-2">
                        <option value="">सबै प्रकोपहरु</option>
                        @foreach (App\ApplicationType::get() as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 col-sm-6 px-1" style="min-width:120px">
                    <select name="disease_id" id="diseases_id" class="custom-select rounded-0 mb-2">
                        <option value="">सबै प्रकोपहरु</option>
                    </select>
                </div>
                @endif
                <div class="col-md-2 col-sm-6 px-1 mb-2" style="min-width:130px">
                    @if (request('ward'))
                    <select name="ward" class="mb-2 js-example-basic-single" id="">
                        <option value="">सबै वडा</option>
                        @for ($item = 1; $item <= $address->total_ward_number; $item++)
                            <option value="{{ $item }}"
                                {{ request('ward') == $item ? 'selected' : '' }}>
                                वडा {{ $item }}</option>
                            @endfor
                    </select>
                    @else
                    <select name="ward" class=" mb-2 js-example-basic-single" id="">
                        <option value="">सबै वडा</option>
                        @for ($item = 1; $item <= $address->total_ward_number; $item++)
                            <option value="{{ $item }}">
                                वडा {{ $item }}</option>
                            @endfor
                    </select>
                    @endif

                </div>
                <div class="col-md-2 col-sm-6 px-1" style="min-width:140px">
                    @if (request('gender'))
                    <select name="gender" class="form-control mb-2" id="">
                        <option value="">लिङ्ग छान्नुहोस्</option>
                        <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>पुरुष
                        </option>
                        <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>महिला
                        </option>
                        <option value="Other" {{ request('gender') == 'Other' ? 'selected' : '' }}>अन्य
                        </option>
                    </select>
                    @else
                    <select name="gender" class="form-control mb-2" id="">
                        <option value="">लिङ्ग छान्नुहोस्</option>
                        <option value="Male">पुरुष</option>
                        <option value="Female">महिला</option>
                        <option value="Other">अन्य</option>
                    </select>
                    @endif
                </div>



                @php
                $url =
                url()->current() .
                '?diseaseType=' .
                request('diseaseType') .
                '&fiscal_year=' .
                request('fiscal_year').'&ward='.session()->get('ward_number');
                @endphp
                @endif
                <div class="col m-0 p-0 d-flex">
                    <button type="submit" class="btn btn-info" style="position: relative;top:-5px"> <i
                            class="fa fa-filter"></i> फिल्टर</button>
                    <a href="{{ $url }}" class="btn btn-primary" style="position: relative;top:-5px"> <i
                            class="fas fa-sync-alt"></i> रिसेट गर्नुहोस्</a>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .sidebar1 {
        width: 100%;
        height: 100%;
        display: flex;
        visibility: hidden;
        opacity: 0;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 999;
        background-color: transparent;
        color: #ffffff;
        transition: visibility 0.3s, opacity 0.3s, backdrop-filter 0.3s;
        backdrop-filter: blur(1px);
        user-select: none;
        pointer-events: none;
        -mox-user-select: none;

    }

    main {
        width: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 auto;

        p {
            text-align: left;
        }
    }

    .width-100 {
        min-width: 100%;
        max-width: 100%;
    }

    .block-dom {
        width: calc(100% - 350px);
        height: 100%;
        opacity: 50%;
        position: absolute;
        top: 0;
        left: 0;
        background-color: var(--slate-500);
    }

    .sidebar1-content {
        width: 350px;
        opacity: 0;
        position: absolute;
        padding: 5px 20px;
        top: 0;
        bottom: 0;
        right: -350px;
        left: auto;
        background-color: transparent;
        color: #000 !important;
        outline: 3px solid #BA020A;
        border-radius: 4px 0 0 4px;
        overflow-y: scroll;
        transition: right 0.3s ease-in-out, opacity 0.3s ease-in-out;
        scroll-behavior: smooth;

        &::-webkit-scrollbar {
            width: 10px;
        }

        &::-webkit-scrollbar-track {
            border-radius: 8px;
            box-shadow: inset 0 0 5px var(--slate-600);
        }

        &::-webkit-scrollbar-thumb {
            background-color: var(--slate-400);
        }

        &::-webkit-scrollbar-thumb:hover {
            background-color: var(--slate-300);
        }
    }

    .sidebar1.show {
        visibility: visible;
        opacity: 1;
        pointer-events: auto;
        user-select: auto;
        -mox-user-select: auto;
    }

    .reality {
        position: relative;
    }

    .sidebar1.show .sidebar1-content {
        opacity: 1;
        right: 0;
    }

    .close-sidebar1 {
        width: 100%;
        z-index: 102;
        display: flex;
        justify-content: center;
        align-items: center;
        top: 0;
        right: 0;
        background-color: var(--red-400);
        color: var(--red-950);
        display: none;
    }
</style>


@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.7.2/axios.min.js"></script>
<script>
    $(document).ready(function() {
        $("#applicationType").change(() => {
            let id = $("#applicationType").val();
            var url = "{{ route('disease.getDisease', ':id') }}";
            url = url.replace(':id', id);

            axios.get(url).then((response) => {

                const selectElement = $(
                    '#diseases_id');
                selectElement.empty();
                selectElement.append($('<option>', {
                    value: "",
                    text: "सबै रोगहरु"

                }));
                $.each(response.data, function(index, item) {

                    selectElement.append($('<option>', {
                        value: item.id,
                        text: item.name

                    }));

                });
            })
        })
    })
</script>
@endpush