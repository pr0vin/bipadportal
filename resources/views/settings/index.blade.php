@extends('layouts.app')

@push('styles')
    <style>
        select {
            height: calc(1.5em + 1rem + 4px) !important;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                @include('settings.menu')
            </div>
        </div>
        <div class="my-4"></div>

        @include('alerts.success')

        <form action="{{ route('settings.sync') }}" method="POST" class="form font-noto">
            @csrf

            @component('settings.group', [
                'title' => 'प्रणाली सेटिङ',
                'description' => 'सामान्य प्रणाली सेटिङ',
            ])
                <div>
                    @component('settings.input', [
                        'label' => 'App Name',
                        'name' => 'app_name',
                        'description' => 'The application name in Nepali',
                    ])
                    @endcomponent
                    <div class="my-3"></div>
                    @component('settings.input', [
                        'label' => 'App Name (English)',
                        'name' => 'app_name_en',
                        'description' => 'The application name in English',
                    ])
                    @endcomponent
                    <div class="my-3"></div>
                    @component('settings.input', [
                        'label' => 'Auto Increment Registration Prefix',
                        'name' => 'registration_auto_increment_prefix',
                        'description' =>
                            'This value holds the prefix for next registration number. It will auto increment after registration. Its often only required to change this during new fiscal year. Make sure this field is an english integer value.',
                        'type' => 'number',
                    ])
                    @endcomponent
                    <div class="my-3"></div>
                    @component('settings.input', [
                        'label' => 'Registration Number Suffix',
                        'name' => 'registration_number_suffix',
                        'description' =>
                            'The value to appended to the generated registration number. Its often only required to change this during new fiscal year.',
                    ])
                    @endcomponent
                    <div class="my-3"></div>
                    @component('settings.input', [
                        'label' => 'Registration number minimum digits',
                        'name' => 'registration_number_digits',
                    ])
                    @endcomponent
                </div>
            @endcomponent


        </form>
    </div>
    <div class="container">
        <div class="row">

            <div class="col-md-5">
                <h4 class="h4-responsive font-weight-bold mdb-color-text">आवेदन सेटिङ</h4>
                <p class="small text-muted">
                </p>
            </div>
            <div class="col-md-7">
                <div class="card z-depth-0" style="border: 1px solid #ededed;">
                    <form action="{{ route('application-type-update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            @foreach (App\ApplicationType::get() as $index => $item)
                                <label>{{ $item->name }} <small class="text-black-50">(रु.)</small></label>
                                <input type="number" class="form-control" name="amount_{{ $index + 1 }}"
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
        <div class="my-5" style="border-top: 1px dashed #d2d6dc;"></div>
    </div>
    <div class="container">
        <div class="row">

            <div class="col-md-5">
                <h4 class="h4-responsive font-weight-bold mdb-color-text">डाउनलोड योग्य कागजातहरू</h4>
                <p class="small text-muted">
                </p>
            </div>
            <div class="col-md-7">
                <div class="card z-depth-0" style="border: 1px solid #ededed;">
                    <form action="{{ route('download.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Document name</label>
                                <input type="text" class="form-control" name="document_name" required>
                            </div>
                            <div class="form-group">
                                <label>Document</label>
                                <input type="file" class="form-control" name="document" required>
                            </div>
                        </div>
                        <div class="p-3 text-right">
                            <button class="btn my-0 rounded z-depth-0 font-16px py-2 px-4"
                                style="background-color:#374f67; color: #fff;">Save</button>
                        </div>
                    </form>
                    <hr>
                    @php
                        $downloads = App\Download::latest()->paginate(5);
                    @endphp
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">SN</th>
                                <th class="text-center">Document name</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($downloads as $download)
                                <tr>
                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td class="text-center">{{$download->document_name}}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a target="__blank" href="{{ asset('storage') . '/' . $download->document }}" class="text-info"><i class="fa fa-eye"></i></a>
                                            <form action="{{route('download.delete',$download)}}" method="POST" onsubmit="return confirm('Are you sure ?')">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="text-danger ml-2 border-0 bg-transparent"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="col-12 d-flex justify-content-end">
                        {{$downloads->links()}}
                    </div>
                </div>
            </div>
        </div>
        <div class="my-5" style="border-top: 1px dashed #d2d6dc;"></div>
    </div>
    <div class="container">
        <div class="row">

            <div class="col-md-5">
                <h4 class="h4-responsive font-weight-bold mdb-color-text">लागतकट्टाका कारणहरु</h4>
                <p class="small text-muted">
                </p>
            </div>
            <div class="col-md-7">
                <div class="card z-depth-0" style="border: 1px solid #ededed;">
                    <form action="{{ route('reason.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Reason</label>
                                <input type="text" class="form-control" name="reason" required>
                            </div>
                        </div>
                        <div class="p-3 text-right">
                            <button class="btn my-0 rounded z-depth-0 font-16px py-2 px-4"
                                style="background-color:#374f67; color: #fff;">Save</button>
                        </div>
                    </form>
                    <hr>
                    @php
                        $reasons = App\Reason::latest()->paginate(5);
                    @endphp
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">SN</th>
                                <th class="text-center">Reason</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reasons as $reason)
                                <tr>
                                    <td class="text-center">{{$loop->iteration}}</td>
                                    <td class="text-center">{{$reason->reason}}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <form action="{{route('reason.delete',$reason)}}" method="POST" onsubmit="return confirm('Are you sure ?')">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="text-danger ml-2 border-0 bg-transparent"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="col-12 d-flex justify-content-end">
                        {{$reasons->links()}}
                    </div>
                </div>
            </div>
        </div>
        <div class="my-5" style="border-top: 1px dashed #d2d6dc;"></div>
    </div>

    {{-- <div class="d-flex align-items-start px-5" style="min-height: 84vh">
        <div class="nav  flex-column nav-pills bg-white p-3 me-3" style="min-height: 80vh" id="v-pills-tab" role="tablist" aria-orientation="vertical">
          <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Application Settings</button>
          <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Registration Setting</button>
          <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Downloadable documents</button>
          <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Reasons</button>
        </div>
        <div class="tab-content" id="v-pills-tabContent">
          <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">..1.</div>
          <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">..2.</div>
          <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">.3..</div>
          <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">..4.</div>
        </div>
      </div> --}}

@endsection

{{-- @push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<style>
    .nav-link{
        color: #fff;
    }
    .nav-pills button {
  text-align: left;
  padding-left: 1rem;
    color: #000
}
</style>
@endpush --}}
