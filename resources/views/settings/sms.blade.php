@extends('layouts.app')

@push('styles')
    <style>
        select {
            height: calc(1.5em + 1rem + 4px) !important;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        @include('alerts.success')
        <div class="row">
            <div class="col-lg-12 mb-3">
                @include('settings.menu')
            </div>
            <div class="col-lg-12">
                <div class="card z-depth-0 mb-3" style="border: 1px solid #ededed;">
                    <form action="{{ route('sms.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>API Endpoint</label>
                                <input type="text" class="form-control" name="sms_api_end_point" value="{{settings()->get("sms_api_end_point", $default = null)}}" required>
                            </div>
                            <div class="form-group">
                                <label>API Key</label>
                                <input type="text" class="form-control" name="sma_api_key" value="{{settings()->get("sma_api_key", $default = null)}}" required>
                            </div>
                            <div class="form-group">
                                <label>Sender ID</label>
                                <input type="text" class="form-control" name="sms_sender_id" value="{{settings()->get("sms_sender_id", $default = null)}}" required>
                            </div>
                            <div class="form-group">
                                <label>Route ID</label>
                                <input type="text" class="form-control" name="sms_router_id" value="{{settings()->get("sms_router_id", $default = null)}}" required>
                            </div>
                            <div class="text-right">
                                <button class="btn my-0 rounded z-depth-0 font-16px py-2 px-4"
                                    style="background-color:#374f67; color: #fff;">Save</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="my-4"></div>



    </div>
@endsection
