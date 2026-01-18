<div>
    <div id="options-bar" class="card grey lighten-5 border my-4 noprint" style="z-index: 1">
        <div class="card-body d-flex justify-content-between">
            <a href="{{ route('regLocation') }}"
                class="btn btn-danger btn-md z-depth-0 btn-font-size">Cancel</a>
            <div class="d-flex">
                <button wire:click="exportData" class="btn btn-info btn-md z-depth-0 btn-font-size">Export word
                    file</button>
                <button class="btn btn-primary btn-md z-depth-0 btn-font-size" onclick="printDocument()">Print</button>
            </div>
        </div>
    </div>
    <div class="position-fixed left-0 top-0 h-100 w-100 {{ $toggle ? 'd-flex' : 'd-none' }} justify-content-center align-items-center"
        style="background-color: rgba(0,0,0,0.5);left:0;top:0;cursor:pointer;">
        <div class="bg-white p-3 rounded col-md-4" style="overflow:hidden">
            <h5>सदस्यहरु</h5>
            <hr>
            <ul class="m-0 p-0" style="max-height:80vh;overflow-y:auto">
                @if ($members)
                    @foreach ($members as $member)
                        <li class="d-flex align-items-center">
                            <input type="checkbox" class="member-checkbox" value="{{ $member->id }}"
                                id="checkbox{{ $member->id }}" wire:click="toggleMember({{ $member->id }})"
                                @if (in_array($member->id, $filteredMembers)) checked @endif>
                            <label class="pt-3 ml-2 font-weight-normal" style="font-size: 15px"
                                for="checkbox{{ $member->id }}">{{ $member->position->name }} श्री {{ $member->name }}
                                ({{ $member->committeePosition->name }})
                            </label>
                        </li>
                    @endforeach
                @endif
            </ul>

            <div class="d-flex justify-content-end">
                <button class="btn btn-info" wire:click="toggleModal">पेश गर्नुहोस्</button>
            </div>
        </div>
    </div>

    

     {{-- <div class="position-fixed left-0 top-0 h-100 w-100 {{ $toggle ? 'd-flex' : 'd-none' }} justify-content-center align-items-center"
        style="background-color: rgba(0,0,0,0.5);left:0;top:0;cursor:pointer;">
        <div class="bg-white p-3 rounded col-md-4" style="overflow:hidden">
            <h5>समितिहरु</h5>
            <hr>
            <ul class="m-0 p-0" style="max-height:80vh;overflow-y:auto">
                @if ($committees)
                    @foreach ($committees as $committee)
                        <li class="d-flex align-items-center">
                            <input type="checkbox" class="member-checkbox" value="{{ $committee->id }}" id="checkbox{{ $committee->id }}" wire:click="toggleMember({{ $committee->id }})">
                            <label class="pt-3 ml-2 font-weight-normal" style="font-size: 15px"
                                for="checkbox{{ $committee->id }}">
                                ({{ $committee->name }})
                            </label>
                        </li>
                    @endforeach
                @endif
            </ul>

            <div class="d-flex justify-content-end">
                <button class="btn btn-info" wire:click="toggleModal">पेश गर्नुहोस्</button>
            </div>
        </div>
    </div> --}}





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

    <div contenteditable="true" class="font-size">
        आज मिति <span class="kalimati-font">{{ englishToNepaliLetters($today) }}</span> गतेका दिन
        <span class="kalimati-font">{{ englishToNepaliLetters(date('h:i')) }}</span> बजे यस
        {{ $address->municipality }} का

        @if ($newMember)
            {{ $newMember->position->name }}
        @endif
        जारी गरिएको " प्रभावित नागरिक विपद् राहत कोष निर्देशिका <span class="kalimati-font">२०८०</span>" बमोजिम
        प्रभावित नागरिकहरुलाई विपद् राहत सहुलियत उपलब्ध गराउने प्रयोजनको लागि सिफारिस समितिका
        @if ($newMember)
            {{ $newMember->committeePosition->name }}
        @endif
        श्री
        @if ($newMember)
            {{ $newMember->name }}
        @endif
        ज्युको अध्यक्ष्यतामा बसेको बैठकले तपसिल बमोजिम प्रस्ताबहरु माथि छलफल गरि तपसिल बमोजिम निर्णयहरु पारित गरियो
    </div>



    <div contenteditable="true">
        <div class="mt-4 font-size"><u>उपस्थिति:</u></div>
        <ol style="list-style: none" class="m-0 p-0">
            @foreach ($filteredMembers as $filteredMemberId)
                <li><span class="kalimati-font">{{ $loop->iteration }}.</span>
                    {{ $members->find($filteredMemberId)->position->name }} श्री
                    {{ $members->find($filteredMemberId)->name }}
                    ({{ $members->find($filteredMemberId)->committeePosition->name }})
                </li>
            @endforeach
        </ol>
    </div>
</div>
