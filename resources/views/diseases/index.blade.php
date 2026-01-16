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
                        <form method="POST"
                            action="{{ isset($disease) ? route('diseases.update', $disease->id) : route('diseases.store') }}"
                            class="form">
                            @csrf
                            @if (isset($disease))
                                @method('PUT')
                            @endif

                            <div class="form-group">
                                <label for="input-name">रोगको नाम</label>
                                <input type="text" id="input-name" name="name" class="form-control"
                                    value="{{ old('name', $disease->name ?? '') }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                               <div>
                                        <link href="https://nepalidatepicker.sajanmaharjan.com.np/v5/nepali.datepicker/css/nepali.datepicker.v5.0.6.min.css" rel="stylesheet" type="text/css"/>

                                        <input type="text" id="nepali-datepicker" name="registered_date"
                                          
                                        class="form-control kalimati-font" placeholder="मिति छान्नुहोस्">
                                         <script src="https://nepalidatepicker.sajanmaharjan.com.np/v5/nepali.datepicker/js/nepali.datepicker.v5.0.6.min.js" type="text/javascript"></script>
                                        </script>
                                        <script type="text/javascript">
                                            window.onload = function() {
                                                var mainInput = document.getElementById("nepali-datepicker");
                                                mainInput.NepaliDatePicker();
                                            };
                                        </script>

                                    </div>

                         
                            <div class="form-group">
                                <button type="submit" class="btn btn-info col-12 z-depth-0">
                                    {{ isset($disease) ? 'अपडेट गर्नुहोस्' : 'सेभ गर्नुहोस्' }}
                                </button>
                            </div>

                            @if (isset($disease))
                                <a href="{{ route('diseases.index') }}" class="btn btn-secondary col-12 z-depth-0">
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
                        <h5 class="font-weight-bold h3-responsive d-inline-block m-0 p-0">रोगहरु</h5>
                    </div>
                    <div class="card-body py-0">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th>क्र.स.</th>
                                    <th>रोग</th>
                                    <th>कार्य</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($diseases as $item)
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
                                                    <a class="dropdown-item"
                                                        href="{{ route('diseases.edit', $item->id) }}">सम्पादन</a>
                                                    <form action="{{ route('diseases.destroy', $item->id) }}" method="POST"
                                                        onsubmit="return confirm('के तपाइँ यो रेकर्ड मेटाउन निश्चित हुनुहुन्छ ?')">
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
                                        <td colspan="3">No data found</td>
                                    </tr>
                                @endforelse
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


@push('scripts')
<script src="https://nepalidatepicker.sajanmaharjan.com.np/v5/nepali.datepicker/js/nepali.datepicker.v5.0.6.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('registered_date');

    if (input) {
        console.log("Nepali DatePicker initialized");
        input.NepaliDatePicker();
    }
});
</script>
@endpush
