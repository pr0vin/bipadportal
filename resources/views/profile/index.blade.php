@extends('layouts.app')

@push('styles')
    <style>
        #dashboard {
            min-height: 100vh;
            padding: 1rem;
        }

        a.bg-white {
            color: #1f2d3d !important;
        }

        .dashboard-main-title {
            font-weight: bold;
            display: flex;
            justify-content: center;
            color: #7d8888;
            font-size: 14px;
        }

        .dashboard-card-title {
            font-weight: bold;

        }

        .underline {
            border-bottom: 2px dashed #000;
            padding: 0 10px;
        }
    </style>
@endpush

@section('content')
    <div class="px-5 d-flex justify-content-center">
        <div class="card z-depth-0 mb-3 col-md-4">
            <div class="card-body">
                <form action="{{ route('doctor.profile.update') }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label>नाम</label>
                        <input type="text" class="form-control" name="name" value="{{ $user->name }}"
                            id="">
                    </div>


                    <div class="form-group">
                        <label>इमेल</label>
                        <input type="text" class="form-control" name="email" value="{{ $user->email }}"
                            id="">
                    </div>

                    <div class="form-group">
                        <label>एन.एम.सी. नम्बर</label>
                        <input type="text" class="form-control" name="nmc_no" value="{{$user->profile->nmc_no}}" id="">
                    </div>

                    <div class="form-group">
                        <label>पद</label>
                        <input type="text" class="form-control" name="post" value="{{$user->profile->post}}" id="">
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-info z-depth-0">अपडेट गर्नुहोस्</button>
                    </div>
                </form>
                {{-- <div class="form-group">
                    <label>काम गर्ने अस्पतालको नाम</label>
                    <input type="text" class="form-control" name="" value="" id="">
                </div> --}}
            </div>
        </div>
    </div>
@endsection
