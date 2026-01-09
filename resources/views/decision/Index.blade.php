@extends('layouts.app')

@section('content')
    <div class="container">

        @include('alerts.all')

        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover table-borderless">
                    <thead class="bg-deep-blue text-white">
                        <tr>
                            <th class="text-center">क्र.स</th>
                            <th>निर्णय शीर्षक</th>
                            <th>कुल रकम</th>
                            <th>निर्णय मिति</th>
                            <th>फाइल अपलोड</th>
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

                                <td class="py-1">
                                    <label for="upload_file_{{ $loop->index }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-upload"></i>
                                    </label>

                                    <input type="file" name="upload_file[]" id="upload_file_{{ $loop->index }}"
                                        class="d-none">
                                </td>

                                <td class="py-1">
                                    <a href="{{ route('distributions.distribution.form', $decision->id) }}"
                                        class="btn btn-info btn-xs">
                                        भुक्तानी गर्नुहोस 
                                    </a>
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
