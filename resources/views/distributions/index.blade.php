@extends('layouts.app')

@section('content')
    <div class="container">

        @include('alerts.all')

        <div class="mb-3 text-end">
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
                            <th>कार्य</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($distributions as $key => $d)
                            <tr>
                                <td class="kalimati-font text-center">{{ $distributions->firstItem() + $key }}</td>

                                <td>{{ $d->resource->name }}</td>
                                <td>
                                    <span class="badge p-2 {{ $d->type ? 'bg-success' : 'bg-danger' }}">
                                        {{ $d->type ? 'प्राप्त' : 'वितरण' }}
                                    </span>
                                </td>
                                <td class="kalimati-font">{{ $d->quantity }}</td>
                                <td>
                                    @if ($d->type)
                                        {{ $d->remark ?? '—' }}
                                    @else
                                        {{ $d->patient->name ?? '—' }}
                                        {{ !empty($d->remark) ? ' / ' . $d->remark : '' }}
                                    @endif
                                </td>

                                <td>
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
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">डाटा उपलब्ध छैन</td>
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

<style>
    /* Body rows only */
    .table tbody td {
        padding-top: 6px !important;
        padding-bottom: 6px !important;
        padding-left: 8px;
        padding-right: 8px;
        vertical-align: middle;
    }

    /* Remove extra space under last row */
    .table tbody tr:last-child td {
        border-bottom: 0;
    }

    /* Table itself should not add margin */
    .table {
        margin-bottom: 0 !important;
    }

    /* Remove padding inside table wrapper */
    .table-responsive {
        padding-bottom: 0 !important;
        margin-bottom: 0 !important;
    }

    /* Card should not add extra bottom gap */
    .card {
        padding-bottom: 0;
    }

    /* Pagination spacing controlled */
    .card .d-flex.justify-content-end {
        padding-top: 6px;
        padding-bottom: 6px;
    }
</style>
