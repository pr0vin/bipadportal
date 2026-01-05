@extends('layouts.letter')
@section('content')
    </div>

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

            @media print {
                .noprint {
                    display: none !important;
                }
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
                @endphp

                <livewire:members-list :members="$members" :patients="$patients" />
                <div class="m-0 p-0" contenteditable="true">
                    <div class="mt-4 font-size">
                        प्रस्ताव नं <span class="kalimati-font">1</span> : विपद् राहत सहुलियत का लागि
                        सिफारिस सम्बन्धमा
                    </div>

                    <div class="mt-4 font-size">
                        निर्णय नं: <span class="kalimati-font">1</span> प्रस्ताव नं:
                        <span class="kalimati-font">1</span> माथि छलफल गर्दा यस घोडाघोडी नगरपालिका मा
                        स्थायी बसोबास भएका तपसिल बमोजिमका प्रभावित नागरिकहरुले यस पालिकामा दिएको निवेदन
                        उपर छलफल गरी संलग्न कागजातका आधारमा
                        “प्रभावित नागरिक विपद् राहत कोष निर्देशिका
                        <span class="kalimati-font">2080</span>”
                        अनुसार तपसिल बमोजिमका प्रभावित नागरिकहरुलाई देहाय बमोजिम तोकिएका निकायहरु मार्फत
                        राहत उपलब्ध गराउन सिफारिस गर्ने निर्णय पारित गरियो।
                    </div>


                    <div class="mt-4 font-size">
                        <table>
                            <tr>
                                <td style="width: 5%;">क्र.सं.</td>
                                <td style="width: 20%;">नाम थर</td>
                                <td style="width: 15%;">ना.प्र.प.नं./ज.द.प्र.प.नं.</td>
                                <td style="width: 5%;">वडा न.</td>
                                <td style="width: 25%;">क्षती भएको कारण</td>
                                <td style="width: 15%;">आनुमानित क्षति रकम</td>
                                <td style="width: 15%;">प्रदानरकम</td>
                            </tr>
                            <form id="sifarishForm" action="{{ route('sifarish.store') }}" method="POST">
                                @csrf

                                @foreach ($patients as $patient)
                                    <tr>
                                        <td style="width: 5%;" class="kalimati-font">{{ $loop->iteration }}</td>

                                        <td style="width: 20%;" class="kalimati-font">
                                            {{ $patient->name ?? '' }}<br>
                                            {{ $patient->mobile_number ?? '' }}

                                            <input type="hidden" name="patient_ids[]" value="{{ $patient->id }}">
                                        </td>

                                        <td style="width: 15%;" class="kalimati-font">
                                            {{ $patient->citizenship_number ?? '' }}
                                        </td>

                                        <td style="width: 5%;" class="kalimati-font">{{ $patient->ward_number }}</td>

                                        <td style="width: 25%;">{{ $patient->description ?? '' }}</td>

                                        <td style="width: 15%;" class="kalimati-font">{{ $patient->estimated_amount }}</td>

                                        <td style="width: 15%;" class="kalimati-font">
                                            <input type="text" name="paid_amount[]"
                                                class="border-0 outline-none focus:ring-0 focus:border-0">
                                        </td>
                                    </tr>
                                @endforeach

                                <button type="button" onclick="submitSifarish()" class="btn btn-primary mt-3 mb-2 noprint">
                                    सिफारिस सेभ गर्नुहोस
                                </button>
                            </form>

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
                                <input type="checkbox" class="member-checkbox" value="{{ $member }}"
                                    name="" id="checkbox{{ $member->id }}">
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


<script>
function submitSifarish() {
    const form = document.getElementById('sifarishForm');
    const formData = new FormData(form);

    // Debug: print all data to console
    console.log('Submitting Form Data:');
    for (let [key, value] of formData.entries()) {
        console.log(key, value);
    }

    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(async response => {
        const data = await response.json().catch(() => null);
        // console.log('Server Response:', response, data);
        if (!response.ok) throw data || response;

        alert(data?.message || 'सिफारिस सफलतापूर्वक सेभ भयो');
    })
    .catch(error => {
        console.error('Submission Error:', error);

        if (error?.errors) {
            const messages = Object.values(error.errors).flat().join("\n");
            alert(messages);
        } else {
            alert('केही समस्या आयो');
        }
    });
}
</script>
