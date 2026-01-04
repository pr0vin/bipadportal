@extends('layouts.app')

@section('content')
    <div class="container">
        @include('alerts.all')
    </div>

    <div class="container-fluid main-container" style="overflow: hidden">
        <div class="row">
            <div class="col-md-4">
                <div class="card z-depth-0">
                    <div class="card-body">
                        <form
                            method="POST"
                            action="{{ isset($unit) ? route('units.update', $unit->id) : route('units.store') }}"
                            class="form">
                            @csrf
                            @if(isset($unit))
                                @method('PUT')
                            @endif

                            <div class="form-group">
                                <label for="input-name">ईकाईको नाम</label>
                                <input type="text"
                                       id="input-name"
                                       name="name"
                                       class="form-control"
                                       value="{{ old('name', $unit->name ?? '') }}"
                                       placeholder="ईकाईको नाम प्रविष्ट गर्नुहोस्">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit"
                                        class="btn btn-info col-12 z-depth-0">
                                    {{ isset($unit) ? 'अपडेट गर्नुहोस्' : 'सेभ गर्नुहोस्' }}
                                </button>
                            </div>

                            @if(isset($unit))
                                <a href="{{ route('units.index') }}" class="btn btn-secondary col-12 z-depth-0">
                                    रद्द गर्नुहोस्
                                </a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            {{-- LIST --}}
            <div class="col-md-8">
                <div class="card z-depth-0">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="font-weight-bold h3-responsive d-inline-block m-0 p-0">ईकाईहरु</h5>
                       
                    </div>
                    <div class="card-body py-0">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th>क्र.स.</th>
                                    <th>ईकाईको नाम</th>
                                    <th>कार्य</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($units as $item)
                                    <tr class="text-center">
                                        <td class="kalimati-font">{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td class="d-flex justify-content-center">
                                            <div class="dropdown">
                                                <button class="btn btn-option" style="box-shadow: none" type="button"
                                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                    <label for="">...</label>
                                                </button>
                                                <div class="dropdown-menu" style="position: relative; left: 500px"
                                                     aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="{{ route('units.edit', $item->id) }}">सम्पादन</a>
                                                    <form action="{{ route('units.destroy', $item->id) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('के तपाइँ यो ईकाई मेटाउन निश्चित हुनुहुन्छ ?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item">हटाउनुहोस्</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="text-center">
                                        <td colspan="3">कुनै डाटा फेला परेन</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-end">
                            {{ $units->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection