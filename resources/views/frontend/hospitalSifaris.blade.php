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
        <x-municipality-letterhead></x-municipality-letterhead>
        <div class="p-4 resizable-block">

            <section>
                <div class="my-4"></div>
                <div class="d-flex justify-content-between resizable">
                    <div>
                        <span class="kalimati-font">पत्र स: {{App\FiscalYear::where('is_running',1)->first()->name}}</span> <br>
                        <span class="kalimati-font">च.न:</span>
                    </div>
                    <div>मिति: <span class="nepali-date-today kalimati-font">{{ englishToNepaliLetters(ad_to_bs(now()->format('Y-m-d'))) }}</span>
                    </div>
                </div>


                <div class="mt-5 d-flex justify-content-center">
                    <span class="py-2">
                        विषय:- बिपन्न नागरिक औसधि उपचार सिफारिस सम्बन्धमा ।
                    </span>
                </div>

                <div class="mt-4">
                    <span class="py-2">
                        श्री {{ $patient->hospital->name }}
                    </span>
                </div>

                <div class="d-flex mt-3">
                    <div class="resizable">
                        <span class="ml-5">उपरोक्त सम्बन्धमा {{ $patient->address->municipality }} वडा न:
                            <span class="kalimati-font">{{ englishToNepaliLetters($patient->ward_number) }} मा बस्ने</span> {{ $patient->name }} ले मिति <span class="kalimati-font"> {{ ad_to_bs($patient->applied_date) }} </span> गते दिनु
                            भएको निबेदन र वडाको सिफारिस अनुसारको व्यहोरा अवगत भई निजको बुबा श्री {{ $patient->name }}
                            "{{ $patient->disease->name }}" बाट पिडितरहेको बुझिन आएकोले "बिपन्न नागरिक उपचार निर्देशिका
                            २०७७" बमोजिम निजको नि:शुल्क उपचारसेवा उपलब्ध गराई दिनु हुन सिफारिस का साथ अनुरोध छ ।
                    </div>
                </div>

                <div class="d-flex mt-5">
                    <div class="resizable col-12 m-0 p-0">
                        <div class="d-flex justify-content-between align-items-end">
                            <div class="">
                                <u>बोधार्थ</u>
                                <div class="d-flex">
                                    श्रीस्वास्थ्य सेवाबिभाग टेकु, काठमाडौँ
                                </div>
                            </div>
                            <div>
                                <div class="float-right">
                                    <div class="underline1 px-3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                </div>
                            </div>
                        </div>
                    </div>



                    {{-- <p>सार्वजनिक खरिद नियमावली, २०६४ को नियम १८ को उपनियम (१) बमोजिम तपशिलमा उल्लिखित
                विवरण अनुसारको पुष्ट्याई गर्ने कागजात संलग्न गरी मौजुदा सूचीमा दर्ता हुन यो निवेदन पेश गरेको छु ।</p>

            <table>
                <tr>
                    <td colspan="2">
                        मौजुदा सूचीको लागि निवेदन दिने व्यक्ति, संस्था, आपूर्तिकर्ता, निर्माण व्यवसायी, परामर्शदाता वा सेवा प्रदायकको विवरण :
                    </td>
                </tr>
                <tr>
                    <td>(1) नाम : {{ $patient->name }}</td>
                    <td>(2) ठेगाना : {{ $patient->address }}</td>
                </tr>
                <tr>
                    <td>(3) सम्पर्क व्यक्ति : {{ $patient->contact_person }}</td>
                    <td>(4) इमेल : {{ $patient->email }}</td>
                </tr>
                <tr>
                    <td>(5) टेलिफोन नं. : {{ $patient->contact }}</td>
                    <td>(6) मोवाईल नं. : {{ $patient->mobile }}</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div>
                            2. मौजुदा सूचीमा दर्ता हुनको लागि संलग्न प्रमाणपत्र :
                        </div>
                        <div class="pl-4">
                            <div>
                                <span><input type="checkbox" @if ($patient->reg_cert) checked @endif></span>
                                <span>संस्था वा फर्म दर्ताको प्रमाणपत्र</span>
                            </div>
                            <div>
                                <span><input type="checkbox" @if ($patient->renew_cert) checked @endif></span>
                                <span>नविकरण गरेको प्रमाण-पत्र</span>
                            </div>
                            <div>
                                <span><input type="checkbox" @if ($patient->pan_cert) checked @endif></span>
                                <span>मूल्य अभिवृद्धि कर वा स्थायी लेखा नम्बर दर्ताको प्रमाणपत्र</span>
                            </div>
                            <div>
                                <span><input type="checkbox" @if ($patient->tax_cert) checked @endif></span>
                                <span>कर चुक्ताको प्रमाणपत्र</span>
                            </div>
                            <div>
                                <span><input type="checkbox" @if ($patient->license_cert) checked @endif></span>
                                <span>कुन खरिदको लागि मौजुदा सूचीमा दर्ता हुन निवेदन दिने हो, सो कामको लागि इजाजत पत्र आवश्यक पर्ने भएमा सो को प्रतिलिपि</span>
                            </div>
                            <div>
                                <span><input type="checkbox" @if ($patient->receipt) checked @endif></span>
                                <span>भुक्तानी गरेको रसिद वा बैंक भाैचर</span>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div>3. सार्वजनिक निकायबाट हुने खरिदको लागि दर्ता हुन चाहेको खरिदको प्रकृतिको विवरण:</div>
                        <div class="pl-4">
                            {{ optional($patient->suchiType)->title }} : {{ $patient->product_type }}
                        </div>
                    </td>
                </tr>
            </table> --}}

                    {{-- <div class="mt-5"></div>

            <div class="d-flex justify-content-between resizable">
                <div>
                    <div>निवेदन दिएको मिति :- <span class="nepali-date-today kalimati-font"></span></div>
                    <div>आ.ब. <span class="kalimati-font">{{ active_fiscal_year()->name }}</span></div>
                    <div>Token No: <span class="font-weight-semibold">{{ $patient->token_no }}</span></div>
                </div>
                <div>
                    <div>फर्मको छाप :</div>
                </div>
                <div>
                    <div>निवेदको नाम: {{ $patient->contact_person }}</div>
                    <div>हस्ताक्षर:</div>
                </div>
            </div>
 --}}
                    <div class="mt-2">
                        <qr-code value="{{ $patient->token_no }}" :size="100"></qr-code>
                    </div>
            </section>
        </div>
    </div>
@endsection
