@extends('layouts.app')
@section('content')
    <div class="container-fluid pb-5">
        <div class="card mt-3 z-depth-0">
            <div class="card-body">
                <h4 class="text-center">{{App\Address::find(municipalityId())->municipality}}</h4>
                <label for="" class="col-12 text-center">मृर्गौला प्रत्यारोपण गरेका, डायलासिस गराई रहेका, क्यान्सर रोगी र मेरुदण्ड पक्षघातका बिरामीहरुलाई औषधि उपचार बापत खर्च उपलब्ध गराउने सम्बन्धि कार्यविधि २०७८ बमोजिम मासिक रु. ५ हजारका दरले रकम भुक्तानी दिएको बिबरण(आ. व. {{currentFiscalYear()->name}}) "</label>
                <form action="#">
                    <table class="table table-bordered table-sm table_print kalimati-font">
                        <thead class="font-noto">
                            <tr class="text-center" style="font-size: 11px">
                                <th>क्र.स</th>
                                <th>लाभग्राहिको नाम थर</th>
                                <th>लिङ्ग</th>
                                <th>उमेर <br>(बर्ष)</th>
                                <th>ठेगाना</th>
                                <th>रोगको किसिम</th>
                                <th>दर्ता मिति</th>
                                <th>रा.प.प.नं..<br>/ना.प्र.प.नं./ <br> जन्म दर्ता प्र.प.नं.</th>
                                <th>भुक्तानी <br>पाउने<br>(महिना)</th>
                                <th>दर</th>
                                <th>जम्मा रु</th>

                                <th>मोबाइल नम्बर</th>
                                {{-- <th>कैफियत</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($totalRenew as $renew)
                                <tr class="text-center">
                                    <td class="kalimati-font">{{ $loop->iteration }}</td>
                                    <td>{{ $renew->patient->name }} <br> {{ $renew->patient->name_en }}</td>
                                    <td>
                                        @if (strtolower($renew->patient->gender) == 'female')
                                            महिला
                                        @elseif(strtolower($renew->patient->gender) == 'male')
                                            पुरुष
                                        @else
                                            अन्य
                                        @endif
                                    </td>
                                    <td class="kalimati-font">{{ $renew->patient->age }}</td>
                                    <td class="kalimati-font">{{ $renew->patient->address->municipality }} -
                                        {{ $renew->patient->ward_number }}</td>
                                    <td>{{ $renew->patient->disease->name }}</td>
                                    <td class="kalimati-font">{{ dateFormat($renew->patient->registered_date) }}</td>
                                    <td class="kalimati-font">{{ $renew->patient->citizenship_number }}</td>
                                    <td class="kalimati-font">{{ $renew->month }}</td>
                                    <td class="kalimati-font">रु {{ $renew->price_rate }}</td>
                                    <td class="kalimati-font">रु {{ $renew->price_rate * $renew->month }}</td>
                                    <td class="kalimati-font">{{ $renew->patient->mobile_number }}</td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                    <div class="col-12 d-flex justify-content-end align-items-center">
                        <a href="{{ route('payment') }}" class="btn btn-info">भुक्तानी गर्नुहोस्<i
                                class="fas fa-chevron-right ml-2 position-relative top-3"></i></a>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
