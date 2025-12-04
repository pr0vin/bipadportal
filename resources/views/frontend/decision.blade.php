@extends('layouts.letter')

@section('content')
    @push('styles')
        <style>
            * {
                /* font-size: 22px; */
            }

            .note-air-popover .popover-content button {
                padding: 4px 6px;
                /* Smaller padding */
                font-size: 1px;
                /* Smaller font size */
                width: 28px;
                /* Decrease button width */
                height: 28px;
                /* Decrease button height */
                line-height: 1;
                /* Adjust line height */
                border-radius: 4px;
                background-color: #fff !important;
                color: #000 !important;
                border: none !important;
                box-shadow: none !important;
                /* Optional: Adjust border radius */
            }

            .note-fontsize span {
                font-size: 15px !important;
            }

            .note-air-popover .popover-content button i {
                font-size: 10px;
                /* Adjust icon size */
                width: 10px;
                /* Optional: control icon width */
                height: 10px;
                /* Optional: control icon height */
                line-height: 1;
                /* Ensure icon is aligned properly */
            }

            /* Optional: Reduce the padding around the popover */
            .note-air-popover .popover-content {
                padding: 5px;
                /* Smaller padding around the popover */
            }

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

            .font-size {
                font-size: 20px !important
            }

            .popover-content.note-children-container button {
                font-size: 13px !important;
                background-color: #fff !important;
                color: #000 !important;
            }
        </style>
    @endpush
    <div>
        {{-- <textarea name="" id="" cols="30" rows="10"></textarea> --}}
        <div class="p-4 resizable-block">
            <section>
                <div class="my-4"></div>
                @php
                    $today = ad_to_bs(now()->format('Y-m-d'));

                    $address = App\Address::find(municipalityId());
                @endphp
                @php
                    $firstMemberPosition = '';
                    $firstMember = '';
                    $secondMemberPosition = '';
                    $secondMember = '';
                    $thirdMemberPosition = '';
                    $thirdMember = '';
                    $patients = App\Patient::with('disease.application_types', 'hospital')->where('id',request('patient_id'))->get();
                    if ($patients[0]) {
                        $type_id = $patients[0]->disease->application_types[0]->id;
                        $committee = App\Committee::where('application_type_id', $type_id)->where('address_id',municipalityId())->first();
                        $members=null;
                        if ($committee) {
                            $members = App\Member::with('position', 'committeePosition')
                                ->where('committee_id', $committee->id)
                                ->orderBy('order', 'asc')
                                ->get();
                        }
                    }
                @endphp
                {{-- <div contenteditable="true" class="font-size">आज मिति <span class="kalimati-font">{{ englishToNepaliLetters($today) }} </span> गतेका
                    दिन
                    <span class="kalimati-font">{{ englishToNepaliLetters(date('h:i')) }} </span> बजे यस
                    {{ $address->municipality }}का
                    {{ $members->first() ? $members->where('order', 1)->first()->position->name : '' }}
                    जारी गरिएको "बिपन्न
                    नागरिक
                    औषधि उपचारकोष
                    निर्देशिका
                    <span class="kalimati-font">२०८० </span>" बमोजिम बिपन्न नागरिकहरु लाई औषधि उपचार सहुलियत उपलब्ध गराउने
                    प्रयोजनको लागि सिफारिस समितिका
                    {{$members->first() ? $members->where('order', 1)->first()->committeePosition->name : '' }}
                    श्री
                    {{ $members->first() ? $members->where('order', 1)->first()->name : '' }}

                    ज्युको अध्यक्ष्यतामा बसेको बैठकले तपसिल
                    बमोजिम प्रस्ताबहरु माथि छलफल गरि तपसिल
                    बमोजिम
                    निर्णयहरु पारित गरियो
                </div> --}}
                @php
                    $patientId=request('patient_id');
                @endphp

                <livewire:members-list :members="$members" :patients="$patients" :patientId="$patientId"/>
                {{-- <div class="mt-4 font-size"><u>उपस्थिति:</u></div>
                <div class="font-size"><span class="kalimati-font">१.</span>
                    {{ $members->first() ? $members->where('order', 1)->first()->position->name : '' }} श्री
                    @if ($committee)
                        @if ($members->first())
                            {{ $members->where('order', 1)->first()->name }}
                            ({{ $members->where('order', 1)->first()->committeePosition->name }})
                        @else
                            <span class="underline1 px-3">&nbsp;&nbsp;&nbsp;</span>
                        @endif
                    @endif
                </div>

                <div class="font-size"><span class="kalimati-font">2.</span>
                    {{ $members->first() ? $members->where('order', 2)->first()->position->name : ''}} श्री
                    @if ($committee)
                        @if ($members->first())
                            {{ $members->where('order', 2)->first()->name }}
                            ({{ $members->where('order', 2)->first()->committeePosition->name }})
                        @else
                            <span class="underline1 px-3">&nbsp;&nbsp;&nbsp;</span>
                        @endif
                    @endif
                </div>
                <div class="font-size"><span class="kalimati-font">3.</span>
                    {{ $members->first() ? $members->where('order', 3)->first()->position->name : ''}} श्री
                    @if ($committee)
                        @if ($members->first())
                            {{ $members->where('order', 3)->first()->name }}
                            ({{ $members->where('order', 3)->first()->committeePosition->name }})
                        @else
                            <span class="underline1 px-3">&nbsp;&nbsp;&nbsp;</span>
                        @endif
                    @endif
                </div> --}}

                <div class="m-0 p-0" contenteditable="true">

                    {{-- <div class="mt-4 font-size"><u>अन्य उपस्थिति:</u></div>
                    <div class="font-size"><span class="kalimati-font">1.</span></div>
                    <div class="font-size"><span class="kalimati-font">2.</span></div> --}}

                    <div class="mt-4 font-size">प्रस्ताव नं <span class="kalimati-font">1</span>:औषधि उपचार सहुलियत का लागि
                        सिफारिस सम्बन्ध मा</div>
                    <div class="mt-4 font-size">निर्णय नं: <span class="kalimati-font">1</span> प्रस्ताव नं: <span
                            class="kalimati-font">1</span> माथि छलफल गर्दा यस घोडाघोडी नगरपालिका मा स्थायी बसोबास
                        भएका
                        तपसिल बमोजिमका बिपन्न नागरिकहरुले
                        यस पालिकामा दिएको निवेदन उपर छलफल गरि संग्लन कागजातका आधारमा “बिपन्न नागरिक औषधि उपचार कोष निर्देशिका
                        <span class="kalimati-font">2080</span>”
                        अनुसार तपसिल बमोजिमका बिरामीहरु लाई देहाय बमोजिम तोकिएका अस्पतालंहरु मा उपचारका लागि सिफारिस गर्ने
                        निर्णय पारित
                        गरियो|
                    </div>

                    <div class="mt-4 font-size">
                        <table>
                            <tr>
                                <td>क्र.
                                    सं.</td>
                                <td>बिरामीको नाम थर</td>
                                <td>उमेर</td>
                                <td>ना.प्र.प.नं./ज.
                                    .द.प्र.प.नं.</td>
                                <td>रोगको किसिम</td>
                                <td>सिफारिसगरिएको
                                    अस्पताल</td>
                                <td>सम्पर्क नं:</td>
                                <td>कैफियत</td>
                            </tr>
                           @foreach ($patients as $patient)
                           <tr>
                            <td class="kalimati-font">1</td>
                            <td>{{ $patient->name ?? '' }}</td>
                            <td class="kalimati-font">{{ $patient->age ?? '' }}</td>
                            <td class="kalimati-font">{{ $patient->citizenship_number ?? '' }}</td>
                            <td>{{ $patient->disease ? $patient->disease->name : '' }}</td>
                            <td>{{ $patient->hospital ? $patient->hospital->name : '' }}</td>
                            <td class="kalimati-font">{{ $patient->mobile_number ?? '' }}</td>
                            <td>{{ $patient->description ?? '' }}</td>
                        </tr>
                           @endforeach
                            <tr>
                                <td>&nbsp;</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
