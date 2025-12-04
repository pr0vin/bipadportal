@extends('layouts.letter')

@section('content')
    @push('styles')
        <style>
            .note-air-popover .popover-content button {
                padding: 4px 6px;
                font-size: 1px;
                width: 28px;
                height: 28px;
                line-height: 1;
                border-radius: 4px;
                background-color: #fff !important;
                color: #000 !important;
                border: none !important;
                box-shadow: none !important;
            }

            .note-fontsize span {
                font-size: 15px !important;
            }

            .note-air-popover .popover-content button i {
                font-size: 10px;
                width: 10px;
                height: 10px;
                line-height: 1;
            }

            .note-air-popover .popover-content {
                padding: 5px;
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
        <div class="p-4 resizable-block">
            <section class="">
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
                    // if ($patient) {
                    //     $type_id = $patient->disease->application_types[0]->id;
                    //     $committee = App\Committee::where('application_type_id', $type_id)->first();
                    //     if ($committee) {
                    //         $members = App\Member::with('position', 'committeePosition')
                    //             ->where('committee_id', $committee->id)
                    //             ->orderBy('order', 'asc')
                    //             ->get();
                    //     }
                    // }
                @endphp
                {{-- <div contenteditable="true" class="font-size">आज मिति <span class="kalimati-font">{{ englishToNepaliLetters($today) }} </span> गतेका
                    दिन
                    <span class="kalimati-font">{{ englishToNepaliLetters(date('h:i')) }} </span> बजे यस
                    {{ $address->municipality }}का
                    {{ $members->where('order', 1)->first()->position->name }}
                    {{ $members->first() ? $members->where('order', 1)->first()->position->name : '' }}
                    ले जारी गरिएको "बिपन्न
                    नागरिक
                    औषधि उपचारकोष
                    निर्देशिका
                    <span class="kalimati-font">२०८० </span>" बमोजिम बिपन्न नागरिकहरु लाई औषधि उपचार सहुलियत उपलब्ध गराउने
                    प्रयोजनको लागि सिफारिस समितिका
                    {{ $members->where('order', 1)->first()->committeePosition->name }}
                    {{ $members->first() ? $members->where('order', 1)->first()->committeePosition->name : '' }}
                    श्री
                    {{ $members->where('order', 1)->first()->name }}
                    {{ $members->first() ? $members->where('order', 1)->first()->name : '' }}

                    ज्युको अध्यक्ष्यतामा बसेको बैठकले तपसिल
                    बमोजिम प्रस्ताबहरु माथि छलफल गरि तपसिल
                    बमोजिम
                    निर्णयहरु पारित गरियो
                </div> --}}


                {{-- <div id="selected-list"></div> --}}

                {{-- {{$patients[0]->disease->application_types[0]->id}} --}}
                {{-- @php
                    $members = null;
                    if ($patients[0]) {
                        $type_id = $patients[0]->disease->application_types[0]->id;
                        $committee = App\Committee::where('application_type_id', $type_id)->first();
                        if ($committee) {
                            $members = App\Member::with('position', 'committeePosition')
                                ->where('committee_id', $committee->id)
                                ->orderBy('order', 'asc')
                                ->get();
                        }
                    }
                @endphp --}}
                <livewire:members-list :members="$members" :patients="$patients" />

                {{-- <div class="font-size"><span class="kalimati-font">१.</span>
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
                    {{ $members->first() ? $members->where('order', 2)->first()->position->name : '' }} श्री
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
                    {{ $members->first() ? $members->where('order', 3)->first()->position->name : '' }} श्री
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
                        यस पालिकामा दिएको निवेदन उपर छलफल गरि संग्लन कागजातका आधारमा “बिपन्न नागरिक औषधि उपचार कोष
                        निर्देशिका
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
                                    <td class="kalimati-font">{{ $loop->iteration }}</td>
                                    <td>{{ $patient->name ?? '' }}</td>
                                    <td class="kalimati-font">{{ $patient->age ?? '' }}</td>
                                    <td class="kalimati-font">{{ $patient->citizenship_number ?? '' }}</td>
                                    <td>{{ $patient->disease ? $patient->disease->name : '' }}</td>
                                    <td>{{ $patient->hospital ? $patient->hospital->name : '' }}</td>
                                    <td class="kalimati-font">{{ $patient->mobile_number ?? '' }}</td>
                                    <td>{{ $patient->description ?? '' }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

<div class="modal fade" id="membersList" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Member's list</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul>
                    @if ($members)
                    @foreach ($members as $member)
                    <li class="d-flex align-items-center">
                        <input type="checkbox" class="member-checkbox" value="{{ $member }}" name=""
                            id="checkbox{{ $member->id }}">
                        <span>{{ $member->name }} ({{ $member->position->name }})</span>
                        <label class="pt-3 ml-2 font-weight-normal"
                            for="checkbox{{ $member->id }}">{{ $member->name }}</label>
                    </li>
                @endforeach
                    @endif
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
@push('script')
    {{-- <script>
        const membersList = document.getElementById('members_list');
        document.addEventListener('DOMContentLoaded', () => {
            const checkboxes = document.querySelectorAll('.member-checkbox');
            const selectedList = document.getElementById('selected-list');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    updateSelectedMembers(membersList);
                });
            });

            function updateSelectedMembers(membersLists) {
                membersLists.innerHTML = 'Hello';
                alert("Hello")
                const selectedMembers = [];
                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        selectedMembers.push(checkbox.value);
                    }
                });

                selectedMembers.sort((a, b) => {
                    if (a.order < b.order) {
                        return -1; // a comes before b
                    }
                    if (a.order > b.order) {
                        return 1; // b comes before a
                    }
                    return 0; // a and b are equal
                });

                const membersList = document.getElementById('members_list');

                // membersList.innerHTML = 'Hello'; // Optional, clear previous content

                selectedMembers.forEach((member) => {
                    const newDiv = document.createElement('div'); // Create a new div for each member
                    newDiv.innerHTML = `<h1>${member.name}</h1>`; // Set content
                    membersLists.appendChild(newDiv); // Append the new div to the members_list div
                });
                console.log(membersLists)
                selectedList.innerHTML = selectedMembers.length > 0 ? selectedMembers.join(', ') : 'None';
            }
        });
    </script> --}}
@endpush
