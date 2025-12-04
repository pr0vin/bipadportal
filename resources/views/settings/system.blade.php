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
            @role('super-admin')
                <div class="col-lg-12">
                    <form action="{{ route('settings.sync') }}" method="POST" class="form font-noto" enctype="multipart/form-data">
                        @csrf

                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 mb-3">

                                        @component('settings.input', [
                                            'label' => 'App Name',
                                            'name' => 'app_name',
                                            'description' => 'The application name in Nepali',
                                        ])
                                        @endcomponent
                                    </div>
                                    <div class="col-lg-6 mb-3">

                                        @component('settings.input', [
                                            'label' => 'App Name (English)',
                                            'name' => 'app_name_en',
                                            'description' => 'The application name in English',
                                        ])
                                        @endcomponent
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        @component('settings.input', [
                                            'label' => 'Auto Increment Registration Prefix',
                                            'name' => 'registration_auto_increment_prefix',
                                            'description' =>
                                                'This value holds the prefix for next registration number. It will auto increment after registration. Its often only required to change this during new fiscal year. Make sure this field is an english integer value.',
                                            'type' => 'number',
                                        ])
                                        @endcomponent

                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        @component('settings.input', [
                                            'label' => 'Registration Number Suffix',
                                            'name' => 'registration_number_suffix',
                                            'description' =>
                                                'The value to appended to the generated registration number. Its often only required to change this during new fiscal year.',
                                        ])
                                        @endcomponent
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        @component('settings.input', [
                                            'label' => 'Registration number minimum digits',
                                            'name' => 'registration_number_digits',
                                        ])
                                        @endcomponent
                                    </div>

                                    <div class="col-lg-12 mb-3">
                                        <div>
                                            <label class="font-weight-bolder mdb-color-text mb-0">user manual</label>
                                            {{-- <small class="form-text text-muted mt-0 mb-2">{{ $description ?? '' }}</small> --}}
                                            <input type="file" name="user_manual" class="form-control"
                                                value="{{ old('user_manual', settings()->get('user_manual')) }}">
                                        </div>

                                    </div>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-info">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </form>
                </div>
            @endrole
        </div>
        <div class="my-4"></div>



    </div>
@endsection
