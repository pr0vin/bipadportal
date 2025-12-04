@php
    $isPaid = false;
@endphp
@extends('layouts.app')
@section('content')
    <div class="container-fluid pb-5">
        <div class="card z-depth-0">
            <div class="card-body">
                <form action="{{ route('payment.procedure') }}" method="GET">
                    <div class="d-flex align-items-center">
                        @php
                            $year = Carbon\Carbon::parse(currentFiscalYear()->start)->format('Y');
                            $quarterOne = new DateTime($year . '-6-30');
                            $quarterTwo = new DateTime($year . '-9-30');
                            $quarterThree = new DateTime($year . '-12-30');
                            $quarterFour = new DateTime($year + 1 . '-3-30');
                            $currentDate = new DateTime(currentQuarterEndDate());
                        @endphp
                        @if (request('quarter'))
                            <select name="quarter" id="" class="form-control">
                                {{-- <option value="">सबै त्रैमासिक
                                    </option> --}}
                                <option value="1" {{ request('quarter') == 1 ? 'selected' : '' }}
                                    {{ $quarterOne > $currentDate ? 'disabled' : '' }}>प्रथम त्रैमासिक
                                </option>
                                <option value="2" {{ request('quarter') == 2 ? 'selected' : '' }}
                                    {{ $quarterTwo > $currentDate ? 'disabled' : '' }}>द्वितीय
                                    त्रैमासिक</option>
                                <option value="3" {{ request('quarter') == 3 ? 'selected' : '' }}
                                    {{ $quarterThree > $currentDate ? 'disabled' : '' }}>तृतीय त्रैमासिक
                                </option>
                                <option value="4" {{ request('quarter') == 4 ? 'selected' : '' }}
                                    {{ $quarterFour > $currentDate ? 'disabled' : '' }}>चौथो त्रैमासिक
                                </option>
                            </select>
                        @else
                            <select name="quarter" id="" class="form-control">
                                {{-- <option value="">सबै त्रैमासिक
                                    </option> --}}
                                <option value="1" {{ currentquarter() == 1 ? 'selected' : '' }}
                                    {{ $quarterOne > $currentDate ? 'disabled' : '' }}>प्रथम त्रैमासिक
                                </option>
                                <option value="2" {{ currentquarter() == 2 ? 'selected' : '' }}
                                    {{ $quarterTwo > $currentDate ? 'disabled' : '' }}>द्वितीय त्रैमासिक
                                </option>
                                <option value="3" {{ currentquarter() == 3 ? 'selected' : '' }}
                                    {{ $quarterThree > $currentDate ? 'disabled' : '' }}>तृतीय त्रैमासिक
                                </option>
                                <option value="4" {{ currentquarter() == 4 ? 'selected' : '' }}
                                    {{ $quarterFour > $currentDate ? 'disabled' : '' }}>चौथो त्रैमासिक</option>
                            </select>
                        @endif
                        <button class="btn btn-info"> <i class="fa fa-filter"></i> फिल्टर</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-3 z-depth-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="d-flex">
                            <label><i class="fa fa-check text-success mr-2"></i>अ.ब.</label>
                            <i class="fa fa-arrow-right text-secondary px-3"></i>
                            <div style="width: 80px">
                                <label class="kalimati-font">{{ currentFiscalYear()->name }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="d-flex">
                            <label><i class="fa fa-check text-success mr-2"></i>जम्मा नबिकरण</label>
                            <i class="fa fa-arrow-right text-secondary px-3"></i>
                            <div style="width: 80px">
                                <label class="kalimati-font">{{ $total }} जना</label>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-3">
                        <div class="d-flex">
                            <label><i class="fa fa-check text-success mr-2"></i>पुरुष</label>
                            <i class="fa fa-arrow-right text-secondary px-3"></i>
                            <div style="width: 80px">
                                <label class="kalimati-font">{{ $male }} जना</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="d-flex">
                            <label><i class="fa fa-check text-success mr-2"></i>महिला</label>
                            <i class="fa fa-arrow-right text-secondary px-3"></i>
                            <div style="width: 80px">
                                <label class="kalimati-font">{{ $female }} जना</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="d-flex">
                            <label><i class="fa fa-check text-success mr-2"></i>अन्य</label>
                            <i class="fa fa-arrow-right text-secondary px-3"></i>
                            <div style="width: 80px">
                                <label class="kalimati-font">{{ $other }} जना</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="d-flex">
                            <label><i class="fa fa-check text-success mr-2"></i>भुक्तानी दर</label>
                            <i class="fa fa-arrow-right text-secondary px-3"></i>
                            <div style="width: 80px">
                                <label class="kalimati-font">रु {{$rate ?? 5000}} </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="d-flex">
                            <label><i class="fa fa-check text-success mr-2"></i>जम्मा रकम</label>
                            <i class="fa fa-arrow-right text-secondary px-3"></i>
                            <div style="width: 80px">
                                <label class="kalimati-font">रु {{ $totalPrice }}</label>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="col-12 d-flex justify-content-end align-items-center">
                        <a href="{{ route('patient.list') }}?quarter={{ request('quarter') }}" class="btn btn-info">Next<i
                                class="fas fa-chevron-right ml-2 position-relative top-3"></i></a>
                    </div> --}}
                </div>

            </div>
        </div>


        <div class="card mt-3 z-depth-0">
            <div class="card-body">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                            aria-selected="true">भुक्तानी भएको</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                            aria-selected="false">भुक्तानी
                            नभएको</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <h5 class="text-center fw-bold">{{ App\Address::find(municipalityId())->municipality }}</h5>
                        <label for="" class="col-12 text-center">मृर्गौला प्रत्यारोपण गरेका, डायलासिस गराई रहेका,
                            क्यान्सर
                            रोगी र मेरुदण्ड पक्षघातका बिरामीहरुलाई औषधि उपचार बापत खर्च उपलब्ध गराउने सम्बन्धि कार्यविधि
                            २०७८ बमोजिम
                            मासिक रु. ५ हजारका दरले रकम भुक्तानी दिएको बिबरण(आ. व. <span
                                class="kalimati-font">{{ currentFiscalYear()->name }}</span> )</label>
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
                                    @php
                                        $i=0;
                                    @endphp
                                    @foreach ($totalRenewInfo as $index=>$renew)
                                        @if ($renew->isPaid)
                                            @php
                                                $isPaid = true;
                                                $i+=1;
                                            @endphp
                                            <tr class="text-center">
                                                <td class="kalimati-font">{{ $i }}</td>
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
                                                <td class="kalimati-font">
                                                    {{ dateFormat($renew->patient->registered_date) }}
                                                </td>
                                                <td class="kalimati-font">{{ $renew->patient->citizenship_number }}</td>
                                                <td class="kalimati-font">{{ $renew->month }}</td>
                                                <td class="kalimati-font">रु {{ $renew->price_rate }}</td>
                                                <td class="kalimati-font">रु {{ $renew->price_rate * $renew->month }}</td>
                                                {{-- <td class="kalimati-font">{{ $renew->isPaid }}</td> --}}
                                                <td class="kalimati-font">{{ $renew->patient->mobile_number }}</td>
                                                {{-- <td>{{ $renew->isPaid ? 'Paid' : 'Unpaid' }}</td> --}}
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>

                            </table>
                            <div class="col-12 d-flex justify-content-end align-items-center">
                                @if ($isPaid)
                                    <div class="">
                                                                                <a class="fw-bold bg-success rounded text-white py-2 px-3 " href="{{ route('payment.export') }}?quarter={{ request('quarter') }}">Export to excel</a>
                                    </div>
                                @else
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModalCenter">
                                        भुक्तानी गर्नुहोस्
                                    </button>
                                    {{-- <a href="{{ route('payment') }}" class="btn btn-info">भुक्तानी गर्नुहोस्<i
                                    class="fas fa-chevron-right ml-2 position-relative top-3"></i></a> --}}
                                @endif
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <h5 class="text-center fw-bold">{{ App\Address::find(municipalityId())->municipality }}</h5>
                        <label for="" class="col-12 text-center">मृर्गौला प्रत्यारोपण गरेका, डायलासिस गराई रहेका,
                            क्यान्सर
                            रोगी र मेरुदण्ड पक्षघातका बिरामीहरुलाई औषधि उपचार बापत खर्च उपलब्ध गराउने सम्बन्धि कार्यविधि
                            २०७८ बमोजिम
                            मासिक रु. ५ हजारका दरले रकम भुक्तानी दिएको बिबरण(आ. व. <span
                                class="kalimati-font">{{ currentFiscalYear()->name }}</span> )</label>
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
                                    @php
                                        $j=0;
                                    @endphp
                                    @foreach ($totalRenewInfo as $renew)
                                        @if (!$renew->isPaid)
                                            @php
                                                $isPaid = false;
                                                $j+=1;
                                            @endphp
                                            <tr class="text-center">
                                                <td class="kalimati-font">{{ $j }}</td>
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
                                                <td class="kalimati-font">
                                                    {{ dateFormat($renew->patient->registered_date) }}
                                                </td>
                                                <td class="kalimati-font">{{ $renew->patient->citizenship_number }}</td>
                                                <td class="kalimati-font">{{ $renew->month }}</td>
                                                <td class="kalimati-font">रु {{ $renew->price_rate }}</td>
                                                <td class="kalimati-font">रु {{ $renew->price_rate * $renew->month }}</td>
                                                {{-- <td class="kalimati-font">{{ $renew->isPaid }}</td> --}}
                                                <td class="kalimati-font">{{ $renew->patient->mobile_number }}</td>
                                                {{-- <td>{{ $renew->isPaid ? 'Paid' : 'Unpaid' }}</td> --}}
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>

                            </table>
                            <div class="col-12 d-flex justify-content-end align-items-center">
                                @if (!$isPaid)
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#e">
                                        भुक्तानी गर्नुहोस् 
                                    </button>
                                    {{-- <a href="{{ route('payment') }}" class="btn btn-info">भुक्तानी गर्नुहोस्<i
                                    class="fas fa-chevron-right ml-2 position-relative top-3"></i></a> --}}
                                @endif
                              
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>


        <div class="modal fade" id="e" tabindex="-1" role="dialog"
            aria-labelledby="eTitle" aria-hidden="true" data-bs-backdrop="static"
            aria-labelledby="feedbackLabel">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">भुक्तानीको विवरण</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-lg-12">
                            <div class="d-flex">
                                <label><i class="fa fa-check text-success mr-2"></i>अ.ब.</label>
                                <i class="fa fa-arrow-right text-secondary px-3"></i>
                                <div style="width: 80px">
                                    <label class="kalimati-font">{{ currentFiscalYear()->name }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="d-flex">
                                <label><i class="fa fa-check text-success mr-2"></i>नयाँ नबिकरण</label>
                                <i class="fa fa-arrow-right text-secondary px-3"></i>
                                <div style="width: 80px">
                                    <label class="kalimati-font">{{ $total }} जना</label>
                                </div>
                            </div>

                        </div>
                        {{-- <div class="col-lg-12">
                            <div class="d-flex">
                                <label><i class="fa fa-check text-success mr-2"></i>नयाँ दर्ता</label>
                                <i class="fa fa-arrow-right text-secondary px-3"></i>
                                <div style="width: 80px">
                                    <label class="kalimati-font">{{ $total }} जना</label>
                                </div>
                            </div>

                        </div> --}}
                        <div class="col-lg-12">
                            <div class="d-flex">
                                <label><i class="fa fa-check text-success mr-2"></i>पुरुष</label>
                                <i class="fa fa-arrow-right text-secondary px-3"></i>
                                <div style="width: 80px">
                                    <label class="kalimati-font">{{ $male }} जना</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="d-flex">
                                <label><i class="fa fa-check text-success mr-2"></i>महिला</label>
                                <i class="fa fa-arrow-right text-secondary px-3"></i>
                                <div style="width: 80px">
                                    <label class="kalimati-font">{{ $female }} जना</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="d-flex">
                                <label><i class="fa fa-check text-success mr-2"></i>अन्य</label>
                                <i class="fa fa-arrow-right text-secondary px-3"></i>
                                <div style="width: 80px">
                                    <label class="kalimati-font">{{ $other }} जना</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="d-flex">
                                <label><i class="fa fa-check text-success mr-2"></i>भुक्तानी दर</label>
                                <i class="fa fa-arrow-right text-secondary px-3"></i>
                                <div style="width: 80px">
                                    <label class="kalimati-font">रु {{$rate}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="d-flex">
                                <label><i class="fa fa-check text-success mr-2"></i>जम्मा रकम</label>
                                <i class="fa fa-arrow-right text-secondary px-3"></i>
                                <div style="width: 80px">
                                    <label class="kalimati-font">रु {{ $totalPrice }}</label>
                                </div>
                            </div>
                        </div>

                        <small>
                            <i class="text-danger">नोट:यदि तपाइँ अनुमोदन गर्नुहुन्छ भने तपाइँ परिवर्तन गर्न सक्नुहुन्न</i>
                        </small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">हुदैन</button>
                        <a href="{{ route('payment') }}?quarter={{ request('quarter') }}" type="button"
                            class="btn btn-primary">हुन्छ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('myScript')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
@endpush
