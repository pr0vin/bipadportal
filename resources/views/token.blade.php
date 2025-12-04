@extends('layouts.frontend')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 py-5">
                <div class="card p-5 grey lighten-5 z-depth-0">
                    <div class="card-body">
                        <h2 class="h2-responsive text-center font-noto">बिरामी दर्ता को लागी तपाइँको आवेदन प्रक्रियामा छ।
                        </h2>
                        <div class="text-center my-4">
                            <div class="d-inline-block rounded bg-light text-dark font-weight-bolder p-3"
                                style="font-size: 28px;"><small class="">टोकन नम्बर:</small><span class="kalimati-font">{{ $onlineApplication->token_number }}</span>
                                </div>
                            <div class="my-4"></div>

                            {{-- <button class="btn btn-success z-depth-0 btn-lg font-16px lang-english" data-toggle="modal"
                                data-target="#exampleModalCenter"><span class="mr-3"><i
                                        class="fa fa-print"></i></span>Print Form</button> --}}
                            <a class="btn btn-success z-depth-0 btn-lg font-16px lang-english" href="{{ route('suchi-print-application', $onlineApplication->patient) }}"><span class="mr-3"><i class="fa fa-print"></i></span>प्रिन्ट फारम</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">आवेदनको प्रकार</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                {{-- <span aria-hidden="true">&times;</span> --}}
                            </button>
                        </div>
                        <form action="{{route('patient.applicationApply')}}" method="POST">
                            @csrf
                            <input type="hidden" value="{{$onlineApplication->patient->id}}" name="patient_id" id="">
                            <input type="hidden" name="token_number" value="{{$onlineApplication->token_number}}" id="">
                            <div class="modal-body">
                                {{-- @foreach ($onlineApplication->patient->disease->application_types as $application_type)
                                    <div class="form-check">
                                        <input class="form-check-input"
                                            value="{{ $application_type->application_type->id }}" type="radio"
                                            name="application_type_id"
                                            id="flexRadioDefault2{{ $application_type->application_type->id }}" checked>
                                        <label class="form-check-label"
                                            for="flexRadioDefault2{{ $application_type->application_type->id }}">
                                            {{ $application_type->application_type->name }}
                                        </label>
                                    </div>
                                @endforeach --}}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Apply & Print</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
