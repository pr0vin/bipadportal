@extends('layouts.app')

@section('content')
    <div class="container">
        @include('alerts.all')
    </div>
    <div class="container-fluid main-container" style="overflow: hidden">
        <div class="row">
            @can('member.store')
                <div class="col-md-4">
                    <div class="card z-depth-0">
                        <div class="card-body">
                            <form action="{{ $member->id ? route('member.update', $member) : route('member.store') }}"
                                method="POST" class="form">
                                @csrf
                                @isset($member->id)
                                    @method('put')
                                @endisset
                                <div class="form-group">
                                    <label>समितिको नाम</label>
                                    {{-- <select name="" id="" class="form-control" readonly>
                                    <option value="" selected disabled>समिति छान्नुहोस्</option>
                                    @foreach ($committies as $committee)
                                        <option value="{{$committee->id}}" {{request('committee_id') == $committee->id ? 'selected' : ''}} {{old('committee_id',$member->committee_id) == $committee->id ? 'selected' : ''}}>{{$committee->name}}</option>
                                    @endforeach
                                </select> --}}
                                    @php
                                        $committee = App\Committee::find(request('committee_id'));
                                    @endphp
                                    <input type="text" value="{{ $committee ? $committee->name : '' }}" class="form-control"
                                        readonly>
                                </div>
                                <input type="hidden" value="{{ request('committee_id') }}" name="committee_id">
                                <div class="form-group">
                                    <label for="">नाम</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name', $member->name) }}">
                                </div>
                                <div class="form-group">
                                    <label for="">पद</label>
                                    <select name="position_id" id="" class="form-control">
                                        <option value="" selected disabled>पद छान्नुहोस्</option>
                                        @foreach ($positions as $position)
                                            <option value="{{ $position->id }}"
                                                {{ old('position_id', $member->position_id) == $position->id ? 'selected' : '' }}>
                                                {{ $position->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="">समितिको पद</label>
                                    <select name="committee_position_id" id="" class="form-control">
                                        <option value="" selected disabled>पद छान्नुहोस्</option>
                                        @foreach ($committeePositions as $position)
                                            <option value="{{ $position->id }}"
                                                {{ old('committee_position_id', $member->committee_position_id) == $position->id ? 'selected' : '' }}>
                                                {{ $position->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" value="{{ request('committee_id') }}" name="committee_id">

                                <div class="form-group">
                                    <button type="submit"
                                        class="btn btn-info col-12 z-depth-0">{{ $member->id ? 'अपडेट गर्नुहोस्' : 'सेभ गर्नुहोस' }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endcan

            <div class="col-md-8">
                <div class="card z-depth-0 mb-2">
                    <div class="card-body">
                        <form action="{{ route('member.index') }}?committee_id={{ request('committee_id') }}">
                            <div class="d-flex align-items-center">
                                <input type="hidden" value="{{ request('committee_id') }}" name="committee_id">
                                @if (request('name'))
                                    <input type="text" class="form-control mr-1" placeholder="नाम"
                                        value="{{ request('name') }}" name="name">
                                @else
                                    <input type="text" class="form-control mr-1" placeholder="नाम" name="name">
                                @endif

                                @if (request('position_id'))
                                    <select id="" class="form-control mr-1" name="position_id">
                                        <option value="">सबै समिति</option>
                                        @foreach ($positions as $position)
                                            <option value="{{ $position->id }}"
                                                {{ request('position_id') == $position->id ? 'selected' : '' }}
                                                {{ old('position_id', $member->position_id) == $position->id ? 'selected' : '' }}>
                                                {{ $position->name }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <select id="" class="form-control mr-1" name="position_id">
                                        <option value="">सबै समिति</option>
                                        @foreach ($positions as $position)
                                            <option value="{{ $position->id }}"
                                                {{ old('position_id', $member->position_id) == $position->id ? 'selected' : '' }}>
                                                {{ $position->name }}</option>
                                        @endforeach
                                    </select>
                                @endif

                                @if (request('committee_position_id'))
                                    <select name="committee_position_id" id="" class="form-control">
                                        <option value="">सबै समितिको पद </option>
                                        @foreach ($committeePositions as $position)
                                            <option value="{{ $position->id }}" {{request('committee_position_id') == $position->id ? 'selected' : ''}}
                                                {{ old('committee_position_id', $member->committee_position_id) == $position->id ? 'selected' : '' }}>
                                                {{ $position->name }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <select name="committee_position_id" id="" class="form-control">
                                        <option value="">सबै समितिको पद </option>
                                        @foreach ($committeePositions as $position)
                                            <option value="{{ $position->id }}"
                                                {{ old('committee_position_id', $member->committee_position_id) == $position->id ? 'selected' : '' }}>
                                                {{ $position->name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                                <button class="btn btn-info"> <i class="fa fa-filter"></i> फिल्टर</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card z-depth-0">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center py-2">
                        <h5 class="font-weight-bold h3-responsive d-inline-block m-0 p-0">सदस्यहरु</h5>
                        <div class="d-flex align-items-center">
                            @if ($member)
                                @php
                                    $url = route(request()->route()->getName(), $member);
                                @endphp
                            @else
                                @php
                                    $url = route(request()->route()->getName());
                                @endphp
                            @endif
                            <form action="{{ $url }}" method="GET">
                                <select name="perPage" id="" class="form-control" onchange="this.form.submit()">\
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </form>
                            <span class="ml-2">प्रति पृष्ठ</span>
                        </div>
                    </div>
                    <div class="card-body py-0">
                        <table class="table table-striped table-hover" id="items-table">
                            <thead>
                                <tr class="text-center">
                                    <th>क्र.स.</th>
                                    <th>समिति</th>
                                    <th>नाम</th>
                                    <th>पद</th>
                                    <th>समितिको पद</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="sortable">
                                @foreach ($members as $member)
                                    <tr class="text-center" data-id="{{ $member->id }}">
                                        <td class="kalimati-font">{{ $loop->iteration }}</td>
                                        <td>{{ $member->committee->name }}</td>
                                        <td>{{ $member->name }}</td>
                                        <td>{{ $member->position->name }}</td>
                                        <td>{{ $member->committeePosition->name }}</td>
                                        <td class="d-flex m-0 p-0 pt-1">
                                            @canany(['member.edit', 'member.delete'])
                                                <div class="dropdown">
                                                    <button class="btn btn-option" style="box-shadow: none" type="button"
                                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <label for="">...</label>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        @can('member.edit')
                                                            <a class="dropdown-item"
                                                                href="{{ route('member.edit', $member) }}?committee_id={{ request('committee_id') }}">सम्पादन</a>
                                                        @endcan
                                                        @can('member.delete')
                                                            <form action="{{ route('member.delete', $member) }}" method="POST"
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
                            {{ $members->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        var sortable = new Sortable(document.getElementById('sortable'), {
            animation: 150,
            onEnd: function( /**Event*/ evt) {
                console.log('Drag Ended');
                var order = [];
                $('#sortable tr').each(function(index, element) {
                    order.push({
                        id: $(element).attr('data-id'),
                        position: index + 1
                    });
                });

                $.ajax({
                    url: '{{ route('member.order') }}',
                    method: 'POST',
                    data: {
                        order: order,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // console.log(response);
                    }
                });
            }
        });
    </script>
@endpush
