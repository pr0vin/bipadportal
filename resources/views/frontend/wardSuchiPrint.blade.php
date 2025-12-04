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
                {{-- <h4 class="font-weight-bold text-center">अनसची-२</h4>
                <h4 class="font-weight-bold text-center">(दफा ३ सग सम्बन्धित)</h4>
                <h5 class="font-weight-bold col-12 text-center">औषधि उपचार बापत खर्च पाउनका लागि दिने निबेदनको ढाँचा</h5> --}}

                <div class="ml-auto text-right resizable">
                    <div>मिति: <span
                            class="nepali-date-today kalimati-font">{{ englishToNepaliLetters(ad_to_bs(now()->format('Y-m-d'))) }}</span>
                    </div>
                </div>
                <div class="mt-5 text-center">
                    <span class="py-2">
                        विषय:- औषधि उपचार बापत खर्च पाउँ भन्ने सम्बन्धमा ।
                    </span>
                </div>
                <div class="d-flex mt-5">
                    <div class="resizable">
                        <p class="m-0 p-1">श्री वडाध्यक्षज्यु, <br>
                            वडा नं. <span class="kalimati-font">{{ $patient->ward_number }}</span>,
                            {{ $patient->address->municipality }} <br>
                            जिल्ला {{ $patient->address->district }}, {{ $patient->address->province }}</p>
                    </div>
                </div>
                <div class="d-flex mt-5" style="text-align: justify">
                    @php
                        $dateString = ad_to_bs($patient->applied_date);
                        $year = substr($dateString, 0, 4);
                        $month = substr($dateString, 5, 2);
                        $day = substr($dateString, 8, 8);
                    @endphp
                    <div class="resizable">
                        <span class="ml-5">उपरोक्त सम्बन्धमा</span>
                        {{ $patient->address->municipality }} <span class="kalimati-font">
                            {{ $patient->ward_number }}</span> वडा नं. {{ $patient->tole }}
                        गाउँ/टोल स्थयी ठेगाना भएको उमेर <span class="kalimati-font">{{ $patient->age }}</span> बर्षको <span
                            class="kalimati-font"> {{ $patient->citizenship_number }} </span> राष्ट्रिय परिचयपत्र
                        नं./नागरिकता प्रमाणपत्र नं./जन्मदर्ता प्रमाणपत्र नं. (१६ बर्ष भन्दा कम उमेरको हकमा) <span
                            class="kalimati-font"> {{ $patient->mobile_number }} </span> सम्पर्क नं. भएको
                        म {{ $patient->name }} {{ $patient->disease->name }} रोग निदान भएको व्यक्ति भएकोले सम्पूर्ण आवश्यक
                        कागजात सहित औषधि उपचार बापत मासिक पाँच हजार रुपियाँका दरले खर्च पाउँ भनि निबेदान पेश गरेको छु | पेश
                        भएको व्यहोरा ठिक साँचो हो,झुट्ठा ठहरे प्रचलित कानुन बमोजिम बुझाउला |
                    </div> <br>

                </div> <br>
                <div>
                    <b><u>निवेदक:</u></b> <br>
                    <span>हस्ताक्षर:</span> <br>
                    @php
                        $patientGender = '';
                        if (strtolower($patient->gender) == 'female') {
                            $patientGender="महिला";
                        }elseif (strtolower($patient->gender) == 'male') {
                            $patientGender="पुरुष";
                        }else{
                            $patientGender="अन्य";
                        }
                    @endphp
                    <span>नाम थर: {{ $patient->name }}</span>, लिङ्ग: <span>{{ $patientGender }}</span> <br>
                    <span>राष्ट्रिय परिचयपत्र नं./नागरिकता प्रमाणपत्र नं./जन्मदर्ता प्रमाणपत्र नं. : <span
                            class="kalimati-font"> {{ $patient->citizenship_number }} </span></span> <br>
                    <span>बैंकखाता नं.: <span class="kalimati-font"> {{ $patient->bank_account_number }}</span></span> <br>
                    <span>बैंकको नाम: </span> <br>
                    <span>शाखा: </span> <br>
                    <span>सम्पर्क मोबाइल नं.: <span class="kalimati-font"> {{ $patient->mobile_number }} </span></span>
                    <br>
                </div>

                {{--
                <div class="mt-2">
                    <qr-code value="{{ $patient->token_no }}" :size="100"></qr-code>
                </div> --}}
            </section>
        </div>
    </div>
@endsection
