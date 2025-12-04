@php
    $address = App\Address::find(municipalityId());
@endphp
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @include('organization.report.dirghaReport.menu')
        <div class="card  border-0">
            <div class="card-body">
                <div class="blue lighten-5 notPrintable p-3 mb-3">
                <div class="card  z-depth-0 border-0  ">
                      <div class="card-body">
                        <form action="{{ route(\Request::route()->getName()) }}" method="GET">
                            <input type="hidden" value="{{ request('diseaseType') }}" name="diseaseType">
                            <div class="row">
                                <div class="col-md-2 px-2" style="min-width: 150px">
                                    <input type="text" name="name" class="form-control rounded-0 mb-2"
                                        value="{{ request()->query('name') }}" placeholder="बिरामीको नाम">
                                </div>
                                <div class="col-md-2 px-2" style="min-width: 150px">
                                    @if (request('disease_id'))
                                        <select name="disease_id" id="" class="custom-select rounded-0 mb-2">
                                            <option value="">सबै रोगहरु</option>
                                            @foreach ($diseases as $disease)
                                                <option value="{{ $disease->id }}"
                                                    {{ request('disease_id') == $disease->id ? 'selected' : '' }}>
                                                    {{ $disease->name }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <select name="disease_id" id="" class="custom-select rounded-0 mb-2">
                                            <option value="">सबै रोगहरु</option>
                                            @foreach ($diseases as $disease)
                                                <option value="{{ $disease->id }}">{{ $disease->name }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                                @if (request('fiscal_year'))
                                    <div class="col-md-2 px-2" style="min-width: 150px">
                                        <select name="fiscal_year" class="custom-select kalimati-font rounded-0 mb-2">
                                            <option value="">सबै आर्थिक बर्ष</option>
                                            @foreach (\App\FiscalYear::latest()->get() as $fiscalYear)
                                                <option value="{{ $fiscalYear->id }}"
                                                    {{ request('fiscal_year') == $fiscalYear->id ? 'selected' : '' }}>
                                                    {{ englishToNepaliLetters($fiscalYear->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @else
                                    <div class="col-md-2 px-2" style="min-width: 150px">
                                        <select name="fiscal_year" class="custom-select kalimati-font rounded-0 mb-2">
                                            <option value="">सबै आर्थिक बर्ष</option>
                                            @foreach (\App\FiscalYear::latest()->get() as $fiscalYear)
                                                <option value="{{ $fiscalYear->id }}"
                                                    {{ currentFiscalYear()->id == $fiscalYear->id ? 'selected' : '' }}>
                                                    {{ englishToNepaliLetters($fiscalYear->name) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                <div class="col-md-2 px-2" style="min-width: 150px">
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
                                <div class="col-md-2 px-2" style="min-width: 150px">
                                    @if (request('gender'))
                                        <select name="gender" class="form-control mb-2" id="">
                                            <option value="">लिङ्ग छान्नुहोस्</option>
                                            <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>
                                                पुरुष
                                            </option>
                                            <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>
                                                महिला
                                            </option>
                                            <option value="Other" {{ request('gender') == 'Other' ? 'selected' : '' }}>
                                                अन्य
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
                                <div class="col-md-2">
                                    @if (request('isPaid'))
                                        <select name="isPaid" id="" class="form-control">
                                            <option value="unpaid" {{request('isPaid') == 'unpaid' ? 'selected' : ''}}>भुक्तानी नभएको</option>
                                            <option value="paid" {{request('isPaid') == 'paid' ? 'selected' : ''}}>भुक्तानी भएको</option>
                                        </select>
                                    @else
                                        <select name="isPaid" id="" class="form-control">
                                            <option value="unpaid">भुक्तानी नभएको</option>
                                            <option value="paid">भुक्तानी भएको</option>
                                        </select>
                                    @endif
                                </div>
                                {{-- <div class="col-md-2">
                                    @if (request('status'))
                                        <select name="status" id="" class="custom-select rounded-0">
                                            <option value="">सबै</option>
                                            <option value="registered" {{ request('status') == 'registered' ? 'selected' : '' }}>
                                                दर्ता भएका</option>
                                            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>बन्द भएका
                                            </option>
                                            @if (request('diseaseType') == 1)
                                                <option value="renewed" {{ request('status') == 'renewed' ? 'selected' : '' }}>
                                                    नवीकरण भएका</option>
                                                <option value="not_renewed"
                                                    {{ request('status') == 'not_renewed' ? 'selected' : '' }}>नवीकरण नभएका
                                                </option>
                                            @endif
                                        </select>
                                    @else
                                        <select name="status" id="" class="custom-select rounded-0">
                                            <option value="">सबै</option>
                                            <option value="registered">दर्ता भएका</option>
                                            <option value="closed">बन्द भएका</option>
                                            @if (request('diseaseType') == 1)
                                                <option value="renewed">नवीकरण भएका</option>
                                                <option value="not_renewed">नवीकरण नभएका</option>
                                            @endif
                                        </select>
                                    @endif
                                </div> --}}
                                <div class="col-12 d-flex justify-content-end ">
                                    <button type="submit" class="btn btn-info" style="position: relative;top:-5px"> <i
                                            class="fa fa-filter"></i>फिल्टर</button>
                                    <a href="{{ route('organization.report.index') }}?diseaseType=1"
                                        class="btn btn-primary" style="position: relative;top:-5px"> <i
                                            class="fas fa-sync-alt"></i> रिसेट
                                        गर्नुहोस्</a>
                                </div>
                            </div>
                        </form>
                    </div>
                  </div>
                </div>
                <div class="col-12 d-flex justify-content-end mb-5 notPrintable">
                    <button class="bg-transparent border-0 mr-2" onclick="window.print()"><i class="fa fa-print"></i>
                        Print</button>
                    @php
                        $fullUrl = url()->full() . '&excel=1';
                    @endphp
                    <a href="{{ $fullUrl }}"><i class="fa fa-file-excel mr-1"></i>Excel</a>
                </div>
                <div class="col-12">
                    <h5 class="text-center font-weight-bold">अनुसूची-४</h5>
                    <h5 class="text-center font-weight-bold">(दफा ७ संग सम्बन्धित)</h5>
                    <h5 class="text-center font-weight-bold">औषधि उपचार बापत खर्च {{request('isPaid') == 'paid' ? 'पाएका' : 'पाउने'}} व्यक्तिहरुको अभिलेख 
                    </h5>
                </div>

                <div class="col-12 mt-3" style="overflow: scroll">
                    <table class="table table-bordered table-sm table_print kalimati-fon">
                        <tr class="text-center">
                            <th class="kalimati-font" colspan="8">अ.व. {{ currentFiscalYear()->name }}</th>
                            <th colspan="12">रकम भुक्तानी  {{request('isPaid') == 'paid' ? 'गरिएका' : 'गरिने'}} महिना</th>
                        </tr>
                        <tr class="text-center">
                            <th>क्र.स</th>
                            <th style="width: 50px">लाभग्रहिको नाम, थर</th>
                            <th>जन्म मिति</th>
                            <th>लिङ्ग</th>
                            <th>स्थायी ठेगाना</th>
                            <th>राष्ट्रिय परिचयपत्र नं/नागरिकता प्रमाणपत्र नं/जन्मदर्ता प्रमाणपत्र नं</th>
                            <th>लक्षित समूह</th>
                            <th>सिफारिस गर्ने चिकित्सकको बिवरण (नाम, कार्यरत संस्था र नेपाल मेडिकल काउन्सिल नं.)</th>
                            <th style="max-width:30px;min-width:30px">साउन</th>
                            <th style="max-width:30px;min-width:30px">भदौ</th>
                            <th style="max-width:30px;min-width:30px">असोज</th>
                            <th style="max-width:30px;min-width:30px">कार्तिक</th>
                            <th style="max-width:30px;min-width:30px">मङ्सिर</th>
                            <th style="max-width:30px;min-width:30px">पौष</th>
                            <th style="max-width:30px;min-width:30px">माघ</th>
                            <th style="max-width:30px;min-width:30px">फाल्गुण</th>
                            <th style="max-width:30px;min-width:30px">चैत्र</th>
                            <th style="max-width:30px;min-width:30px">बैशाख</th>
                            <th style="max-width:30px;min-width:30px">ज्येष्ठ</th>
                            <th style="max-width:30px;min-width:30px">आषाढ</th>
                        </tr>
                        @foreach ($patientsList as $patient)
                            <tr
                                class="{{ $patient['patient_closed_date'] ? 'text-decoration-line-through text-muted' : '' }}">
                                <td class="kalimati-font">{{ $loop->iteration }}</td>
                                <td>{{ $patient['patient_name'] }} <br> ({{ $patient['patient_name_en'] }})</td>
                                <td class="kalimati-font">{{ $patient['patient_dob'] }}</td>
                                @php
                                    $patientGender = '';
                                    if (strtolower($patient['patient_gender']) == 'female') {
                                        $patientGender = 'महिला';
                                    } elseif (strtolower($patient['patient_gender']) == 'male') {
                                        $patientGender = 'पुरुष';
                                    } else {
                                        $patientGender = 'अन्य';
                                    }
                                @endphp
                                <td>{{ $patientGender }}</td>
                                <td class="kalimati-font">{{ $patient['patient_address'] }}</td>
                                <td class="kalimati-font">{{ $patient['patient_citizenship_number'] }}</td>
                                <td></td>
                                @if ($patient['doctor'])
                                    <td class="kalimati-font">{{ $patient['doctor']->name }} <br> NMC
                                        No:-{{ $patient['doctor']->nmc_no }}</td>
                                @else
                                    <td></td>
                                @endif
                                {{-- @foreach ($months as $month)
                                    @php
                                        $isDataAvailable = false;
                                    @endphp
                                    @foreach ($patient['patient'] as $item)
                                        @if (renewMonth($item->next_renew_date) == $month)
                                            <td class="kalimati-font"> <i class="fa fa-check"></i></td>

                                            @php
                                                $isDataAvailable = true;
                                                break;
                                            @endphp
                                        @endif
                                    @endforeach
                                    @if (!$isDataAvailable)
                                        <td></td>
                                    @endif
                                @endforeach --}}

                                @foreach ($months as $month)
                                    @php
                                        $isDataAvailable = false;
                                    @endphp
                                    @foreach ($patient['patient'] as $item)
                                        @if ($month > renewMonth($item->next_renew_date) - $item->month && $month <= renewMonth($item->next_renew_date))
                                            <td><i class="fa fa-check"></i></td>
                                            @php
                                                $isDataAvailable = true;
                                            @endphp
                                        @endif
                                    @endforeach
                                    @if (!$isDataAvailable)
                                        <td></td>
                                    @endif
                                @endforeach


                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
