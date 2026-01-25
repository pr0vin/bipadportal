@extends('layouts.app')

@section('content')
    <div class="container">

        @include('alerts.all')

        <h5 class="fw-bold text-secondary mb-4 pt-1 dashboard-title kalimati-font">
            निर्णय तालिका
        </h5>

        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover table-borderless">
                    <thead class="bg-deep-blue text-white">
                        <tr>
                            <th class="text-center">क्र.स</th>
                            <th>निर्णय शीर्षक</th>
                            <th>कुल रकम</th>
                            <th>निर्णय मिति</th>
                            {{-- @foreach ($decisions as $key => $decision)
                                @if ($decision->status === 'paid') --}}
                            {{-- <th>स्थिति</th> --}}
                            {{-- @endif
                            @endforeach --}}
                            <th class="text-center">फाइल अपलोड</th>
                            <th>कार्य</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($decisions as $key => $decision)
                            <tr>
                                <td class="kalimati-font text-center">
                                    {{ $decisions->firstItem() + $key }}
                                </td>

                                <td>{{ $decision->title }}</td>

                                <td class="kalimati-font">
                                    {{ number_format($decision->total, 2) }}
                                </td>

                                <td class="kalimati-font">
                                    {{ optional($decision->decision_date)->format('Y-m-d') }}
                                </td>

                                {{-- @if ($decision->status === 'paid')
                                    <td class="kalimati-font text-center text-success fw-bold">
                                        भुक्तानी भएको
                                    </td>
                                @else
                                    <td class="kalimati-font text-center text-danger fw-bold">
                                        भुक्तानी नभएको
                                    </td>
                                @endif --}}



                                {{-- <td class="py-1 text-center ">
                                    @if ($decision->decision_file)
                                        <a href="{{ asset('storage/' . $decision->decision_file) }}" target="_blank"
                                            class="btn btn-success btn-sm">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    @else
                                        <label for="upload_file_{{ $decision->id }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-upload"></i> Upload
                                        </label>

                                        <input type="file" data-id="{{ $decision->id }}"
                                            id="upload_file_{{ $decision->id }}" class="d-none upload-file-input">
                                    @endif
                                </td> --}}

                                <td class="py-1 text-center">
                                    @if ($decision->decision_file)
                                        <a href="{{ asset('storage/' . $decision->decision_file) }}" target="_blank"
                                            class="btn btn-success btn-sm mb-1">
                                            <i class="fas fa-eye"></i> View
                                        </a>

                                        <label for="upload_file_{{ $decision->id }}"
                                            class="btn btn-outline-warning btn-sm ms-1 px-3">
                                            <i class="fas fa-edit"></i>
                                        </label>

                                        <input type="file" id="upload_file_{{ $decision->id }}"
                                            data-id="{{ $decision->id }}" class="d-none upload-file-input">
                                    @else
                                        <label for="upload_file_{{ $decision->id }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-upload"></i> Upload
                                        </label>

                                        <input type="file" id="upload_file_{{ $decision->id }}"
                                            data-id="{{ $decision->id }}" class="d-none upload-file-input">
                                    @endif
                                </td>



                                <td class="py-1">
                                    @if ($decision->status !== 'paid')
                                        <a href="{{ route('distributions.distribution.form', $decision->id) }}"
                                            class="btn btn-info btn-xs">
                                            भुक्तानी गर्नुहोस
                                        </a>
                                    @else
                                        <span class="text-success kalimati-font fw-bold">
                                            भुक्तानी भइसकेको
                                        </span>
                                    @endif
                                </td>

                            </tr>
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
                {{ $decisions->links() }}
            </div>
        </div>
    </div>
@endsection

{{-- @push('scripts')
    <script>
        document.querySelectorAll('.upload-file-input').forEach(input => {
            input.addEventListener('change', function() {
                let decisionId = this.dataset.id;
                let file = this.files[0];

                if (!file) return;

                let formData = new FormData();
                formData.append('file', file);
                formData.append('_token', '{{ csrf_token() }}');

                fetch(`/decisions/${decisionId}/upload-file`, {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status) {
                            this.closest('td').innerHTML = `
                    <a href="${data.file_url}" target="_blank"
                        class="btn btn-success btn-sm">
                        <i class="fas fa-eye"></i> View
                    </a>
                `;
                        } else {
                            alert('Upload failed');
                        }
                    })
                    .catch(() => alert('Something went wrong'));
            });
        });
    </script>
@endpush --}}

@push('scripts')
    <script>
        function bindUploadInputs() {
            document.querySelectorAll('.upload-file-input').forEach(input => {
                input.onchange = function() {
                    let decisionId = this.dataset.id;
                    let file = this.files[0];
                    if (!file) return;

                    let formData = new FormData();
                    formData.append('file', file);
                    formData.append('_token', '{{ csrf_token() }}');

                    fetch(`/decisions/${decisionId}/upload-file`, {
                            method: 'POST',
                            body: formData
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status) {
                                alert(data.message);
                                this.closest('td').innerHTML = `
                            <a href="${data.file_url}"
                               target="_blank"
                               class="btn btn-success btn-sm mb-1">
                                <i class="fas fa-eye"></i> View
                            </a>

                            <label class="btn btn-outline-warning btn-sm ms-1 px-3">
                                <i class="fas fa-edit"></i>
                                <input type="file"
                                       data-id="${decisionId}"
                                       class="d-none upload-file-input">
                            </label>
                        `;
                                bindUploadInputs(); // rebind for new input
                            } else {
                                alert('Upload failed');
                            }
                        })
                        .catch(() => alert('Something went wrong'));
                };
            });
        }

        document.addEventListener('DOMContentLoaded', bindUploadInputs);
    </script>
@endpush
