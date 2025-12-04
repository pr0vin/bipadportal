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
                    <form action="{{$committeePosition->id ? route('committeePosition.update',$committeePosition) : route('committeePosition.store') }}" method="POST">
                        @csrf
                        @isset($committeePosition->id)
                            @method('put')
                        @endisset
                        <div class="card-body">
                            <div class="form-group">
                                <label>समितिको पद</label>
                                <input type="text" class="form-control" name="name" value="{{old('name',$committeePosition->name)}}" required>
                            </div>
                            <div class="text-right">
                                <button class="btn my-0 rounded z-depth-0 font-16px py-2 px-4"
                                    style="background-color:#374f67; color: #fff;">{{$committeePosition->id ? 'अपडेट गर्नुहोस्' : 'पेश गर्नुहोस्'}}</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <div class="col-lg-8">
                <div class="card z-depth-0">
                    <div class="card-body">

                        @php
                            $committeePositions = App\CommitteePosition::where('address_id',municipalityId())->latest()->paginate(5);
                        @endphp
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">क्र.स.</th>
                                    <th class="text-center">समितिको पद</th>
                                    <th class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($committeePositions as $committeePosition)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $committeePosition->name }}</td>
                                        {{-- <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="{{route('committeePosition.edit',$committeePosition)}}" class="text-warning"><i class="fa fa-edit"></i></a>
                                                <form action="{{ route('committeePosition.delete', $committeePosition) }}" method="POST"
                                                    onsubmit="return confirm('के तपाइँ यो रेकर्ड मेटाउन निश्चित हुनुहुन्छ ?')">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit"
                                                        class="text-danger ml-2 border-0 bg-transparent"><i
                                                            class="fa fa-trash"></i></button>
                                                </form>
                                            </div>
                                        </td> --}}
                                        <td class="d-flex justify-content-center m-0 p-0 pt-1">
                                            <div class="dropdown">
                                                <button class="btn m-0 p-0 pb-2 mt-2 px-2" style="box-shadow: none"
                                                    type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    ...
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item"
                                                    href="{{route('committeePosition.edit',$committeePosition)}}">सम्पादन</a>
                                                    <form action="{{ route('committeePosition.delete', $committeePosition) }}" method="POST"
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
                            {{ $committeePositions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-4"></div>



    </div>
@endsection
