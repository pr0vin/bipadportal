@extends('layouts.app')

@section('content')
    <div class="container">
        @include('alerts.all')
    </div>
    <div class="container-fluid main-container" style="overflow: hidden">
        <div class="row">
            @can('committee.store')
                <div class="col-md-4">
                    <div class="card z-depth-0">
                        <div class="card-body">
                            <form
                                action="{{ $committee->id ? route('committee.update', $committee) : route('committee.store') }}"
                                method="POST" class="form">
                                @csrf
                                @isset($committee->id)
                                    @method('put')
                                @endisset
                                <div class="form-group">
                                    <label>समितिको प्रकार</label>
                                    <select name="application_type_id" id="" class="form-control">
                                        <option value="" selected disabled>समितिको प्रकार छान्नुहोस्</option>
                                        @foreach ($committeeTypes as $committeeType)
                                            <option value="{{ $committeeType->id }}"
                                                {{ old('application_type_id', $committee->application_type_id == $committeeType->id ? 'selected' : '') }}>
                                                {{ $committeeType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>समितिको नाम</label>
                                    <input type="text" class="form-control" name="name"
                                        value="{{ old('name', $committee->name) }}">
                                </div>
                                <div class="form-group">
                                    <button type="submit"
                                        class="btn btn-info col-12 z-depth-0">{{ $committee->id ? 'अपडेट गर्नुहोस्' : 'सेभ गर्नुहोस' }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endcan

            <div class="col-md-8">
                <div class="card z-depth-0">
                    <div class="card-header bg-white">
                        <h5 class="font-weight-bold m-0 p-0 h3-responsive d-inline-block">समितिहरु</h5>
                    </div>
                    <div class="card-body py-0">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th>क्र.स.</th>
                                    <th>समिति</th>
                                    {{-- <th>समितिको प्रकार (हरु)</th> --}}
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($committies as $committee)
                                    <tr class="text-center">
                                        <td class="kalimati-font">{{ $loop->iteration }}</td>
                                        <td>{{ $committee->name }}</td>
                                        {{-- <td>{{ $committee->type->name }}</td> --}}
                                        <td class="d-flex m-0 p-0 pt-1">
                                            @canany(['committee.edit', 'committee.delete', 'member.store', 'member.edit',
                                                'member.delete'])
                                                <div class="dropdown">
                                                    <button class="btn btn-option" style="box-shadow: none" type="button"
                                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <label for="">...</label>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        @canany(['member.store', 'member.edit', 'member.delete'])
                                                            <a class="dropdown-item"
                                                                href="{{ route('member.index') }}?committee_id={{ $committee->id }}">सदस्यहरु</a>
                                                        @endcanany
                                                        @can('committee.edit')
                                                            <a class="dropdown-item"
                                                                href="{{ route('committee.edit', $committee) }}">सम्पादन</a>
                                                        @endcan
                                                        @can('committee.delete')
                                                            <form action="{{ route('committee.delete', $committee) }}"
                                                                method="POST"
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
            </div>
        </div>
    </div>
@endsection
