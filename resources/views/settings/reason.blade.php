@extends('layouts.app')

@push('styles')
    <style>
        select {
            height: calc(1.5em + 1rem + 4px) !important;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid" style="overflow: hidden">
        @include('alerts.success')
        <div class="row">
            <div class="col-lg-12 mb-3">
                @include('settings.menu')
            </div>
            <div class="col-lg-4">
                <div class="card z-depth-0 mb-3" style="border: 1px solid #ededed;">
                    <form action="{{ $reason->id ? route('reason.update',$reason) : route('reason.store') }}" method="POST">
                        @csrf
                        @isset($reason->id)
                            @method('put')
                        @endisset
                        <div class="card-body">
                            <div class="form-group">
                                <label>लागतकट्टाको कारण</label>
                                <input type="text" class="form-control" name="reason" value="{{old('reason',$reason->reason)}}" required>
                            </div>
                            <div class="text-right">
                                <button class="btn my-0 rounded z-depth-0 font-16px py-2 px-4"
                                    style="background-color:#374f67; color: #fff;"> {{$reason->id ? 'अपडेट ' : ' पेश '}} गर्नुहोस्</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <div class="col-lg-8">
                <div class="card z-depth-0">
                    <div class="card-body">

                        @php
                            $reasons = App\Reason::latest()->paginate(5);
                        @endphp
                        <table class="table">
                            <thead>
                                <tr class="text-center">
                                    <th>क्र.स.</th>
                                    <th>लागतकट्टाको कारण</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reasons as $reason)
                                    <tr class="text-center">
                                        <td class="kalimati-font">{{ $loop->iteration }}</td>
                                        <td>{{ $reason->reason }}</td>
                                        <td class="d-flex justify-content-center m-0 p-0 pt-1">
                                            <div class="dropdown">
                                                <button class="btn m-0 p-0 pb-2 mt-2 px-2" style="box-shadow: none"
                                                    type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    ...
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item"
                                                        href="{{ route('reason.edit', $reason) }}">सम्पादन</a>
                                                    <form action="{{ route('reason.delete', $reason) }}" method="POST"
                                                        onsubmit="return confirm('के तपाइँ यो रेकर्ड मेटाउन निश्चित हुनुहुन्छ ?')">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="dropdown-item">हटाउनुहोस्</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-12 d-flex justify-content-end">
                            {{ $reasons->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-4"></div>



    </div>
@endsection
