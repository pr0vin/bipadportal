@php
    $totalFemale = 0;
    $totalMale = 0;
    $totalOther = 0;
    $totalPatient = 0;
    $totalFemaleRegistered = 0;
    $totalMaleRegistered = 0;
    $totalOtherRegistered = 0;
    $totalPatientRegistered = 0;
@endphp
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @include('partials.bipanna-tab')
        <div class="card z-depth-0 printableCard">
            <div class="card-body">

                <div class="d-flex justify-content-end notPrintable">
                    <button type="button" class="bg-transparent border-0 mr-2" id="report_print"><i class="fa fa-print"
                            aria-hidden="true"></i>
                        Print</button>
                    @php
                        $fullUrl = url()->full() . '&excel=1';
                    @endphp
                    <a href="{{ $fullUrl }}" class="bg-transparent border-0"><i class="fa fa-file-excel"
                            aria-hidden="true"></i>
                        Excel</a>
                </div>

                <div class="my-3"></div>
                <div id="printReport" class="m-0 p-0">

                    <div clas="">
                        @if (Session()->get('municipality_id'))
                            <h3 class="text-center kalimati-font">
                                {{ App\Organization::where('address_id', Session()->get('municipality_id'))->first()->address->municipality }}
                            </h3>
                            <h5 class="text-center font-weight-bold">बिपन्न सहयोगको सिफारिस</h5>
                            <label class="kalimati-font col-12 text-center">(अ.ब. {{ currentFiscalYear()->name }})</label>
                        @endif

                    </div>

                    {{-- <div class="mb-4 text-center kalimati-font">
                        <p style="font-weight:bold;font-size:16px " class="kalimati-font m-0 p-0">अनुसूची-२</p>
                        <p style="font-size:16px;font-weight:bold;" class="kalimati-font m-0 p-0 "> ( दफा ४ उप दफा (1) संग
                            सम्बन्धित
                            )</p>
                        <h4 class="heading my-2" style="font-size: 20px;font-weight:bold;"> विपन्न नागरिकलाई कडा रोग उपचारका
                            लागि
                            सिफारिस गरिएको प्रतिवेदन
                            फाराम</h4>
                    </div>

                    <div class="d-flex justify-content-end  ">
                        <div class="kalimati-font" style="width:200px"> मिति: {{ ad_to_bs(now()->format('Y-m-d')) }}</div>
                    </div>

                    <div class="kalimati-font">
                        <div class="">
                            स्थानीय तहको नाम:
                        </div>
                        <div>
                            बार्षिक प्रतिवेदन:
                        </div>
                        <div>
                            आर्थिक वर्ष: {{ currentFiscalYear()->name }}
                        </div>
                    </div> --}}

                    {{-- <div class="py-4">
                        <table class="table table-bordered table-sm table_print kalimati-font">
                            <thead class="font-noto">


                                <tr class="text-center" style="font-size: 11px">
                                    <th rowspan="2">क्र.स</th>
                                    <th rowspan="2">अस्पतालको नाम</th>
                                    <th colspan="{{ count($diseaseNames) }}">सिफारिस गरिएको संख्या </th>
                                    <th rowspan="2">जम्मा बिरामी संख्या</th>
                                </tr>
                                <tr class="text-center" style="font-size: 11px">
                                    @foreach ($diseaseNames as $diseaseId => $diseaseName)
                                        <th>{{ $diseaseName }}</th>
                                    @endforeach

                                </tr>
                            </thead>
                            <tbody>
                            <tbody>
                                @foreach ($hospitalData as $hospitalId => $diseases)
                                    <tr>
                                        <td class="kalimati-font text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $hospitalNames[$hospitalId] ?? 'Unknown' }}</td>
                                        @foreach ($diseaseNames as $diseaseId => $diseaseName)
                                            <td class="text-center kalimati-font " style="width:60px">
                                                {{ isset($diseases[$diseaseId]) ? $diseases[$diseaseId] : '-' }}</td>
                                        @endforeach
                                        <td class="text-center kalimati-font">
                                            {{ $hospitalTotalPatients[$hospitalId] ?? 0 }}
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>

                            </tbody>

                        </table>
                    </div> --}}
                    <div class="py-4">
                        <table class="table table-bordered table-sm table_print kalimati-font">
                            <thead class="font-noto">


                                <tr class="text-center" style="font-size: 11px">
                                    <th rowspan="2">क्र.स</th>
                                    <th rowspan="2">अस्पतालको नाम</th>
                                    <th colspan="4">सिफारिस गरिएको संख्या </th>
                                    <th colspan="4">जम्मा बिरामी संख्या</th>
                                </tr>
                                <tr class="text-center" style="font-size: 11px">
                                    <th>महिला</th>
                                    <th>पुरुष</th>
                                    <th>अन्य</th>
                                    <th>जम्मा</th>

                                    <th>महिला</th>
                                    <th>पुरुष</th>
                                    <th>अन्य</th>
                                    <th>जम्मा</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patientLists as $patientList)
                                    <tr class="text-center">
                                        <td class="kalimati-font">{{ $loop->iteration }}</td>
                                        <td>
                                            @php
                                                print_r($patientList['disease']);
                                            @endphp
                                        </td>
                                        <td class="kalimati-font">
                                            @php
                                                print_r($patientList['female']);
                                                $totalFemale = $totalFemale + $patientList['female'];
                                            @endphp
                                        </td>
                                        <td class="kalimati-font">
                                            @php
                                                print_r($patientList['male']);
                                                $totalMale = $totalMale + $patientList['male'];
                                            @endphp
                                        </td>
                                        <td class="kalimati-font">
                                            @php
                                                print_r($patientList['other']);
                                                $totalOther = $totalOther + $patientList['other'];
                                            @endphp
                                        </td>
                                        <td class="kalimati-font">
                                            @php
                                                print_r($patientList['total']);
                                                $totalPatient = $totalPatient + $patientList['total'];
                                            @endphp
                                        </td>

                                        <td class="kalimati-font">
                                            @php
                                                print_r($patientList['femaleRegistered']);
                                                $totalFemaleRegistered =
                                                    $totalFemaleRegistered + $patientList['femaleRegistered'];
                                            @endphp
                                        </td>
                                        <td class="kalimati-font">
                                            @php
                                                print_r($patientList['maleRegistered']);
                                                $totalMaleRegistered =
                                                    $totalMaleRegistered + $patientList['maleRegistered'];
                                            @endphp
                                        </td>
                                        <td class="kalimati-font">
                                            @php
                                                print_r($patientList['otherRegistered']);
                                                $totalOtherRegistered =
                                                    $totalOtherRegistered + $patientList['otherRegistered'];

                                            @endphp
                                        </td>
                                        <td class="kalimati-font">
                                            @php
                                                print_r($patientList['totalRegistered']);
                                                $totalPatientRegistered =
                                                    $totalPatientRegistered + $patientList['totalRegistered'];

                                            @endphp
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="text-center">
                                    <td colspan="2">जम्मा</td>
                                    <td class="kalimati-font">{{ $totalFemale }}</td>
                                    <td class="kalimati-font">{{ $totalMale }}</td>
                                    <td class="kalimati-font">{{ $totalOther }}</td>
                                    <td class="kalimati-font">{{ $totalPatient }}</td>

                                    <td class="kalimati-font">{{ $totalFemaleRegistered }}</td>
                                    <td class="kalimati-font">{{ $totalMaleRegistered }}</td>
                                    <td class="kalimati-font">{{ $totalOtherRegistered }}</td>
                                    <td class="kalimati-font">{{ $totalPatientRegistered }}</td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="card mt-3 m-0 p-0"> --}}
        {{-- {{ $organizations->count() }} --}}
        {{-- <div class="card-body"> --}}

        {{-- @if ($organizations->hasPages())
            <div class="pagination d-flex justify-content-between pt-3 px-3">
                <div class="m-0 p-0">
                    Showing {{ $organizations->firstItem() }} to {{ $organizations->lastItem() }} of
                    {{ $organizations->total() }}
                    entries
                </div>
                {{ $organizations->appends(request()->input())->links() }}
            </div>
        @endif --}}
        {{-- </div> --}}
        {{-- </div> --}}
        @push('scripts')
            <script>
                $(document).ready(function() {

                    $("#report_print").click(() => {


                        window.print();


                    })
                })
            </script>
        @endpush

    </div>
@endsection
