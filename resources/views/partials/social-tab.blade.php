<div class="card mb-2 z-depth-0 notPrintable">
    <div class="card-body">
        <form action="{{ route(\Request::route()->getName()) }}" method="GET">
            @if (\Request::route()->getName() == 'organization.diseaseWiseReport')
                <input type="hidden" name="diseaseType" value="2">
            @endif
            <div class="row">
                @php
                    $diseases = App\Disease::latest()
                        ->whereHas('application_types', function ($query) {
                            $query->where('application_types.id', 3);
                        })
                        ->get();
                    $wards = App\Address::find(municipalityId());
                @endphp
                <div class="col-md-3 mb-2">
                    @if (request('disease_id'))
                        <select id="" name="disease_id" class="form-control">
                            <option value="">सबै रोगहरु</option>
                            @foreach ($diseases as $item)
                                <option value="{{ $item->id }}"
                                    {{ $item->id == request('disease_id') ? 'selected' : '' }}>{{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    @else
                        <select id="" name="disease_id" class="form-control">
                            <option value="">सबै रोगहरु</option>
                            @foreach ($diseases as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>

                    @endif
                </div>

                @if (request('ward_number'))
                    <div class="col-md-3 mb-2">
                        <select name="ward_number" id="" class="form-control">
                            <option value="">वाड छान्नुहोस्</option>
                            @php
                                for ($i = 1; $i <= $wards->total_ward_number; $i++) {
                                    $num = englishToNepaliLetters($i);
                                    $selected = $i == request('ward_number') ? 'selected' : '';
                                    echo "<option value=\"$i\" $selected>वाड $num</option>";
                                }
                            @endphp
                        </select>
                    </div>
                @else
                    <div class="col-md-3 mb-2">
                        <select name="ward_number" id="" class="form-control">
                            <option value="">वाड छान्नुहोस्</option>
                            @php
                                for ($i = 1; $i <= $wards->total_ward_number; $i++) {
                                    $num = englishToNepaliLetters($i);
                                    echo "<option value=\"$i\">वाड $num</option>";
                                }
                            @endphp
                        </select>
                    </div>
                @endif
                <div class="col-md-3 mb-2">

                    <input type="text" value="{{ request('date_from') ? request('date_from')[0] : '' }}"
                        name="date_from" class="form-control nepali-date" id="input-date-from"
                        placeholder="दर्ता मिति (देखि)">
                </div>
                <div class="col-md-3 mb-2">

                    <input type="text" value="{{ request('date_to') ? request('date_to')[0] : '' }}" name="date_to"
                        class="form-control nepali-date" id="input-date-from" placeholder="दर्ता मिति (सम्म)">
                </div>

                {{-- <div class="col-md-4 mb-2">
                    @if (request('gender'))
                        <select name="gender" id="" class="form-control">
                            <option value="">लिङ्ग छान्नुहोस्</option>
                            <option value="female" {{request('gender') == 'female' ? 'selected' : ''}}>महिला</option>
                            <option value="male" {{request('gender') == 'male' ? 'selected' : ''}}>पुरुष</option>
                            <option value="other" {{request('gender') == 'other' ? 'selected' : ''}}>अन्य</option>
                        </select>
                    @else
                        <select name="gender" id="" class="form-control">
                            <option value="">लिङ्ग छान्नुहोस्</option>
                            <option value="female">महिला</option>
                            <option value="male">पुरुष</option>
                            <option value="other">अन्य</option>
                        </select>
                    @endif
                </div> --}}
                <div class="col-md-4">
                    <button class="btn btn-info"> <i class="fa fa-filter"></i> फिल्टर</button>
                </div>
            </div>
        </form>
    </div>
</div>
