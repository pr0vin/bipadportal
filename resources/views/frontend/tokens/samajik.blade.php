<div>
    <div class="p-4 resizable-block kalimati-font">
        <section>
            <div class="my-4 text-center">
                <p class="kalimati-font" style="font-weight:bold;font-size:16px">अनुसूची-1</p>
                <p class="kalimati-font" style="font-size:16px;font-weight:bold;"> ( दफा ४ को उपदफा (1)को खण्ड (क)संग
                    सम्बन्धित )</p>
                <h4 class="heading" style="font-size: 16px;font-weight:bold; text-decoration:underline"> बिरामीले स्थानीय
                    तहमा पेश गर्ने निवेदन का फाराम</h4>
            </div>
            <div class="ml-auto text-right resizable">
                <div>मिति: <span
                        class="nepali-date-today kalimati-font">{{ englishToNepaliLetters(ad_to_bs(now()->format('Y-m-d'))) }}</span>
                </div>
            </div>

            <div class="d-flex mt-5">
                <div class="resizable">
                    {{-- {!! settings('letter_application_recipient')!!} --}}
                    <p class="m-0 p-1">श्रीमान् ................................,</p>
                    <p class="m-0 p-1 mt-2">................................. गा.पा/ना.पा</p>
                    <p class="m-0 p-1 mt-2">............................................</p>
                </div>
            </div>

            <div class="mt-5">
                <p class="kalimati-font"> देहाय बमोजिम विवरण भरी विपन्न नागरिकको स्वास्थ्य उपचार आर्थिक सुविधा सिफारिसका
                    लागि अनुरोध छ ।</p>
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
                                <h4 class="heading" class="resizable"> वैयक्तिक विवरण :</h4>

                                <div class="para-size">
                                    <div class="row mb-2">
                                        <div class="col">
                                            विरामीको नाम : {{ $patient->name }}
                                        </div>
                                        <div class="col"> उमेर : {{ $patient->age }}</div>
                                        <div class="col">
                                            लिङ्ग:{{ ($patient->gender == 'male' ? 'पुरुष' : $patient->gender == 'female') ? 'महिला' : 'अन्य' }}
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col">
                                            ठेगाना स्थायी जिल्ला : {{ $patient->address->district }}
                                        </div>
                                        <div class="col"> पालिका : {{ $patient->address->municipality }}</div>
                                        <div class="col">
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
                                        पेशा :
                                    </div>
                                    <div class="mb-2">
                                        परिवार सदस्या संख्या :
                                    </div>
                                    <div class="mb-2"> अनुमानित बार्षिक आम्दानी :</div>

                                </div>
                            </td>
                            <td></td>
                        </tr>


                        <tr>
                            <td class="kalimati-font" style="width:20px ; font-size:16px">2</td>
                            <td colspan="">

                                <div class="d-flex align-items-center">
                                    <h4 class="heading"> रोगको किसिम : </h4>

                                </div>
                            </td>
                            <td></td>
                        </tr>


                        <tr>
                            <td class="kalimati-font" style="width:20px ; font-size:16px">3</td>
                            <td colspan="">

                                <div class="para-size">

                                    <div class="mb-3">
                                        उपर्युक्त बमोजिमको व्यहोरा साँची ही झुठा ठहरे सहुँला बुझाउला ।
                                    </div>
                                    <div class="mb-3">
                                        निवेदकको दस्तखत :
                                    </div>


                                    <div class="row ">

                                        <div class="col"> मिति :</div>
                                        <div class="col">
                                            सम्पर्क नं.:
                                        </div>
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
