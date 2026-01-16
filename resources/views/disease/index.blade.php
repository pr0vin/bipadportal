@extends('layouts.app')

@section('content')
    <div class="container">
        @include('alerts.all')
    </div>
    <div class="container-fluid main-container" style="overflow: hidden">

        <div class="row">
            @can('disease.store')
                <div class="col-md-4">
                    <div class="card z-depth-0">
                        <div class="card-body">
                            <form action="{{ $disease->id ? route('disease.update', $disease) : route('disease.store') }}"
                                method="POST" class="form">
                                @csrf
                                @if ($disease->id)
                                    @method('put')
                                @endif
                                {{-- {{}} --}}
                                <div class="form-group">
                                    <label for="input-name">घटना </label>
                                    @if ($disease->id)
                                        <select name="application_type_id[]" id="" class="form-control">
                                            @foreach ($applicationTypes as $applicationType)
                                                <option
                                                    value="{{ $applicationType->id }}"{{ $applicationType->id == $disease->application_types[0]->id ? 'selected' : '' }}>
                                                    {{ $applicationType->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @else
                                        <select name="application_type_id[]" id="" class="form-control">
                                            @foreach ($applicationTypes as $applicationType)
                                                <option value="{{ $applicationType->id }}">
                                                    {{ $applicationType->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="input-name">प्रकोप</label>
                                    <input type="text" id="input-name" name="name" class="form-control" autocomplete="off"
                                        value="{{ old('name', $disease->name) }}">
                                </div>

                                


                                <div class="form-group">
                                    <button type="submit"
                                        class="btn btn-info col-12 z-depth-0">{{ $disease->id ? 'अपडेट गर्नुहोस्' : 'सेभ गर्नुहोस' }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endcan

            <div class="col-md-8">
                <div class="card z-depth-0">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="font-weight-bold h3-responsive d-inline-block m-0 p-0">रोगहरु</h5>
                        <form action="{{ route('disease.index') }}">
                            <select name="application_type_id" id="" class="form-control"
                                onchange="this.form.submit()">
                                <option value="">सबै प्रकार</option>
                                @if (request('application_type_id'))
                                    @foreach (App\ApplicationType::latest()->get() as $item)
                                        <option value="{{ $item->id }}"
                                            {{ request('application_type_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}</option>
                                    @endforeach
                                @else
                                    @foreach (App\ApplicationType::latest()->get() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </form>
                    </div>
                    <div class="card-body py-0">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th>क्र.स.</th>
                                    <th>रोग</th>
                                    <th>आवेदनको प्रकार (हरु)</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($diseases as $disease)
                                    <tr class="text-center">
                                        <td class="kalimati-font">{{ $loop->iteration }}</td>
                                        <td>{{ $disease->name }}</td>
                                        <td>
                                            @foreach ($disease->application_types as $applicationType)
                                                <div class="">
                                                    {{ $applicationType->name }}

                                                </div>
                                            @endforeach
                                        </td>
                                        <td class="d-flex m-0 p-0 pt-1">
                                            @canany(['disease.edit', 'disease.delete'])
                                                <div class="dropdown">
                                                    <button class="btn btn-option" style="box-shadow: none" type="button"
                                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <label for="">...</label>
                                                    </button>
                                                    <div class="dropdown-menu" style="position: relative;left:500px"
                                                        aria-labelledby="dropdownMenuButton">
                                                        @can('disease.edit')
                                                            <a class="dropdown-item"
                                                                href="{{ route('disease.edit', $disease) }}">सम्पादन</a>
                                                        @endcan
                                                        @can('disease.delete')
                                                            <form action="{{ route('disease.destroy', $disease) }}" method="POST"
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
                            {{ $diseases->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
