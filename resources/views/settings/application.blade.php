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
                <div class="card z-depth-0" style="border: 1px solid #ededed;">
                    <form action="{{ route('application-type-update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            @foreach (App\ApplicationType::get() as $index => $item)
                                <label>{{ $item->name }} <small class="text-black-50">(रु.)</small></label>
                                <input type="number" class="form-control kalimati-font" name="amount_{{ $index + 1 }}"
                                    value="{{ $item->amount }}" required>
                                <div class="mb-3"></div>
                            @endforeach

                        </div>
                        <div class="p-3 text-right" style="background-color:#f9fafb">
                            <button class="btn my-0 rounded z-depth-0 font-16px py-2 px-4"
                                style="background-color:#374f67; color: #fff;">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="my-4"></div>



    </div>
@endsection
