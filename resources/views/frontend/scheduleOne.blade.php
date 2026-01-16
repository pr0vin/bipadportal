@extends('layouts.letter')

@section('content')
    @push('styles')
        <style>
            .doc-border {
                padding: 2px;
                border: 7px solid;
                border-image: url('<?php echo asset('assets/img/border-image-kite.png'); ?>') 33 / 7px / 0px repeat;
                border: 7px solid;
                border-image: url('<?php echo asset('assets/img/border-image-kite.png'); ?>') 33 / 7px / 0px repeat;
            }

            .doc-border-line {
                border: 5px solid;
                border-image: url(https://yari-demos.prod.mdn.mozit.cloud/en-US/docs/Web/CSS/CSS_Background_and_Borders/Border-image_generator/border-image-5.png) 12 / 5px / 0px repeat;
            }

            .doc-border>div {
                content: '';
                border: 2px solid #000;
            }

            .border {
                border: 2px solid #000 !important;
            }

            table {
                width: 100%;
            }

            table th,
            table td {
                font-size: 1em !important;
                border: 2px solid #000 !important;
                padding: 5px 10px;
            }

            .underline {
                border-bottom: 2px dashed #000;
                padding: 0 10px;
            }

            .underline1 {
                border-bottom: 1px dashed #000;
                padding: 0 10px;
            }

            .resizable-block {
                font-size: 20px !important
            }

            @media print {
                .underline1 {
                    border: none;
                    padding: 0 10px;
                }
            }
        </style>
    @endpush
    <div>
        <div class="p-4 resizable-block">
            <section>
                <div class="my-4"></div>
                <h2 class="font-weight-bold text-center">निवेदन</h2>
                <div class="ml-auto text-right resizable">
                    <div>
                        मिति:
                        <span class="nepali-date-today kalimati-font">
                            {{ englishToNepaliLetters(ad_to_bs(now()->format('Y-m-d'))) }}
                        </span>
                    </div>
                </div>

                <div class="d-flex mt-5">
                    <div class="resizable">
                        <p class="m-0 p-1">श्री {{ $patient->address->municipality }}को कार्यालय,
                            {{ $patient->address->district }}</p>
                    </div>
                </div>

                <div class="mt-5 text-center">
                    <span class="py-2">
                        विषय:- विपद् प्रभावित प्रमाणित गरिएको सम्बन्धमा ।
                    </span>
                </div>

                @php
                    $dateString = ad_to_bs($patient->applied_date);
                    $year = substr($dateString, 0, 4);
                    $month = substr($dateString, 5, 2);
                    $day = substr($dateString, 8, 8);
                @endphp

                <div class="d-flex mt-5">
                    <div class="resizable" style="text-align: justify">
                        <span class="ml-5">उपरोक्त विषयमा</span>

                        {{ $patient->address->municipality }}
                        <span class="kalimati-font"> {{ $patient->ward_number }}</span>
                        वडा नं. {{ $patient->tole }} गाउँ/टोल स्थायी ठेगाना भएको,

                        उमेर <span class="kalimati-font">{{ $patient->age }}</span> वर्षको,

                        <span class="kalimati-font"> {{ $patient->citizenship_number }} </span>
                        परिचयपत्र/नागरिकता/जन्मदर्ता नं.,

                        सम्पर्क नं. <span class="kalimati-font"> {{ $patient->mobile_number }} </span> भएको

                        श्री {{ $patient->contact_person }} को

                        <span class="kalimati-font"> {{ $year }} </span> साल
                        <span class="kalimati-font"> {{ $month }}</span> महिना
                        <span class="kalimati-font">{{ $day }}</span> गते

                        विपद्/आकस्मिक परिस्थितिबाट प्रभावित भएको प्रमाणित गर्न प्रस्तुत गरिएका कागजात तथा विवरणहरू सम्यक् रूपमा जाँचबुझ गर्दा उक्त विवरणहरू सही भएको प्रमाणित गर्दछु।
                    </div>
                </div>

                <br>

                <div>
                    <span>प्रमाणित गर्ने अधिकृतको </span> <br>
                    <span>दस्तखत:</span> <br>
                    <span>पुरा नाम थर: {{ $patient->doctor ? $patient->doctor->name : '' }}</span> <br>
                    <span>दर्जा : {{ $patient->doctor ? $patient->doctor->post : '' }}</span> <br>
                    <span>अधिकारीको दर्ता नं.: <span class="kalimati-font">{{ $patient->doctor ? $patient->doctor->nmc_no : '' }}</span></span> <br>
                    <span>संस्थाको छाप: </span> <br>
                </div>

            </section>
        </div>
    </div>
@endsection
