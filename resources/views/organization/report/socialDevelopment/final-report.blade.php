@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @include('partials.social-tab')
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
                        <p style="font-weight:bold;font-size:16px " class="kalimati-font m-0 p-0">अनुसूची-२</p>
                        <p style="font-size:16px;font-weight:bold;" class="kalimati-font m-0 p-0 "> ( दफा ४ उप दफा (1) को
                            खण्ड (घ) संग
                            सम्बन्धित
                            )</p>
                        <h4 class="heading my-2 " style="font-size: 20px;font-weight:bold; text-decoration:underline">
                            स्थानिय तहले राख्ने बिरामीको
                            अभिलेख </h4>
                    </div>
                    <div class="kalimati-font">
                        <div class="">
                            स्थानीय तहको नाम : {{ Auth::user()->municipality->municipality }}
                        </div>
                        <div>
                            आर्थिक वर्ष: {{ $fiscalYear->name }}
                        </div>
                    </div>
                    <div class="py-4">
                        <table class="table table-bordered table-sm table_print kalimati-font">
                            <thead class="font-noto">
                                <tr class="text-center" style="font-size: 11px">
                                    <th>क्र.स</th>
                                    <th>बिरामीको नाम</th>
                                    <th>उमेर </th>
                                    <th>लिङ्ग</th>
                                    <th style="width: 6rem">नागरिकता प्र.प.नं/ जन्मदर्ता नं. </th>
                                    <th>ठेगाना </th>
                                    <th style="width: 6rem">रोगको किसिम </th>
                                    <th> उपचार गरेको अस्पताल </th>
                                    <th>कैफियत </th>

                                </tr>




                            </thead>
                            <tbody>


                                @foreach ($patients as $patient)
                                    <tr>
                                        <td class="kalimati-font text-center">{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $patient->name }}
                                        </td>
                                        <td class="kalimati-font text-center">
                                            {{ $patient->age }}
                                        </td>
                                        <td>
                                            {{ $patient->gender == 'male' ? 'पुरुष' : 'महिला' }}
                                        </td>
                                        <td class="kalimati-font text-center">
                                            {{ $patient->citizenship_number }}
                                        </td>

                                        <td class="kalimati-font ">
                                            {{-- {{ $patient->ward_number }} - --}}
                                            {{ $patient->tole }}
                                        </td>
                                        <td class="kalimati-font ">
                                            {{ $patient->disease->name }}
                                        </td>
                                        <td class="kalimati-font text-center">
                                            {{ $patient->hospital ? $patient->hospital->name : '-' }}
                                        </td>
                                        <td class="kalimati-font ">
                                            {{-- {{ $patient->ward_number }} - --}}
                                            {{ $patient->description }}
                                        </td>
                                    </tr>
                                @endforeach

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
