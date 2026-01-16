@extends('layouts.app')

@section('content')
    <div class="container">

        @include('alerts.all')

        <div class="d-flex justify-content-between mb-3 mt-4">
            <form method="GET">
                <select name="type" class="form-select" onchange="this.form.submit()">
                    <option value="0" {{ request('type', '0') == '0' ? 'selected' : '' }}>
                        वितरण
                    </option>
                    <option value="1" {{ request('type') == '1' ? 'selected' : '' }}>
                        प्राप्त
                    </option>
                    <option value="" {{ request('type') === null ? 'selected' : '' }}>
                        सबै
                    </option>
                </select>
            </form>

            <a href="{{ route('distributions.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> नयाँ वितरण
            </a>
        </div>

        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover table-borderless">
                    <thead class="bg-deep-blue text-white">
                        <tr>
                            <th class="text-center">क्र.स.</th>
                            <th>सामाग्री</th>
                            <th>प्रकार</th>
                            <th>परिमाण</th>
                            <th>कैफियत</th>
                            <th class="text-center">कार्य</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($distributions as $key => $d)
                            @foreach ($d->details as $detail)
                                <tr>
                                    <td class="text-center kalimati-font">
                                        {{ $distributions->firstItem() + $key }}
                                    </td>

                                    <td>{{ $detail->resource->name ?? '—' }}</td>

                                    <td>
                                        <span class="badge p-1 {{ $d->type ? 'bg-success' : 'bg-danger' }}">
                                            {{ $d->type ? 'प्राप्त' : 'वितरण' }}
                                        </span>
                                    </td>

                                    <td class="kalimati-font">
                                        {{ $detail->quantity }}
                                        {{ $detail->resource->unit->name ?? '' }}
                                    </td>

                                    <td>
                                        @if ($d->type == 0)
                                            {{ $d->patient->name ?? '—' }}
                                            {{ $d->remark ? ' / ' . $d->remark : '' }}
                                        @else
                                            {{ $d->organization_name ?? '—' }}
                                            {{ $d->remark ? ' / ' . $d->remark : '' }}
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('distributions.edit', $d) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('distributions.destroy', $d) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" onclick="return confirm('Delete?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    डाटा उपलब्ध छैन
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end p-2">
                {{ $distributions->links() }}
            </div>
        </div>
    </div>
@endsection
