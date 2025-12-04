@extends('layouts.app')

@push('styles')
    <style>
        select {
            height: calc(1.5em + 1rem + 4px) !important;
        }
    </style>
@endpush

@if ($organization->id)
    @push('myScript')
        <script>
            $("#exampleModalCenter").modal('show')
        </script>
    @endpush
@endif
@section('content')
    <div class="container-fluid main-container" style="overflow-x: hidden">

        @include('alerts.all')
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="m-0 p-0">नयाँ पालिका दर्ता</h5>
            @can('newPalika.store')
                <button type="button" class="btn btn-primary z-depth-0" data-toggle="modal" data-target="#exampleModalCenter">
                    <i class="fa fa-plus"></i> नयाँ पालिका थप्नुहोस
                </button>
            @endcan
        </div>
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">नयाँ पालिका दर्ता</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ $organization->id ? route('orgUpdate', $organization) : route('organization.store') }}"
                        method="POST">
                        @csrf
                        @isset($organization->id)
                            @method('put')
                        @endisset
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="font-weight-normal">प्रदेश <span class="text-danger">*</span> </label>
                                        <select name="province_id" class="form-control" id="province" required>
                                            <option value="">पालिका छान्नुहोस्</option>
                                            @foreach ($provinces as $province)
                                                <option value="{{ $province->province }}"
                                                    {{ $province->province == $address->province ? 'selected' : '' }}>
                                                    {{ $province->province }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="font-weight-normal">जिल्ला <span class="text-danger">*</span></label>
                                        @if ($organization->id)
                                            <select name="district_id" class="form-control" id="district" required>
                                                <option value="{{ $address->district }}">{{ $address->district }}</option>
                                            </select>
                                        @else
                                            <select name="district_id" class="form-control" id="district"
                                                required>
                                                <option value="">जिल्ला छान्नुहोस्</option>
                                            </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="font-weight-normal">पालिका <span class="text-danger">*</span></label>
                                        @if ($organization->id)
                                            <select name="address_id" class="form-control" id="municipality" required>
                                                <option value="{{ $address->id }}">{{ $address->municipality }}</option>
                                            </select>
                                        @else
                                            <select name="address_id" class="form-control" id="municipality"
                                                required>
                                                <option value="">पालिका छान्नुहोस्</option>
                                            </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="font-weight-normal">ट्यागलाइन</label>
                                        <input type="text" name="tag_line"
                                            value="{{ old('tag_line', $organization->tag_line) }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="font-weight-normal">ठेगाना (एक)</label>
                                        <input type="text" name="address_line_one"
                                            value="{{ old('address_line_one', $organization->address_line_one) }}"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="font-weight-normal">ठेगाना (दुई)</label>
                                        <input type="text" name="address_line_two"
                                            value="{{ old('address_line_two', $organization->address_line_two) }}"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="font-weight-normal">फोन नम्बर</label>
                                        <input type="text" name="phone"
                                            value="{{ old('phone', $organization->phone) }}" class="form-control kalimati-font">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="font-weight-normal">इमेल</label>
                                        <input type="email" name="email"
                                            value="{{ old('email', $organization->email) }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="font-weight-normal">वेबसाइट</label>
                                        <input type="text" name="website"
                                            value="{{ old('website', $organization->website) }}" class="form-control"
                                        >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="checkbox" name="is_allowed_to_register" value="1" {{$organization->is_allowed_to_register ? 'checked' : ''}} id="allowWard">
                                        <label class="font-weight-normal" for="allowWard">वार्डहरूलाई बिरामी दर्ता गर्न अनुमति दिनुहोस्</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="{{route('organization.index')}}" class="btn btn-secondary" >रद्द गर्नुहोस</a>
                            <button type="submit"
                                class="btn btn-primary">{{ $organization->id ? 'अपडेट गर्नुहोस्' : 'पेश गर्नुहोस्' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card z-depth-0">
            <div class="card-body py-0">
                <table class="table table-striped table-hover">
                    <thead class="">
                        <tr>
                            <th>#</th>
                            <th>प्रदेश</th>
                            <th>जिल्ला</th>
                            <th>पालिका</th>
                            <th>इमेल</th>
                            {{-- <th>ठेगाना</th> --}}
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($organizations as $organization)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $organization->address->province }}</td>
                                <td>{{ $organization->address->district }}</td>
                                <td>{{ $organization->address->municipality }}</td>
                                <td>{{ $organization->email }}</td>
                                {{-- <td>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('orgEdit', $organization) }}" class="btn btn-danger" style="height: 38px"><i class="fa fa-edit"></i></a>
                                        <form action="{{route('orgDelete',$organization)}}" method="POST" onsubmit="return confirm('के तपाइँ यो रेकर्ड मेटाउन निश्चित हुनुहुन्छ ?')">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-warning"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td> --}}

                                <td class="d-flex m-0 p-0 pt-1 justify-content-center">
                                    @canany(['newPalika.edit', 'newPalika.delete'])
                                        <div class="dropdown">
                                            <button class="btn btn-option" style="box-shadow: none" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <label for="">...</label>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                @can('newPalika.edit')
                                                    <a class="dropdown-item"
                                                        href="{{ route('orgEdit', $organization) }}">सम्पादन</a>
                                                @endcan
                                                @can('newPalika.delete')
                                                    <form action="{{ route('orgDelete', $organization) }}" method="POST"
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

            </div>
        </div>
        {{-- <div class="card z-depth-0">
            <div class="card-body">
                <h2 class="h2-responsive font-weight-bolder font-noto mdb-color-text">@lang('navigation.my_settings')</h2>

                <div class="my-4"></div>

                <div class="card z-depth-0 shadow">
                    <div class="card-header grey lighten-5">Letterpad Preview</div>
                    <div class="card-body">
                        <x-ward-letterhead />
                    </div>
                </div>

                <div class="my-4"></div>

                <form action="{{ route('user.settings.sync') }}" method="POST" class="form">
                    @csrf
                    <h4 class="h4-responsive font-weight-bolder font-noto mdb-color-text">Letterpad Settings</h4>
                    <div class="small text-muted font-noto">These values are used to construct the letter pad for your ward.
                    </div>

                    <div class="my-3"></div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Municipality Name</label>
                                <input type="text" name="letter_municipality_name" class="form-control"
                                    value="{{ old('letter_municipality_name', $userSettings->letter_municipality_name) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tagline</label>
                                <input type="text" name="letter_tagline" class="form-control"
                                    value="{{ old('letter_tagline', $userSettings->letter_tagline) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Address Line One</label>
                                <input type="text" name="letter_address_line_one" class="form-control"
                                    value="{{ old('letter_address_line_one', $userSettings->letter_address_line_one) }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Address Line Two</label>
                                <input type="text" name="letter_address_line_two" class="form-control"
                                    value="{{ old('letter_address_line_two', $userSettings->letter_address_line_two) }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" name="letter_phone" class="form-control"
                                    value="{{ old('letter_phone', $userSettings->letter_phone) }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>E-mail</label>
                                <input type="text" name="letter_email" class="form-control"
                                    value="{{ old('letter_email', $userSettings->letter_email) }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Website</label>
                                <input type="text" name="letter_website" class="form-control"
                                    value="{{ old('letter_website', $userSettings->letter_website) }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary font-noto z-depth-0">Save</button>
                    </div>
                </form>
            </div>
        </div> --}}
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#province").on('change', function() {
                let id = $(this).val();
                var url = "{{ route('get.district', ':id') }}";
                url = url.replace(':id', id);

                $.ajax({
                    url: url,
                    type: "GET",
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    cache: false,
                    dataType: 'json',
                    success: function(dataResult) {
                        const selectElement = $(
                            '#district');
                        selectElement.empty();
                        selectElement.append($('<option>', {
                            value: "",
                            text: "जिल्ला छान्नुहोस्"

                        }));
                        $.each(dataResult, function(index, item) {

                            selectElement.append($('<option>', {
                                value: item.district,
                                text: item.district

                            }));

                        });
                    }
                });
            })

            $("#district").on('change', function() {
                let id = $(this).val();
                var url = "{{ route('get.municipality', ':id') }}";
                url = url.replace(':id', id);

                $.ajax({
                    url: url,
                    type: "GET",
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    cache: false,
                    dataType: 'json',
                    success: function(dataResult) {
                        const selectElement = $(
                            '#municipality');
                        selectElement.empty();
                        selectElement.append($('<option>', {
                            value: "",
                            text: "नगरपालिका छान्नुहोस्"

                        }));
                        $.each(dataResult, function(index, item) {
                            console.log(item)
                            selectElement.append($('<option>', {
                                value: item.id,
                                text: item.municipality

                            }));

                        });
                    }
                });
            })
        })
    </script>
@endpush
