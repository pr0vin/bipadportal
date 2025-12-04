@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- @include('partials.bipanna-tab') --}}
        <div class="card z-depth-0 printableCard">
            <div class="card-body">

                <div class="d-flex align-items-center justify-content-end notPrintable">
                    <x-fiscal-year-component />
                    <button type="button" class="bg-transparent border-0 mr-2" id="report_print"><i
                            class="fa fa-print text-primary" aria-hidden="true"></i>
                        Print</button>
                    @php
                        $fullUrl = url()->full() . '?excel=1';
                    @endphp
                    <a href="{{ $fullUrl }}" class="bg-transparent border-0"><i class="fa fa-file-excel text-success"
                            aria-hidden="true"></i>
                        Excel</a>
                </div>

                <div class="my-3"></div>
                <div id="printReport" class="m-0 p-0">


                    <div class="mb-4 text-center kalimati-font">
                        <p style="font-weight:bold;font-size:16px " class="kalimati-font m-0 p-0">अनुसूची-10</p>
                        <p style="font-size:16px;font-weight:bold;" class="kalimati-font m-0 p-0"> ( दफा ३ उप दफा (५.घ) संग
                            सम्बन्धित)</p>
                        <h4 class="heading my-2" style="font-size: 20px;font-weight:bold;"> विपन्न नागरिकलाई कडा रोग
                            उपचारका
                            लागि
                            सिफारिस गरिएको प्रतिवेदन
                            फाराम</h4>
                    </div>

                    <div class="d-flex justify-content-end  ">
                        <div class="kalimati-font" style="width:200px"> मिति: {{ ad_to_bs(now()->format('Y-m-d')) }}</div>
                    </div>

                    <div class="kalimati-font">
                        <div class="">
                            स्थानीय तहको नाम : {{ App\Address::find(municipalityId())->municipality }}
                        </div>
                        <div class="text-center " style="font-weight:bold">
                            बार्षिक प्रतिवेदन
                        </div>
                        <div class="kalimati-font">
                            आर्थिक वर्ष: {{ $fiscalYear->name }}
                        </div>
                    </div>

                    <div class="py-4">
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
                                        <td class="text-center kalimati-font">{{ $hospitalTotalPatients[$hospitalId] ?? 0 }}
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>

                            </tbody>

                        </table>
                    </div>


                    <div class="container">
                        <div class="row ">
                            <div class="col">
                                <div class="kalimati-font">
                                    तयार गर्ने :
                                </div>
                                <div class="kalimati-font">
                                    नाम :
                                </div>
                                <div class="kalimati-font">
                                    पद :
                                </div>
                                <div class="kalimati-font">
                                    दस्तखत :
                                </div>
                            </div>

                            <div class="col">
                                <div class="kalimati-font">
                                    सदर गर्ने :
                                </div>
                                <div class="kalimati-font">
                                    नाम :
                                </div>
                                <div class="kalimati-font">
                                    पद :
                                </div>
                                <div class="kalimati-font">
                                    दस्तखत :
                                </div>
                            </div>
                        </div>
                    </div>

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
