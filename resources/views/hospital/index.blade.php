@extends('layouts.app')

@section('content')
    <div class="container">
        @include('alerts.all')
    </div>
    <div class="container-fluid main-container" style="overflow: hidden">
        <div class="row">
            @can('hospital.store')
                <div class="col-md-4">
                    <div class="card z-depth-0">
                        <div class="card-body">
                            <form action="{{ $hospital->id ? route('hospital.update', $hospital) : route('hospital.store') }}"
                                method="POST" class="form">
                                @csrf

                                @isset($hospital->id)
                                    @method('PUT')
                                @endisset
                                <div class="form-group">
                                    <label for="input-name">नाम</label>
                                    <input type="text" class="form-control" name="name"
                                        value="{{ old('name', $hospital->name) }}" id="">
                                </div>
                                <div class="form-group">
                                    <label for="input-name">ठेगाना</label>
                                    <input type="text" class="form-control" name="address"
                                        value="{{ old('address', $hospital->address) }}" id="">
                                </div>
                                <div class="form-group">
                                    <label for="input-name">राेग(हरु)</label>
                                    <textarea name="diseases" class="form-control" id="" cols="30" rows="5">{{ old('diseases', $hospital->diseases) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <button type="submit"
                                        class="btn btn-info col-12 z-depth-0">{{ $hospital->id ? 'अपडेट गर्नुहोस्' : 'सेभ गर्नुहोस' }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endcan

            <div class="col-md-8">
                <div class="card z-depth-0">
                    <div class="card-header bg-white">
                        <h5 class="font-weight-bold h3-responsive d-inline-block m-0 p-0">अस्पताल हरु</h5>
                    </div>
                    <div class="card-body py-0">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th>क्र.स.</th>
                                    <th>नाम</th>
                                    <th>ठेगाना</th>
                                    <th>रोग(हरु)</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hospitals as $hospital)
                                    <tr class="text-center">
                                        <td class="kalimati-font">{{ $loop->iteration }}</td>
                                        <td>{{ $hospital->name }}</td>
                                        <td>{{ $hospital->address }}</td>
                                        <td>{{ $hospital->diseases }}</td>
                                        {{-- <td class="d-flex justify-content-center align-items-center">
                                            <a href="{{route('hospital.edit',$hospital)}}" class="btn btn-warning"><i class="fa fa-pen"></i></a>
                                            <form action="{{route('hospital.delete',$hospital)}}" method="POST" onsubmit="return confirm('के तपाइँ यो रेकर्ड मेटाउन निश्चित हुनुहुन्छ ?')">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </td> --}}
                                        <td class="d-flex m-0 p-0 pt-1">
                                            @canany(['hospital.edit', 'hospital.delete'])
                                                <div class="dropdown">
                                                    <button class="btn btn-option" style="box-shadow: none" type="button"
                                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <label for="">...</label>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        @can('hospital.edit')
                                                            <a class="dropdown-item"
                                                                href="{{ route('hospital.edit', $hospital) }}">सम्पादन</a>
                                                        @endcan
                                                        @can('hospital.delete')
                                                            <form action="{{ route('hospital.delete', $hospital) }}" method="POST"
                                                                onsubmit="return confirm('के तपाइँ यो रेकर्ड मेटाउन निश्चित हुनुहुन्छ ?')">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" class="dropdown-item">हटाउनुहोस्</button>
                                                            </form>
                                                        @endcan
                                                    </div>
                                                </div>
                                            @endcanany
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-end">
                            {{-- {{$diseases->links()}} --}}
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-2">
                    {{$hospitals->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
