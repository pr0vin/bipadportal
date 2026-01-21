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

                </div>
            </div>

            <div class="d-flex align-items-center justify-content-between p-0" style="width: 100%; max-width: 400px;">

                <div class="flex-grow-1 d-flex align-items-center justify-content-end gap-2"
                    style="overflow-x: auto; min-width: 249px;">
                    <button class="btn btn-link text-secondary d-none" id="btnPrintDecisionDoc">
                        <i class="fa fa-print text-primary me-1"></i>निर्णय पत्र
                    </button>

                    @if (\Request::route()->getName() == 'regLocation' && request('diseaseType') == 1)
                        <a href="{{ route('payment.procedure') }}" class="btn btn-link text-success"
                            style="min-width: 140px;">
                            <i class="far fa-file me-1"></i>भुक्तानी सिफारिस
                        </a>
                    @endif

                    <form action="{{ route('print-decision') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="ids" id="ids">
                        <button class="btn btn-link text-info d-none" id="btn_print_decision">
                            <i class="fa fa-file me-1"></i>निर्णय पत्र
                        </button>
                    </form>

                    <a href="{{ request()->fullUrlWithQuery(['export' => true]) }}" target="_blank"
                        class="btn btn-link text-success" style="min-width: 70px;">
                        <i class="far fa-file-excel me-1"></i>Export
                    </a>

                    <button class="btn btn-link text-primary d-flex align-items-center" style="min-width: 60px;"
                        id="btnPrint">
                        <i class="fa fa-print me-1"></i>Print
                    </button>

                    @if (auth()->user()->roles[0]->name != 'ward-secretary')
                        <button id="filterButton" class="btn btn-outline-info px-2 py-1 d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-filter me-1" viewBox="0 0 16 16">
                                <path
                                    d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5" />
                            </svg>
                            Filter
                        </button>
                    @endif
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
            <x-organization-filter-bar :diseases="$diseases" :deasiseTypes="$deasiseTypes" />

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
                    @if (Illuminate\Support\Facades\Route::currentRouteName() == 'regLocation')
                        <th>
                            <input type="checkbox" id="selectAll">
                        </th>
                    @endif
                    @if (Illuminate\Support\Facades\Route::currentRouteName() == 'newApplication')
                        <th>टोकन नं.</th>
                        <th>आवेदन मिति</th>
                        <th>पिडितको नाम</th>
                        <th>लिङ्ग</th>
                        <th>घटना</th>
                        <th>सम्पर्क व्यक्ति नाम थर</th>
                    @elseif (Illuminate\Support\Facades\Route::currentRouteName() == 'renewedPatient' ||
                            Illuminate\Support\Facades\Route::currentRouteName() == 'dateExpiredPatient')
                        <th>दर्ता नं.</th>
                        <th>नबिकरण मिति</th>
                        <th>पिडितको नाम</th>
                        <th>घटना </th>
                        <th>प्रकोप</th>
                        <th>सम्पर्क व्यक्ति नाम थर</th>
                    @elseif (Illuminate\Support\Facades\Route::currentRouteName() == 'closedPatient')
                        <th>दर्ता नं.</th>
                        <th>लगतकट्टा मिति</th>
                        <th>पिडितको नाम</th>
                        <th>घटना </th>
                        <th>प्रकोप</th>
                        <th>सम्पर्क व्यक्ति नाम थर</th>
                    @else
                        <th>दर्ता नं.</th>
                        <th>दर्ता मिति</th>
                        <th>पिडितको नाम</th>
                        <th>लिङ्ग</th>
                        <th>घटना </th>
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
                        @if (Illuminate\Support\Facades\Route::currentRouteName() == 'regLocation')
                            <td><input type="checkbox" class="myCheckbox" value="{{ $organization->id }}"></td>
                        @endif

                        @if (Illuminate\Support\Facades\Route::currentRouteName() == 'newApplication')
                            <td class="kalimati-font">{{ $organization->onlineApplication->token_number }}</td>

                            <td class="kalimati-font">

                                {{ $organization->applied_date ? ad_to_bs(Carbon\Carbon::parse($organization->applied_date)->format('Y-m-d')) : 'N\A' }}
                            </td>
                        @elseif (Illuminate\Support\Facades\Route::currentRouteName() == 'renewedPatient' ||
                                Illuminate\Support\Facades\Route::currentRouteName() == 'dateExpiredPatient')
                            <td class="kalimati-font">
                                @if ($organization->reg_number)
                                    {{ $organization->reg_number }} ({{ $organization->registration_number }})
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
                                    {{ $organization->reg_number }} ({{ $organization->registration_number }})
                                @else
                                @endif
                            </td>
                            <td class="kalimati-font">
                                {{ $organization->closed_date ? dateFormat($organization->closed_date) : '' }}
                            </td>
                        @else
                            <td class="kalimati-font">
                                @if ($organization->reg_number)
                                    {{ $organization->reg_number }} ({{ $organization->registration_number }})
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

                        <td>{{ $organization->patientApplication->first()->application_type->name }}</td>

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
                            @elseif (is_null($organization->status))
                                <span class="badge badge-info z-depth-0 px-2 py-1">निर्णय नभएको</span>
                            @elseif ($organization->status === 'paid')
                                <span class="badge badge-danger z-depth-0 px-2 py-1">भुक्तानी भएको</span>
                            @else
                                <span class="badge badge-success z-depth-0 px-2 py-1">निर्णय भएको</span>
                            @endif
                        </td>

                        <td class="m-0 p-0 notPrintable" style="min-width: 150px">

                            <a class="btn btn-primary btn-sm font-noto z-depth-0" style="margin-top: 5px"
                                href="{{ route('patient.show', $organization) }}?isRecommended={{ $isrecommended }}&isRegistered={{ $isRegistered }}"><i
                                    class="fa fa-eye"></i></a>
                            <form action="{{ route('patient.destroy', $organization) }}" method="POST"
                                class="d-inline"
                                onsubmit="return confirm('के तपाइँ यो रेकर्ड मेटाउन निश्चित हुनुहुन्छ?')">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm font-noto  z-depth-0" style="margin-top: 9px"
                                    type="submit"><i class="fa fa-trash"></i>
                                    </butt>
                            </form>
                        </td>
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
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.row-checkbox');
    const btnPrint = document.getElementById('btn_print_decision');
    const inputIds = document.getElementById('ids');

    function updateStatus() {
        const ids = [];

        checkboxes.forEach(cb => {
            if (cb.checked) ids.push(cb.value);
        });

        inputIds.value = ids.length ? JSON.stringify(ids) : "";

        btnPrint.classList.toggle('d-none', ids.length === 0);
    }

    // Row checkbox click
    checkboxes.forEach(cb => {
        cb.addEventListener('change', function () {
            selectAll.checked = [...checkboxes].every(c => c.checked);
            updateStatus();
        });
    });

    // Select all
    if (selectAll) {
        selectAll.addEventListener('change', function () {
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateStatus();
        });
    }

});
</script>
