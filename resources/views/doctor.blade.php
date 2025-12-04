@extends('layouts.app')

@push('styles')
    <style>
        #dashboard {
            min-height: 100vh;
            padding: 1rem;
        }

        a.bg-white {
            color: #1f2d3d !important;
        }

        .dashboard-main-title {
            font-weight: bold;
            display: flex;
            justify-content: center;
            color: #7d8888;
            font-size: 14px;
        }

        .dashboard-card-title {
            font-weight: bold;

        }

        .underline {
            border-bottom: 2px dashed #000;
            padding: 0 10px;
        }
    </style>
@endpush

@section('content')
    <div class="px-5">
        <div class="card z-depth-0 mb-3 notPrintable">
            <div class="card-body">
                <x-token-search-form />
            </div>
        </div>

        <div class="card z-depth-0 cardPrints">
            <div class="card-body cardPrints">
                <div class="d-flex justify-content-end notPrintable">
                    <button class="bg-transparent border-0" onclick="window.print()"><i
                            class="fa fa-print mr-2"></i>Print</button>
                </div>
                <div>
                    <div class="p-4 resizable-block cardPrints" contenteditable="true">
                        <section>
                            <div class="my-4"></div>
                            <h4 class="font-weight-bold text-center">अनुसूची-१ </h4>
                            <h4 class="font-weight-bold text-center">(दफा-३ संग सम्बन्धित)</h4>
                            <h5 class="font-weight-bold col-12 text-center">चिकित्सकले मृगौला प्रत्यारोपन गरेको/डायलाइसिस
                                गराइरहेको/क्यान्सर रोग/मेरुदण्ड
                                पक्षघात भएको प्रमाणित गर्ने ढाँचा</h5>

                            <div class="ml-auto text-right resizable">
                                <div>मिति: <span
                                        class="nepali-date-today kalimati-font">{{ englishToNepaliLetters(ad_to_bs(now()->format('Y-m-d'))) }}</span>
                                </div>
                            </div>
                            <div class="d-flex mt-5">
                                <div class="resizable">
                                    <p class="m-0 p-1">श्री
                                        {{ $patient ? $patient->address->municipality : 'डेमो नगरपालिका' }}को कार्यालय,</p>
                                </div>
                            </div>
                            <div class="mt-5 text-center">
                                <span class="py-2">
                                    विषय:- प्रमाणित गरएको सम्बन्धमा ।
                                </span>
                            </div>

                            <div class="d-flex mt-5">
                                @php
                                    if ($patient) {
                                        $dateString = ad_to_bs($patient->applied_date);
                                        $year = substr($dateString, 0, 4);
                                        $month = substr($dateString, 5, 2);
                                        $day = substr($dateString, 8, 8);
                                    }
                                @endphp
                                <div class="resizable" style="text-align: justify">
                                    <span class="ml-5">उपरोक्त बिषयमा</span>
                                    @if ($patient)
                                        {{ $patient->address->municipality }}
                                    @else
                                        <span class="underline"></span>
                                    @endif
                                    @if ($patient)
                                        <span class="kalimati-font">{{ $patient->ward_number }}</span>
                                    @else
                                        <span class="underline"></span>
                                    @endif
                                    वडा नं.
                                    @if ($patient)
                                        <span class="kalimati-font">{{ $patient->tole }}</span>
                                    @else
                                        <span class="underline"></span>
                                    @endif
                                    गाउँ/टोल स्थयी ठेगाना भएको उमेर
                                    @if ($patient)
                                        <span class="kalimati-font">{{ $patient->age }}</span>
                                    @else
                                        <span class="underline"></span>
                                    @endif
                                    बर्षको
                                    @if ($patient)
                                        <span class="kalimati-font">{{ $patient->citizenship_number }}</span>
                                    @else
                                        <span class="underline"></span>
                                    @endif
                                    राष्ट्रिय परिचयपत्र
                                    नं./नागरिकता प्रमाणपत्र नं./जन्मदर्ता प्रमाणपत्र नं. (१६ बर्ष भन्दा कम उमेरको हकमा)
                                    @if ($patient)
                                        <span class="kalimati-font">{{ $patient->mobile_number }}</span>
                                    @else
                                        <span class="underline"></span>
                                    @endif सम्पर्क नं. भएको
                                    श्री
                                    @if ($patient)
                                        {{ $patient->name }}
                                    @else
                                        <span class="underline"></span>
                                    @endif
                                    को @if ($patient)
                                        <span class="kalimati-font">{{ $year ?? '' }}</span>
                                    @else
                                        <span class="underline"></span>
                                    @endif साल
                                    @if ($patient)
                                        <span class="kalimati-font">{{ $month ?? '' }}</span>
                                    @else
                                        <span class="underline"></span>
                                    @endif
                                    महिना
                                    @if ($patient)
                                        <span class="kalimati-font">{{ $day ?? '' }}</span>
                                    @else
                                        <span class="underline"></span>
                                    @endif गते श्री
                                    @if ($patient)
                                    @else
                                        <span class="underline"></span>
                                    @endif
                                    अस्पतालमा
                                    रोग निदान भएको भनि अस्पतालहरुको पुर्जी/
                                    कागजातहको विवरण जाँच बुझ गरि प्रमाणित गर्दछु।
                                </div> <br>

                            </div> <br>
                            <div>
                                <span>प्रमाणित गर्ने चिकित्सकको </span> <br>
                                <span>दस्तखत:</span> <br>
                                <span>पुरा नाम थर: </span> {{ Auth::user()->name }} <br>
                                <span>दर्जा : </span> {{ Auth::user()->profile->post }} <br>
                                <span>नेपाल मेडिकल काउन्सिल न: <span
                                        class="kalimati-font">{{ Auth::user()->profile->nmc_no }}</span></span> <br>
                                <span>संस्थाको छाप: </span> <br>
                            </div>

                            {{--
                            <div class="mt-2">
                                <qr-code value="{{ $patient->token_no }}" :size="100"></qr-code>
                            </div> --}}
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
