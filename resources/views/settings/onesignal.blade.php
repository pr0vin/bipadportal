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
                    <form action="{{ route('token.onesignal.sync') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Onesignal App ID</label>
                                <input type="text" class="form-control" name="onesignal_app_id" value="{{settings()->get("onesignal_app_id", $default = null)}}" required>
                            </div>
                            <div class="form-group">
                                <label>Onesignal API Key</label>
                                <input type="text" class="form-control" name="onesignal_api_key" value="{{settings()->get("onesignal_api_key", $default = null)}}" required>
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
