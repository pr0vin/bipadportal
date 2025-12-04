@extends('layouts.letter')

@section('content')
{{-- <x-format.token-letter :patient="$patient" :onlineApplication="$onlineApplication"></x-format.token-letter> --}}
<div class="p-5">
    <div class="text-right">
        <p>मिति : <span class="nepali-date-today"></span></p>
    </div>

    <div>श्री प्रमुख प्रशासकीय अधिकृत ज्यू ,</div>
   <div>{{ $patient->municipality->name }}, <br> वडा नंं. {{ $patient->ward_number }} को कार्यालय, {{ $patient->district->name }}</div>
    <div></div>
    <div class="my-5 text-center">
        विषय : उपचार सिफारिस गरि पाउँ  बारे ।
    </div>

    <div>
        <p>महोदय,</p>
    </div>
    <div>
        <p>
            उपरोक्त बिषय सम्बन्धमा निबेदन गर्नको कारण म/मेरो {{$patient->name}} श्री {{$patient->disease->name}} रोगले ग्रसित रहेको कारणले र म/मेरो आर्थिक अवस्था कम्जोर रहेको कारण नियमानुसार उपचार सिफारिस गरि/उपचार राहत पाउँ भनि यो निवेदन पेश गरेको छु ।
        </p>
    </div>
    {{-- <div>
        <p>
            मैले/हामीले वडा नं. {{ $patient->ward->name }}, {{ $patient->municipality->name }}, {{ $patient->district->name }}मा व्यवसाय दर्ता गर्नु परेकोले {{ $patient->municipality->name }}को व्यवसाय दर्ता ऐन, २०७७ को दफा ४ बमोजिम यो निवेदन दिएको छु/छौं ।
        </p>

        <div>१. व्यवसायीको नाम, थर: {{ $patient->prop_name }}</div>
        <div>२. स्थायी ठेगाना : {{$patient->prop_road_name}}, जिल्ला: {{ $patient->propDistrict->name}}, न.पा.: {{ $patient->propMunicipality->name }}</div>
        <div>३. नागरिकता नं. : {{ $patient->prop_citizenship_no }} जारी जिल्ला र गते : {{ $patient->prop_citizenship_district }} ( {{ $patient->prop_citizenship_issued_date }} ) </div>
        <div>४. फर्म/कम्पनीको नाम : {{ $patient->org_name }} </div>
        <div>५. व्यवसाय रहने स्थानको ठेगाना : {{ $patient->org_road_name }}</div>
        <div class="pl-5">
            <div>वडा नं. : {{ $patient->ward->name }} </div>
            <div>फोन नं. : {{ $patient->org_phone }} </div>
            @if($patient->org_email)
            <div>इमेल : {{ $patient->org_email }} </div>
            @endif
        </div>
        <div>६. व्यवसायको प्रकृति : {{ $patient->org_type }} </div>
        <div>७. कारोबार गर्ने वस्तु : {{ $patient->org_product_type }} </div>
        <div>८. लगानी (रु.मा) : {{ $patient->org_total_capital }}/- </div>
        <div>९. व्यवसाय वहालमा रहेको घरधनी/जग्गाधनीको
            <div class="pl-5">
                <div>नाम, थर : {{ $patient->org_house_owner_name }} </div>
                <div>ठेगाना : {{ $patient->org_house_owner_address }} </div>
                <div>वडा नं. : {{ $patient->org_house_owner_ward }} </div>
            </div>
        </div>
        <div>१०. Token Number: {{ $onlineApplication->token_number }}</div>
    </div> --}}

    <div class="d-flex flex-column align-items-end mt-3">
        <div class="ml-auto">
            <div>...........................</div>
            <div class="mt-2 text-center">निवेदकको नाम थर :</div>
            <div class="mt-2 text-center">ठेगाना :</div>
        </div>
    </div>
</div>

@endsection
