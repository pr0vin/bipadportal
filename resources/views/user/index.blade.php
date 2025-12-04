@extends('layouts.app')

@section('content')
    <div class="my-3">
        @include('alerts.all')
    </div>
    <div class="font-noto">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <h5>Users</h5>
                @can('user.store')
                    <div class="ml-auto">
                        <a class="btn btn-primary btn-sm z-depth-0" href="{{ route('user.create') }}"><span class="mr-2"><i
                                    class="fa fa-plus"></i></span> New user</a>
                    </div>
                @endcan
            </div>

            {{-- <div class="my-1"></div> --}}
            <div class="card my-2 z-depth-0">
                <div class="card-body">
                    <form action="{{ route('user.index') }}" method="GET">
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <input type="text" class="form-control" name="name"
                                    value="{{ request('name' ?? '') }}" placeholder="Name">
                            </div>
                            <div class="col-md-4 mb-2">
                                <input type="text" class="form-control" name="username"
                                    value="{{ request('username') ?? '' }}" placeholder="Username">
                            </div>
                            <div class="col-md-4 mb-2">
                                <input type="text" class="form-control" name="email"
                                    value="{{ request('email') ?? '' }}" placeholder="Email">
                            </div>
                            {{-- <div class="col-md-3">
                                @if (request('role'))
                                    <select name="role" id="" class="form-control">
                                        <option value="">सबै भूमिका</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}"
                                                {{ request('role') == $role->name ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <select name="role" id="" class="form-control">
                                        <option value="">सबै भूमिका</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                            </div> --}}
                            <div class="col-12 d-flex justify-content-end">
                                <button class="btn btn-info" type="submit">फिल्टर</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card z-depth-0" style="overflow: scroll">
                <div class="card-body py-2">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr class="text-uppercase">
                                <th>S.N</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Municipality</th>
                                <th>Ward</th>
                                <th>Role</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                @if ($user->id != 1)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if ($user->municipality_id)
                                                {{ $user->municipality->municipality }} <span
                                                    class="small text-muted"></span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user->ward_id)
                                                {{ $user->ward->name }} <span class="small text-muted">(ID:
                                                    {{ $user->ward_id }})</span>
                                            @else
                                                <span class="small text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @foreach ($user->getRoleNames() as $role)
                                                <span
                                                    class="py-1 px-2 d-inline-block shadow-none text-left rounded text-capitalize"
                                                    style="background-color: #f2f7fb; font-size: 13px; min-width: 110px;">{{ str_replace('-', ' ', $role) }}</span>
                                                @if (!$loop->last)
                                                    |
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="text-nowrap">
                                            @can('user.password')
                                                <a href="{{ route('password.change.form', $user) }}"
                                                    class="action-btn text-primary"><i class="fas fa-key"></i></a>
                                            @endcan
                                            @can('user.edit')
                                                <span class="mx-2">|</span>
                                                <a href="{{ route('user.edit', $user) }}" class="action-btn text-primary"><i
                                                        class="fa fa-edit"></i></a>
                                            @endcan

                                            @can('user.delete')
                                                <span class="mx-2">|</span>
                                                <form action="{{ route('user.destroy', $user) }}" method="post"
                                                    onsubmit="return confirm('के तपाइँ यो रेकर्ड मेटाउन निश्चित हुनुहुन्छ ?')"
                                                    class="form-inline d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="action-btn text-danger"><i
                                                            class="far fa-trash-alt"></i></button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="42" class="text-center">** Users does not exist **</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
