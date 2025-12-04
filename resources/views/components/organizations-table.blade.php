<div class="card">
    <div class="card-header bg-white notPrintable">
        <div class="d-flex justify-content-between">
            <div class="d-block">
                @if (request('diseaseType'))
                <h4 class="font-weight-bold font-nep " style="font-size: 20px;">
                    {{ App\ApplicationType::find(request('diseaseType'))->name }}
                    पिडित
                    तालिका
                </h4>
                @endif
                
                @if (request('all') == 1)
                <h5 class="font-weight-bold">सबै आबेदनहरु</h5>
                @endif
                @if (Illuminate\Support\Facades\Route::currentRouteName() == 'renewedPatient')
                <h5 class="font-weight-bold">नबिकरण भएका</h5>
                @endif
                @if (Illuminate\Support\Facades\Route::currentRouteName() == 'dateExpiredPatient')
                <h5 class="font-weight-bold">नबिकरण नभएका</h5>
                @endif

                <div style="font-size: 14px " class="text-secondary">
                    @if (Illuminate\Support\Facades\Route::currentRouteName() == 'newApplication')
                    हाल <span class="kalimati-font"> {{ englishToNepaliLetters($organizations->total()) }} </span>
                    वटा
                    आबेदन
                    प्राप्त भएको
                    छ ।
                    @endif
                    @if (Illuminate\Support\Facades\Route::currentRouteName() == 'regLocation')
                    @if (request('diseaseType') == 1)
                    हाल <span class="kalimati-font"> {{ englishToNepaliLetters($organizations->total()) }}
                    </span>
                    वटा आबेदन
                    सिफारिस
                    भएको
                    छ ।
                    @else
                    हाल <span class="kalimati-font"> {{ englishToNepaliLetters($organizations->total()) }}
                    </span>
                    वटा आबेदन
                    दर्ता
                    भएको
                    छ ।
                    @endif
                    @endif
                    @if (Illuminate\Support\Facades\Route::currentRouteName() == 'closedPatient')
                    हाल <span class="kalimati-font"> {{ englishToNepaliLetters($organizations->total()) }} </span>
                    वटा
                    आबेदन
                    लागतकात्त
                    भएको
                    छ ।
                    @endif
                    @if (Illuminate\Support\Facades\Route::currentRouteName() == 'renewedPatient')
                    हाल <span class="kalimati-font"> {{ englishToNepaliLetters($organizations->total()) }} </span>
                    वटा
                    आबेदन
                    नबिकरण
                    भएको
                    छ ।
                    @endif
                    @if (Illuminate\Support\Facades\Route::currentRouteName() == 'dateExpiredPatient')
                    हाल <span class="kalimati-font"> {{ englishToNepaliLetters($organizations->total()) }} </span>
                    वटा
                    नबिकरण
                    नभएको आबेदन
                    छ ।
                    @endif
                </div>
            </div>
            {{-- <div class="d-flex">
                <a href="#" class="btn btn-info"> <i class="fa fa-print"></i> Print</a>
                <a href="#" class="btn btn-info"> <i class="fa fa-file"></i> Export</a>
            </div> --}}
        </div>
        <div class="d-flex row justify-content-between my-3 px-3">
            <div class="d-flex align-items-center" style="width: 80px">
                <button class="form-control kalimati-font form-control-sm  rounded d-inline text-secondary"
                    type="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">{{ request('per_page') ?? config('constants.organization.per_page') }}</button>
                <span class="flex-shrink-0 align-self-center text-secondary pl-2 font-nep" style="font-weight:100">
                    &nbsp;@lang('app.records_per_page')
                </span>
                <div class="dropdown-menu">
                    <a href="{{ request()->fullUrlWithQuery(['per_page' => 20]) }}" class="dropdown-item kalimati-font"
                        name="closed_date" value="true">20</a>
                    <a href="{{ request()->fullUrlWithQuery(['per_page' => 50]) }}" class="dropdown-item kalimati-font"
                        name="registered_date" value="true">50</a>
                    <a href="{{ request()->fullUrlWithQuery(['per_page' => 100]) }}"
                        class="dropdown-item kalimati-font" name="renewed" value="true">100</a>
                    <a href="{{ request()->fullUrlWithQuery(['per_page' => 200]) }}"
                        class="dropdown-item kalimati-font" name="renewed" value="true">200</a>
                    {{-- <a href="{{ request()->fullUrlWithQuery(['per_page' => 0]) }}" class="dropdown-item kalimati-font"
                    name="renewed" value="false">सबै</a> --}}
                </div>
            </div>

            <div style="width:400px" class=" p-0">
                <div class="ml-auto m-0 p-0" style="min-width:249px;overflow-x:scroll">
                    <div class="d-flex align-items-center justify-content-end text-secondary" style="grid-gap: 1rem;">
                        <button class="bg-transparent border-0 z-depth-0 text-secondary d-none"
                            id="btnPrintDecisionDoc"><i class="fa fa-print mr-2 text-primary"></i>निर्णय पत्र</button>
                        @if (\Request::route()->getName() == 'regLocation')
                        @if (request('diseaseType') == 1)
                        {{-- <a class="z-depth-0" href="{{ route('payment.procedure') }}" style=" min-width: 100px"><i
                            class="fa fa-money-bill pr-2 text-info"></i>भुक्तानी सिफारिस</a> --}}
                        <a class=" z-depth-0" href="{{ route('payment.procedure') }}"
                            style="min-width: 140px" class=""><i class="far fa-file mr-2 text-success"></i>भुक्तानी
                            सिफारिस</a>
                        @endif
                        @endif
                        <form action="{{ route('print-decision') }}" method="POST">
                            @csrf
                            <input type="hidden" name="ids" id="ids">
                            <button class="bg-transparent border-0  text-muted px-2 py-1 d-none"
                                id="btn_print_decision"> <i class="fa fa-file text-info pr-2"></i> निर्णय पत्र</button>
                        </form>
                        <a class=" z-depth-0" href="{{ request()->fullUrlWithQuery(['export' => true]) }}"
                            style="min-width: 70px" target="_blank"><i
                                class="far fa-file-excel mr-2 text-success"></i>Export</a>
                        <button class="bg-transparent border-0 z-depth-0 text-secondary d-flex align-items-center" style="min-width: 60px"
                            id="btnPrint" target="_blank"><i class="fa fa-print mr-2 text-primary"></i>Print</button>
                        @if (auth()->user()->roles[0]->name != 'ward-secretary')
                        <div>
                            <button id="filterButton" class="btn btn-outline-info  px-2 py-1"> <svg
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-filter" viewBox="0 0 16 16">
                                    <path
                                        d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5" />
                                </svg> filter</button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="notPrintable">
        <div id="filterSection" class="{{ auth()->user()->roles[0]->name == 'ward-secretary' ? 'd-block' : '' }}"
            style="display: none">
            @php
            $diseases = App\ApplicationType::find(request('diseaseType') ?? 1)->diseases;
            @endphp
            <x-organization-filter-bar :diseases="$diseases"></x-organization-filter-bar>
        </div>
    </div>
    
    <div class="card-body" style="overflow:scroll">
        <div class="col-12 mb-4 printable">
            <h3 class="text-center font-weight-bold">{{ App\Address::find(municipalityId())->municipality }}</h3>
            @if (request('diseaseType'))
            <h5 class="text-center font-weight-bold">{{ App\ApplicationType::find(request('diseaseType'))->name }}
                पिडितको तालिका</h5>
            @else
            <h5 class="text-center font-weight-bold">{{ App\ApplicationType::find(1)->name }}
                पिडितको तालिका</h5>
            @endif
            @if (request('diseaseType') == 1)
            @if (\Request::route()->getName() == 'newApplication')
            <label class="col-12 text-center">(आबेदन फारमहरु)</label>
            @elseif(\Request::route()->getName() == 'regLocation')
            <label class="col-12 text-center">(दर्ता भएका)</label>
            @endif
            @else
            @if (\Request::route()->getName() == 'newApplication')
            <label class="col-12 text-center">(आबेदन फारमहरु)</label>
            @elseif(\Request::route()->getName() == 'regLocation')
            <label class="col-12 text-center">(सिफारिस भएका)</label>
            @endif
            @endif
            @if (\Request::route()->getName() == 'closedPatient')
            <label class="col-12 text-center">(लागतकट्टा भएका)</label>
            @elseif(\Request::route()->getName() == 'renewedPatient')
            <label class="col-12 text-center">(नबिकरण भएका)</label>
            @elseif(\Request::route()->getName() == 'dateExpiredPatient')
            <label class="col-12 text-center">(नबिकरण नभएका)</label>
            @endif
        </div>

        <table class="table table-hover table-borderless"
            style=" border-collapse: separate; border-spacing: 0 0;min-width:900px;position: relative;">
            <thead class="bg-deep-blue text-white font-15px" style=" z-index: 10;">
                <tr>
                    @if (Illuminate\Support\Facades\Route::currentRouteName() == 'newApplication')
                    {{-- @if (request('diseaseType') == 2) --}}
                    <th></th>
                    {{-- @endif --}}
                    <th>टोकन नं.</th>
                    <th>आवेदन मिति</th>
                    <th>पिडितको नाम</th>
                    <th>लिंग</th>
                    <th>प्रकोप</th>
                    <th>सम्पर्क व्यक्ति नाम थर</th>
                    @elseif (Illuminate\Support\Facades\Route::currentRouteName() == 'renewedPatient' ||
                    Illuminate\Support\Facades\Route::currentRouteName() == 'dateExpiredPatient')
                    <th>दर्ता नं.</th>
                    <th>नबिकरण मिति</th>
                    <th>पिडितको नाम</th>
                    <th>लिंग</th>
                    <th>प्रकोप</th>
                    <th>सम्पर्क व्यक्ति नाम थर</th>
                    @elseif (Illuminate\Support\Facades\Route::currentRouteName() == 'closedPatient')
                    <th>दर्ता नं.</th>
                    <th>लगतकट्टा मिति</th>
                    <th>पिडितको नाम</th>
                    <th>लिंग</th>
                    <th>प्रकोप</th>
                    <th>सम्पर्क व्यक्ति नाम थर</th>
                    @else
                    <th>दर्ता नं.</th>
                    <th>दर्ता मिति</th>
                    <th>पिडितको नाम</th>
                    <th>लिंग</th>
                    @if (request('all') == 1)
                    <th>रोगको प्रकार</th>
                    @endif
                    <th>रोग</th>
                    <th>सम्पर्क व्यक्ति नाम थर</th>
                    @endif

                    <th class="notPrintable"></th>
                    <th class="notPrintable"></th>
                </tr>
            </thead>
            @csrf
            <tbody>
                @forelse($organizations as $organization)
                <tr class=" m-0 p-0" style="margin: 0;">
                    @if (Illuminate\Support\Facades\Route::currentRouteName() == 'newApplication')

                    {{-- @if (request('diseaseType') == 2) --}}
                    <td><input type="checkbox" class="myCheckbox" name="" value="{{ $organization->id }}" id=""></td>
                    {{-- @endif --}}

                    <td class="kalimati-font">{{ $organization->onlineApplication->token_number }}</td>

                    <td class="kalimati-font">
                       
                        {{ $organization->applied_date ? ad_to_bs(Carbon\Carbon::parse($organization->applied_date)->format('Y-m-d')) : 'N\A' }}
                    </td>

                    
                    @elseif (Illuminate\Support\Facades\Route::currentRouteName() == 'renewedPatient' ||
                    Illuminate\Support\Facades\Route::currentRouteName() == 'dateExpiredPatient')
                    <td class="kalimati-font">
                        @if ($organization->reg_number)

                        {{ $organization->reg_number }} ({{$organization->registration_number}})
                        @else

                        @endif
                    </td>

                    <td class="kalimati-font">
                        @if ($organization->renews()->count() > 0)
                        {{ dateFormat($organization->renewed_date) }}
                        @endif
                    </td>
                    @elseif (Illuminate\Support\Facades\Route::currentRouteName() == 'closedPatient')
                    <td class="kalimati-font">
                        @if ($organization->reg_number)

                        {{ $organization->reg_number }} ({{$organization->registration_number}})
                        @else

                        @endif
                    </td>
                    <td class="kalimati-font">
                        {{ $organization->closed_date ? dateFormat($organization->closed_date) : '' }}
                    </td>
                    @else
                    <td class="kalimati-font">
                        @if ($organization->reg_number)

                        {{ $organization->reg_number }} ({{$organization->registration_number}})
                        @else

                        @endif
                    </td>
                    <td class="kalimati-font">
                        {{ $organization->registered_date ? dateFormat($organization->registered_date) : 'Not registered' }}
                    </td>
                    @endif
                    <td>
                        <div>{{ $organization->name }} <br> {{ $organization->name_en }}</div>
                        <div class="text-muted">
                        </div>
                    </td>
                    <td>
                        @if ($organization->gender == 'Male' || $organization->gender == 'male' || strtolower($organization->gender) == 'male')
                        पुरुष
                        @elseif (
                        $organization->gender == 'Female' ||
                        $organization->gender == 'female' ||
                        strtolower($organization->gender) == 'female')
                        महिला
                        @else
                        अन्य
                        @endif
                    </td>
                    @if (request('all') == 1)
                    <td>{{ $organization->disease->application_types[0]->name }}</td>
                    @endif

                    <td>{{ $organization->disease->name }}</td>

                    <td>
                        <div>
                            {{ $organization->contact_person }}
                        </div>
                        @if ($organization->mobile_number)
                        <div class="text-muted kalimati-font" style="font-size: .8rem;">फोन नं.
                            {{ $organization->mobile_number }}
                        </div>
                        @endif
                    </td>


                    <td class="font-noto notPrintable">
                        @if (\Request::route()->getName() == 'newApplication')
                        <span class="badge badge-warning z-depth-0 px-2 py-1">दर्ता नभएको</span>
                        @elseif(\Request::route()->getName() == 'regLocation')
                        <span class="badge badge-info z-depth-0 px-2 py-1">दर्ता भएको</span>
                        @elseif(\Request::route()->getName() == 'closedPatient')
                        <span class="badge badge-danger z-depth-0 px-2 py-1">लागतकट्टा भएको</span>
                        @elseif(\Request::route()->getName() == 'renewedPatient')
                        <span class="badge badge-success z-depth-0 px-2 py-1">नविकरण भएको</span>
                        @elseif(\Request::route()->getName() == 'dateExpiredPatient')
                        <span class="badge badge-danger z-depth-0 px-2 py-1">नविकरण नभएको</span>
                        @endif
                    </td>

                    {{-- @if ($organization->disease->application_types[0]->id == 1) --}}
                    <td class="m-0 p-0 notPrintable" style="min-width: 150px">
                        {{-- @can('dirgha.show') --}}
                        <a class="btn btn-primary btn-sm font-noto z-depth-0" style="margin-top: 5px"
                            href="{{ route('patient.show', $organization) }}?isRecommended={{ $isrecommended }}&isRegistered={{ $isRegistered }}"><i
                                class="fa fa-eye"></i></a>
                        {{-- @endcan --}}
                        {{-- @can('dirgha.delete') --}}
                        <form action="{{ route('patient.destroy', $organization) }}" method="POST"
                            class="d-inline"
                            onsubmit="return confirm('के तपाइँ यो रेकर्ड मेटाउन निश्चित हुनुहुन्छ?')">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger btn-sm font-noto  z-depth-0" style="margin-top: 9px"
                                type="submit"><i class="fa fa-trash"></i>
                                </butt>
                        </form>
                        {{-- @endcan --}}
                    </td>
                    {{-- @endif --}}

                    {{-- @if ($organization->disease->application_types[0]->id == 2)
                    <td class="m-0 p-0 notPrintable" style="min-width: 150px">
                        @can('bipanna.show')
                        <a class="btn btn-primary btn-sm font-noto z-depth-0" style="margin-top: 5px"
                            href="{{ route('patient.show', $organization) }}?isRecommended={{ $isrecommended }}&isRegistered={{ $isRegistered }}"><i
                                class="fa fa-eye"></i></a>
                        @endcan
                        @can('bipanna.delete')
                        <form action="{{ route('patient.destroy', $organization) }}" method="POST"
                            class="d-inline"
                            onsubmit="return confirm('के तपाइँ यो रेकर्ड मेटाउन निश्चित हुनुहुन्छ?')">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger btn-sm font-noto  z-depth-0" style="margin-top: 9px"
                                type="submit"><i class="fa fa-trash"></i>
                                </button>
                        </form>
                        @endcan
                    </td>
                    @endif --}}

                    {{-- @if ($organization->disease->application_types[0]->id == 3)
                    <td class="m-0 p-0 notPrintable" style="min-width: 150px">
                        @can('samajik.show')
                        <a class="btn btn-primary btn-sm font-noto z-depth-0" style="margin-top: 5px"
                            href="{{ route('patient.show', $organization) }}?isRecommended={{ $isrecommended }}&isRegistered={{ $isRegistered }}"><i
                                class="fa fa-eye"></i></a>
                        @endcan
                        @can('samajik.delete')
                        <form action="{{ route('patient.destroy', $organization) }}" method="POST"
                            class="d-inline"
                            onsubmit="return confirm('के तपाइँ यो रेकर्ड मेटाउन निश्चित हुनुहुन्छ?')">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger btn-sm font-noto  z-depth-0" style="margin-top: 9px"
                                type="submit"><i class="fa fa-trash"></i>
                            </button>
                        </form>
                        @endcan
                    </td>
                    @endif --}}

                    {{-- @if ($organization->disease->application_types[0]->id == 4)
                    <td class="m-0 p-0 notPrintable" style="min-width: 150px">
                        @can('nagarpalika.show')
                        <a class="btn btn-primary btn-sm font-noto z-depth-0" style="margin-top: 5px"
                            href="{{ route('patient.show', $organization) }}?isRecommended={{ $isrecommended }}&isRegistered={{ $isRegistered }}"><i
                                class="fa fa-eye"></i></a>
                        @endcan
                        @can('nagarpalika.delete')
                        <form action="{{ route('patient.destroy', $organization) }}" method="POST"
                            class="d-inline"
                            onsubmit="return confirm('के तपाइँ यो रेकर्ड मेटाउन निश्चित हुनुहुन्छ?')">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger btn-sm font-noto  z-depth-0" style="margin-top: 9px"
                                type="submit"><i class="fa fa-trash"></i>
                                </butt>
                        </form>
                        @endcan
                    </td>
                    @endif --}}

                </tr>
                @empty
                <tr>
                    <td class="bg-white text-center text-danger font-18px" colspan="42">** यहाँ कुनै डाटा
                        छैन |
                        **</td>
                </tr>
                @endforelse
            </tbody>
            </form>
        </table>

    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.7.7/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterButton = document.getElementById('filterButton');
        const filterSection = document.getElementById('filterSection');

        filterButton.addEventListener('click', function() {
            if (filterSection.style.display === 'none') {
                filterSection.style.display = 'block';

            } else {
                filterSection.style.display = 'none';

            }
        });
        let patientIds = [];

        $(".selectRow").on('click', (event) => {
            if (event.target.checked) {
                patientIds = [...patientIds, event.target.value];
            } else {
                patientIds = patientIds.filter(num => num != event.target.value);
            }
            showHideButton();
        })

        function showHideButton() {
            if (patientIds.length <= 0) {
                $("#btnPrintDecisionDoc").addClass('d-none');
            } else {
                $("#btnPrintDecisionDoc").removeClass('d-none');

            }
        }
        $("#btnPrintDecisionDoc").click(() => {
            let action = "{{ route('decisionDocuments') }}";
            // const form = document.getElementById('decisionDocuments');
            // form.action = action;
            // form.method = 'post';
            // form.submit();


            // axios.post(action,patientIds).then(response){

            // }
        })
    });
</script>


<script>
    const checkboxes = document.getElementsByClassName('myCheckbox');
    const statusText = document.getElementsByClassName('status')[0];
    const btnPrint = document.getElementById('btn_print_decision');
    let checkedValues = [];
    const inputIds = document.getElementById('ids');
    const updateStatus = () => {
        let checkedCount = 0;

        for (let checkbox of checkboxes) {
            if (checkbox.checked) {
                checkedCount++;
                // checkedValues.push(checkbox.value);
                if (!checkedValues.includes(checkbox.value)) {
                    checkedValues.push(checkbox.value);
                    console.log(checkedValues)
                    inputIds.value = JSON.stringify(checkedValues);
                }
            }
        }
        if (checkedCount > 0) {
            if (btnPrint.classList.contains("d-none")) {
                btnPrint.classList.remove("d-none");
                console.log("=========================");
                console.log(checkedValues)
            }
        } else {
            btnPrint.classList.add("d-none");
            inputIds.value = "";
        }
    };

    for (let checkbox of checkboxes) {
        checkbox.addEventListener('change', updateStatus);
    }
    // btnPrint.addEventListener('click', function() {
    //     let url = "{{ route('print-decision') }}";

    //     const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    //     fetch(url, {
    //             method: 'POST',
    //             headers: {
    //                 'Content-Type': 'application/json',
    //                 'X-CSRF-Token': csrfToken,
    //             },
    //             body: JSON.stringify({
    //                 checkedValues: checkedValues
    //             }),
    //         })
    //         .then(response => response.json())
    //         .then(result => {
    //             console.log('Success:', result);
    //         })
    //         .catch(error => {
    //             console.error('Error:', error);
    //         });
    // })
</script>