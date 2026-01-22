<div>
    <div class="p-4 resizable-block">
        <section>
            <div class="my-4"></div>

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
                    <p class="m-0 p-1">श्री प्रमुख प्रशासकीय अधिकृत ज्यू</p>
                    <p class="m-0 p-1">
                        {{ $patient->address->municipality }}को कार्यालय,
                        {{ $patient->address->district }}
                    </p>
                </div>
            </div>

            <div class="mt-5 text-center">
                <span class="py-2">
                    विषय:- विपद् प्रभावित राहत तथा सहयोग उपलब्ध गराइदिने सम्बन्धमा ।
                </span>
            </div>

            <div class="d-flex mt-5">
                <div class="resizable">
                    महोदय, <br>
                    <span class="ml-5">
                        उपरोक्त विषय सम्बन्धमा निवेदन गर्नुपरेको कारण म/मेरो
                        {{ $patient->relation_with_patients }} श्री {{ $patient->name }}
                        हालै घटेको विपद्  बाट प्रभावित भई
                        आर्थिक, भौतिक तथा सामाजिक रूपमा अत्यन्तै कठिन अवस्थामा परेको हुँदा
                        म/मेरो परिवारको दैनिक जीवनयापन प्रभावित भएको छ ।
                    </span>
                    <br><br>
                    <span class="ml-5">
                        यस कारणले गर्दा नियमानुसार विपद् व्यवस्थापन अन्तर्गत उपलब्ध हुने
                        राहत, सहयोग तथा आवश्यक सिफारिस प्रदान गरिदिनुहुन
                        सादर अनुरोध गर्दछु ।
                    </span>
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
                                    {{ App\Address::find($patient->address_id)->municipality }} -
                                    <span class="kalimati-font">{{ $patient->ward_number }}</span>, <br>
                                    {{ $patient->tole }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-2">
                <qr-code value="{{ $patient->token_no }}" :size="100"></qr-code>
            </div>
        </section>
    </div>
</div>
