@extends('layouts.app')

@section('content')
    <div class="container">
        @include('alerts.all')
    </div>
    <div class="container">
        <div class="row mb-4">
            <div class="col text-end">
                <a href="{{ route('resources.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> नयाँ सामाग्री
                </a>
            </div>
        </div>
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" style="min-width: 900px;">
                        <thead class="bg-deep-blue text-white">
                            <tr>
                                <th class="text-center" width="60">क्र.स.</th>
                                <th>नाम</th>
                                <th>ईकाई</th>
                                <th class="text-center">परिमाण</th>
                                <th>विवरण</th>
                                <th class="text-center" width="120">कार्यहरू</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($resources as $resource)
                                <tr>
                                    <td class="text-center kalimati-font">{{ $loop->iteration }}</td>
                                    <td>{{ $resource->name }}</td>
                                    <td>{{ $resource->unit->name ?? 'N/A' }}</td>
                                    <td class="text-center kalimati-font">{{ $resource->quantity }}</td>
                                    <td>
                                        @if ($resource->description)
                                            {{ Str::limit($resource->description, 50) }}
                                        @else
                                            <span class="text-muted">विवरण छैन</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-1 align-items-center">
                                            <div>
                                                <a href="{{ route('resources.show', $resource->id) }}" class="btn btn-info btn-sm"
                                                    title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                            </div>
                                            <div>
                                                <a class="btn btn-warning btn-sm"
                                                    href="{{ route('resources.edit', $resource->id) }}"
                                                    title="सम्पादन गर्नुहोस्">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                            <div>
                                                <form action="{{ route('resources.destroy', $resource) }}" method="POST"
                                                    class="d-inline m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('के तपाईं यो स्रोत मेटाउन निश्चित हुनुहुन्छ?')"
                                                        title="मेटाउनुहोस्">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">कुनै पनि सामाग्री फेला परेन।</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($resources->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        {{ $resources->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
