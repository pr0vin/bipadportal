<div>
    <div class="p-4 resizable-block">
        <section>
            <div class="my-4 text-center kalimati-font">
                <p style="font-weight:bold;font-size:16px" class="kalimati-font">अनुसूची-२</p>
                <p style="font-size:16px;font-weight:bold;" class="kalimati-font"> ( दफा ४ उप दफा (1) संग सम्बन्धित )</p>
                <h4 class="heading" style="font-size: 16px;font-weight:bold;"> विपन्न नागरिक आवेदन तथा सिफारिस
                    फाराम</h4>
            </div>
            <div class="ml-auto text-right resizable">
                <div>मिति: <span
                        class="nepali-date-today kalimati-font">{{ englishToNepaliLetters(ad_to_bs(now()->format('Y-m-d'))) }}</span>
                </div>
            </div>

            <div class="d-flex mt-5">
                <div class="resizable">
                    {{-- {!! settings('letter_application_recipient')!!} --}}
                    <p class="m-0 p-1">श्रीमान् अध्यक्ष ज्यू ,</p>
                    <p class="m-0 p-1 mt-2">...........................</p>
                </div>
            </div>

            <div class="mt-5">
                <p> देहाय बमोजिम विवरण भरी विपन्न नागरिक औषधी उपचार सहुलियतका लागि अनुरोध गर्दछु ।</p>
            </div>


            <div style="width:100%;">
                <table>
                    <thead>
                        <th>

                            <div class="d-flex justify-content-center para-font " style="font-weight:bold">
                                क्र.सं.
                            </div>
                        </th>
                        <th>
                            <div class="d-flex justify-content-center para-font " style="font-weight:bold">
                                विवरण
                            </div>

                        </th>
                        <th>
                            <div class="d-flex justify-content-center para-font " style="font-weight:bold">
                                कैफियत
                            </div>

                        </th>
                    </thead>

                    <tbody>
                        <tr>
                            <td class="kalimati-font" style="width:20px ; font-size:16px">1</td>
                            <td colspan="">
                                <h4 class="heading" class="resizable">वैयक्तिक :</h4>

                                <div class="para-size">
                                    <div class="row mb-2">
                                        <div class="col">
                                            विरामीको नाम: {{ $patient->name }}
                                        </div>
                                        <div class="col kalimati-font"> उमेर :{{ $patient->age }}</div>
                                        <div class="col">
                                            @php
                                                $gender = strtolower($patient->gender);
                                            @endphp
                                            लिङ्ग:
                                            @if ($gender == 'male')
                                                पुरुष
                                            @elseif($gender == 'female')
                                                महिला
                                            @else
                                                अन्य
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col">
                                            ठेगाना स्थायी जिल्ला :{{ $patient->address->district }}
                                        </div>
                                        <div class="col"> पालिका. {{ $patient->address->municipality }}</div>
                                        <div class="col kalimati-font">
                                            वडा नं. {{ $patient->ward_number }}
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col">
                                            अस्थायी जिल्ला :
                                        </div>
                                        <div class="col"> पालिका :</div>
                                        <div class="col">
                                            वडा नं.
                                        </div>
                                    </div>

                                    <div class="mb-2">
                                        जातीगत विवरण : ब्राम्हण (क्षेत्री) / आदिवासी/जनजाति/दलित/अल्पसंख्यक/अन्य
                                    </div>
                                    <div class="mb-2">
                                        परिवार संख्या : ...............
                                    </div>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="kalimati-font" style="width:20px ; font-size:16px">2</td>
                            <td colspan="">
                                <h4 class="heading">आय स्रोत : पेशा र व्यवसाय </h4>

                                <div class="para-size">
                                    <div class="mb-2">
                                        - परम्परागत कृषि :
                                    </div>

                                    <div class="mb-2">
                                        - रोजगारी (स्वदेशी/विदेशी) :
                                    </div>



                                    <div class="d-flex justify-content-around mb-2">
                                        <div>
                                            उद्यम/व्यवसाय :
                                        </div>
                                        <div> अनुमानित मासिक आय :</div>

                                    </div>

                                </div>
                            </td>
                            <td></td>
                        </tr>

                        <tr>
                            <td class="kalimati-font" style="width:20px ; font-size:16px">3</td>
                            <td colspan="">
                                <h4 class="heading">जग्गा जमिन (क्षेत्रफल र स्थान समेत)</h4>

                                <div class="para-size">
                                    <div class="mb-2">
                                        - भौतिक संरचना (घर/टहरा आदिको संख्या:कच्ची/पक्की)
                                    </div>

                                    <div class="mb-2">
                                        - सवारी साधन :
                                    </div>
                                    <div class="mb-2">
                                        - बैंक मौज्दात :
                                    </div>
                                    <div class="mb-2">
                                        - सुन चाँदी :
                                    </div>
                                    <div class="mb-2">
                                        - नगद :
                                    </div>


                                </div>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="kalimati-font" style="width:20px ; font-size:16px">4</td>
                            <td colspan="">

                                <div class="d-flex align-items-center">
                                    <h4 class="heading"> विरामी रोगको किसिम : </h4>
                                    <span class="ml-1 para-size">
                                        मुटु रोग, मृगौला रोग, क्यान्सर, पार्किन्सन्स, अल्जाइमर, हेड इन्जुरी, स्पाइनल
                                        इन्जुरी र सिकलसेल एनिमिया
                                    </span>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="kalimati-font" style="width:20px ; font-size:16px">5</td>
                            <td colspan="">
                                <h4 class="heading"> संलग्न कागजातहरु :</h4>
                                <div class="para-size">
                                    <div class="mb-2">
                                        (क) विरामीको नागरिकताको प्रतिलिपी (बालकको हकमा जन्मदर्ताको प्रतिलिपी)
                                    </div>

                                    <div class="mb-2">
                                        (ख) रोग निदान भएको प्रेस्कीप्सन
                                    </div>




                                </div>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="kalimati-font" style="width:20px ; font-size:16px">6</td>
                            <td colspan="">
                                <h4 class="heading">उपचार सहुलियतका लागि सिफारिस माग गरेको अस्पताल :</h4>
                            </td>
                            <td></td>
                        </tr>

                        <tr>
                            <td class="kalimati-font" style="width:20px ; font-size:16px">7</td>
                            <td colspan="">

                                <div class="para-size ">

                                    <div class="mb-3">
                                        उपर्युक्त बमोजिमको व्यहोरा साँची ही झुठा ठहरे सहुँला बुझाउला ।
                                    </div>
                                    <div class="mb-2">
                                        निवेदकको नाम :
                                    </div>

                                    <div class="mb-2">
                                        ठेगाना :
                                    </div>




                                    <div class="row mb-2">
                                        <div class="col">
                                            दस्तखत :
                                        </div>
                                        <div class="col"> मिति :</div>
                                        <div class="col">
                                            सम्पर्क नं.:
                                        </div>
                                    </div>

                                </div>
                            </td>
                            <td></td>
                        </tr>

                        <tr>
                            <td class="kalimati-font" style="width:20px ; font-size:16px">8</td>
                            <td colspan="">

                                <div class="para-size">

                                    <div class="mb-2">
                                        सिफारिसको व्यहोरा :
                                    </div>
                                    <div class="mb-2">
                                        सिफारिस गर्ने :
                                    </div>


                                    <div class="row mb-2">
                                        <div class="col">
                                            नाम :
                                        </div>
                                        <div class="col"> पद :</div>
                                        <div class="col">
                                            दस्तखत :
                                        </div>
                                    </div>

                                    <div>
                                        कार्यालयको छाप :
                                    </div>

                                </div>
                            </td>
                            <td></td>
                        </tr>


                    </tbody>
                </table>
            </div>







            <div class="mt-2">
                <qr-code value="{{ $patient->token_no }}" :size="100"></qr-code>
            </div>
        </section>
    </div>
</div>
