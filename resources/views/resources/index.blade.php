@extends('layouts.app')

@section('content')
<div class="container">
        @include('alerts.all')
    </div>
    <div class="container">
        <div class="row mb-4">

            <div class="col text-end">
                <a href="{{ route('resources.create') }}" class="btn btn-primary ">
                    <i class="fas fa-plus"></i> नयाँ सामाग्री
                </a>
            </div>
        </div>

        <div class="card">
            <div>
                <div class="table-responsive">
                    <table class="table table-hover table-borderless"
                        style=" border-collapse: separate; border-spacing: 0 0;min-width:900px;position: relative;">
                        <thead class="bg-deep-blue text-white font-15px" style=" z-index: 10;">
                            <tr>
                                <th>क्र.स.</th>
                                <th>नाम</th>
                                <th>ईकाई</th>
                                <th>परिमाण</th>
                                <th>विवरण</th>
                                <th>कार्यहरू</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($resources as $resource)
                                <tr>
                                    <td class="kalimati-font">{{ $loop->iteration }}</td>
                                    <td>{{ $resource->name }}</td>
                                    <td>{{ $resource->unit->name ?? 'N/A' }}</td>
                                    <td class="kalimati-font">{{ $resource->quantity }}</td>
                                    <td>
                                        @if ($resource->description)
                                            {{ Str::limit($resource->description, 50) }}
                                        @else
                                            <span class="text-muted">विवरण छैन</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a class="btn btn-warning btn-sm font-noto z-depth-0" style="margin-top: 5px"
                                                href="{{ route('resources.edit', $resource->id) }}"><i
                                                    class="fas fa-edit"></i></a>

                                            <form action="{{ route('resources.destroy', $resource) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm font-noto z-depth-0"
                                                    onclick="return confirm('Are you sure you want to delete this resource?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No resources found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end">
                            {{ $resources->links() }}
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection
