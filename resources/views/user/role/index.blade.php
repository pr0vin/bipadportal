@extends('layouts.app')

@section('content')
    <div class="container">
        @include('alerts.all')
    </div>
    <div class="container-fluid main-container" style="overflow: hidden">
        <div class="row">
            @canany(['role.store'])
                <div class="col-md-4">
                    <div class="card z-depth-0">
                        <div class="card-body">
                            <form action="{{ $role->id ? route('role.update', $role->id) : route('role.store') }}" method="POST"
                                class="form">
                                @csrf
                                @isset($role->id)
                                    @method('put')
                                @endisset
                                <div class="form-group">
                                    <label for="">भूमिका</label>
                                    <input type="text" name="role" class="form-control"
                                        value="{{ old('role', $role->name) }}" required>
                                </div>


                                <div class="form-group">
                                    <button type="submit" class="btn btn-info col-12 z-depth-0">
                                        {{ $role->id ? 'अपडेट गर्नुहोस्' : 'सेभ गर्नुहोस' }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endcanany

            <div class="col-md-8">
                <div class="card z-depth-0">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center py-2">
                        <h5 class="font-weight-bold h3-responsive d-inline-block m-0 p-0">प्रयोगकर्ता भूमिकाहरु</h5>
                    </div>
                    <div class="card-body py-0">
                        <table class="table table-striped table-hover" id="items-table">
                            <thead>
                                <tr class="text-center">
                                    <th>क्र.स.</th>
                                    <th>भूमिका</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="sortable">
                                @foreach ($roles as $role)
                                    <tr class="text-center">
                                        <td class="kalimati-font">{{ $loop->iteration }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td class="d-flex m-0 p-0 pt-1">
                                            @canany(['role.edit', 'role.delete', 'role.permission'])
                                                <div class="dropdown">
                                                    <button class="btn btn-option" style="box-shadow: none" type="button"
                                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <label for="">...</label>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        @can('role.permission')
                                                            <a class="dropdown-item"
                                                                href="{{ route('role.permission', $role) }}">Permission</a>
                                                        @endcan
                                                        @can('role.edit')
                                                            <a class="dropdown-item"
                                                                href="{{ route('role.edit', $role) }}">सम्पादन</a>
                                                        @endcan
                                                        @can('role.delete')
                                                            <form action="{{ route('role.delete', $role) }}" method="POST"
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
                                {{-- @foreach ($members as $member)
                                    <tr data-id="{{ $member->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $member->committee->name }}</td>
                                        <td>{{ $member->name }}</td>
                                        <td>{{ $member->position->name }}</td>
                                        <td>{{ $member->committeePosition->name }}</td>
                                        <td class="d-flex m-0 p-0 pt-1">
                                            <div class="dropdown">
                                                <button class="btn btn-option" style="box-shadow: none" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <label for="">...</label>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item"
                                                        href="{{ route('member.edit', $member) }}">सम्पादन</a>
                                                    <form action="{{ route('member.delete', $member) }}"
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
                                @endforeach --}}
                            </tbody>
                        </table>

                        {{-- <div class="d-flex justify-content-end">
                            {{ $members->links() }}
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
