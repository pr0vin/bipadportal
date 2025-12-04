<div>
    <div class="p-4 resizable-block">
        <section>
            <div class="my-4"></div>
            <div class="ml-auto text-right resizable">
                <div>मिति: <span
                        class="nepali-date-today kalimati-font">{{ englishToNepaliLetters(ad_to_bs(now()->format('Y-m-d'))) }}</span>
                </div>
            </div>

            <div class="d-flex mt-5">
                <div class="resizable">
                    {{-- {!! settings('letter_application_recipient')!!} --}}
                    <p class="m-0 p-1">श्री प्रमुख प्रशासकीय अधिकृत ज्यु</p>
                    <p class="m-0 p-1">{{ $patient->address->municipality }}को कार्यालय,
                        {{ $patient->address->district }}</p>
                </div>
            </div>
            <div class="mt-5 text-center">
                <span class="py-2">
                    विषय:- उपचार सिफारिस/उपचार राहत/पाउँ बारे ।
                </span>
            </div>

            <div class="d-flex mt-5">
                <div class="resizable">
                    महोदय, <br> <span class="ml-5">उपरोक्त बिषय सम्बन्धमा निबेदन गर्नको कारण म/मेरो</span>
                    {{ $patient->relation_with_patients }} श्री {{ $patient->name }} {{ $patient->disease->name }} रोगले
                    ग्रसित
                    रहेको कारणले र म/मेरो आर्थिक आवस्था कम्जोर रहेको कारण नियमानुसार उपचार सिफारिस गरि उपचार राहत पाउँ
                    भनियो निबेदन पेश गरेको छु ।
                </div>
            </div>

            <div class="d-flex mt-5">
                <div class="resizable col-12 m-0 p-0">
                    <div class="d-flex justify-content-end align-items-end">
                        <div class="d-block">

                            <div class="d-flex">
                                निवेदकको नाम थर : {{ $patient->contact_person }}
                            </div>
                            <div class="d-flex">
                                ठेगाना :
                                <div>
                                    {{ App\Address::find($patient->address_id)->municipality }} - <span
                                        class="kalimati-font">{{ $patient->ward_number }},</span> <br>
                                    {{ $patient->tole }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="d-flex mt-2 font-weight-bold"><span> :</span>
                    <div class="underline1" style="width: calc(100% - 100px)"></div>
                </div> --}}
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
