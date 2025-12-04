@extends('layouts.frontend')

@section('breadcrumb')
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">ड्यासबोर्ड</a></li>
            <li class="breadcrumb-item"><a href="{{ route('frontent.apply') }}">सूची दर्ता</a></li>
            {{-- <li class="breadcrumb-item active" aria-current="page">{{ $updateMode ? 'सम्पादन' : 'नयाँ' }}</li> --}}
        </ol>
    </nav>
@endsection

@section('content')
    <div class="container">


        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 py-5">
                @hasanyrole('admin|super-admin|ward-secetary')
                    <div>
                        <a href="{{ route('home') }}" class="text-secondary"><i class="bi bi-arrow-left"></i> Back</a>
                    </div>
                @endhasanyrole

                <div class="card">
                    <div class="card-body">
                        <h2 class="h2-responsive text-center font-noto">सूची दर्ताको लागी तपाइँको आवेदन प्रक्रियामा छ।</h2>
                        <div class="text-center my-4">
                            <div class="d-inline-block rounded border border-primary text-dark font-weight-bolder p-3"
                                style="font-size: 28px;"><small class="lang-english">टोकन नम्बर:</small> <span
                                    class="kalimati-font"> {{ $patient->onlineApplication->token_number }}</span></div>
                            <div class="my-4"></div>
                            <a class="btn btn-success z-depth-0 btn-lg font-16px"
                                href="{{ route('suchi-print-application', $patient) }}"><span class="mr-3"><i
                                        class="fa fa-print"></i></span>प्रिन्ट फारम</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
