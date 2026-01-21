@extends('layouts.app')

@section('content')
    <div class="container">

        @include('alerts.all')

        <div class="d-flex justify-content-between mb-3 mt-4">
            <form method="GET">
                <select name="type" class="form-select" onchange="this.form.submit()">
                    <option value="">सबै</option>

                    <option value="distribute" {{ request('type') === 'distribute' ? 'selected' : '' }}>
                        वितरण
                    </option>

                    <option value="receive" {{ request('type') === 'receive' ? 'selected' : '' }}>
                        प्राप्त
                    </option>

                    <option value="return" {{ request('type') === 'return' ? 'selected' : '' }}>
                        फिर्ता
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
                            <th>मिति</th>
                            <th>प्रकार</th>
                            <th>कैफियत</th>
                            <th class="text-center">कार्य</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($distributions as $key => $d)
                            <tr>
                                <td class="text-center kalimati-font">{{ $distributions->firstItem() + $key }}</td>
                                <td class="kalimati-font">{{ $d->distributed_date->format('Y-m-d') }}</td>
                                <td>
                                    @if ($d->type === 'distribute')
                                        <span class="badge p-1 bg-danger">
                                            वितरण
                                        </span>
                                    @elseif ($d->type === 'receive')
                                        <span class="badge p-1 bg-success">
                                            प्राप्त
                                        </span>
                                    @elseif ($d->type === 'return')
                                        <span class="badge p-1 bg-warning text-dark">
                                            फिर्ता
                                        </span>
                                    @else
                                        <span class="badge p-1 bg-secondary">
                                            अज्ञात
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if ($d->type === 'distribute')
                                        @if ($d->patient)
                                            {{ $d->patient->name }}
                                        @endif

                                        @if ($d->organization_name)
                                            {{ $d->patient ? ' / ' : '' }}
                                            {{ $d->organization_name }}
                                        @endif
                                    @elseif ($d->type === 'receive')
                                        {{ $d->organization_name ?? '—' }}
                                    @elseif ($d->type === 'return')
                                        {{ $d->patient->name ?? ($d->organization_name ?? '—') }}
                                    @endif

                                </td>

                                <td class="text-center">
                                    {{-- <button type="button" class="btn btn-info btn-sm mr-1" data-bs-toggle="modal"
                                        data-bs-target="#modal-{{ $d->id }}" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button> --}}

                                    <a href="{{ route('distributions.show', $d) }}" class="btn btn-info btn-sm"
                                        title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- <a href="{{ route('distributions.edit', $d) }}" class="btn btn-warning btn-sm"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a> --}}

                                    <form action="{{ route('distributions.destroy', $d) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete?')"
                                            title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">डाटा उपलब्ध छैन</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end p-2">
                {{ $distributions->links() }}
            </div>
        </div>

        {{-- @foreach ($distributions as $d)
            <div class="modal fade" id="modal-{{ $d->id }}" tabindex="-1"
                aria-labelledby="modalLabel-{{ $d->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel-{{ $d->id }}">
                                {{ $d->type == 'distribute' ? 'वितरण' : 'प्राप्त' }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="kalimati-font text-secondary mb-2">
                                मिति: {{ $d->distributed_date->format('Y-m-d') }}
                            </div>
                            <div class="text-secondary">
                                @if ($d->type === 'distribute')
                                    पिडितको नाम: {{ $d->patient->name ?? '—' }}
                                @elseif ($d->type === 'receive')
                                    संस्थाको नाम: {{ $d->organization_name ?? '—' }}
                                @elseif ($d->type === 'return')
                                    संस्थाको नाम अथवा पिडितको नाम:
                                    {{ $d->organization_name ?? '—' }}
                                    {{ $d->patient->name ?? '—' }}
                                @else
                                    —
                                @endif
                            </div>

                            <table class="table table-sm table-bordered mt-3">
                                <thead class="table-light">
                                    <tr>
                                        <th>सामाग्री</th>
                                        <th>परिमाण</th>
                                        <th>इकाई</th>


                                        @if (in_array($d->type, ['distribute', 'return']))
                                            <th>स्थिति</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($d->details as $detail)
                                        <tr>
                                            <td>{{ $detail->resource->name ?? '—' }}</td>
                                            <td>{{ $detail->quantity }}</td>
                                            <td>{{ $detail->resource->unit->name ?? '' }}</td>


                                            @if (in_array($d->type, ['distribute', 'return']))
                                                <td>
                                                    @if ($detail->returnable === 1)
                                                        <span class="badge p-1 bg-warning text-dark">
                                                            फिर्ता पाउने
                                                        </span>
                                                    @elseif ($detail->is_returned === 1)
                                                        <span class="badge p-1 bg-success">
                                                            फिर्ता भैसकेको
                                                        </span>
                                                    @elseif ($detail->returnable === 0)
                                                        <span class="badge p-1 bg-primary">
                                                            वितरण भैसकेको
                                                        </span>
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>


                            @if ($d->remark)
                                <div class="kalimati-font text-secondary mt-2">
                                    कैफियत: {{ $d->remark }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach --}}

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
