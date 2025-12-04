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
                    <form action="{{ $document->id ? route('download.update', $document->id) : route('download.store') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @isset($document->id)
                            @method('put')
                        @endisset
                        <div class="card-body">
                            <div class="form-group">
                                <label>कागजातको नाम</label>
                                <input type="text" class="form-control" name="document_name"
                                    value="{{ old('document_name', $document->document_name) }}" required>
                            </div>
                            <div class="form-group">
                                <label>कागजात</label>
                                <input type="file" class="form-control" name="document" {{$document->id ? '' : 'required'}}>
                            </div>
                            <div class="text-right">
                                <button class="btn my-0 rounded z-depth-0 font-16px py-2 px-4"
                                    style="background-color:#374f67; color: #fff;">{{ $document->id ? 'अपडेट गर्नुहोस्' : 'पेश गर्नुहोस्' }}</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <div class="col-lg-8">
                <div class="card z-depth-0">
                    <div class="card-body">
                        @php
                            $downloads = App\Download::latest()->paginate(5);
                        @endphp
                        <table class="table">
                            <thead>
                                <tr class="text-center">
                                    <th class="text-center">क्र.स.</th>
                                    <th class="text-center"> कागजातको नाम</th>
                                    <th class="text-center">कागजात</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($downloads as $download)
                                    <tr class="text-center">
                                        <td class="kalimati-font">{{ $loop->iteration }}</td>
                                        <td><a href="{{ asset('storage') . '/' . $download->document }}" target="__blank">{{ $download->document_name }}</a></td>
                                        {{-- <td>
                                            <div class="d-flex justify-content-center">
                                                <a target="__blank"
                                                    href="{{ asset('storage') . '/' . $download->document }}"
                                                    class="text-info"><i class="fa fa-eye"></i></a>
                                                <a class="text-warning ml-2"
                                                    href="{{ route('settings.document.edit', $download->id) }}"><i
                                                        class="fa fa-edit"></i></a>
                                                <form action="{{ route('download.delete', $download) }}" method="POST"
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
                                                <button class="btn m-0 p-0 pb-2 mt-2 px-2" style="box-shadow: none" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    ...
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a target="__blank" class="dropdown-item" href="{{ asset('storage') . '/' . $download->document }}">हेर्नुहोस्</a>
                                                    <a class="dropdown-item"
                                                    href="{{ route('settings.document.edit', $download->id) }}">सम्पादन</a>
                                                    <form action="{{ route('download.delete', $download) }}"
                                                        method="POST"
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
                            {{ $downloads->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-4"></div>



    </div>
@endsection
