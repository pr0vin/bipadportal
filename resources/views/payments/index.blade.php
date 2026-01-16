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
                            <th>भुक्तानी मिति</th>
                            <th>कुल रकम</th>
                            <th>शीर्षक</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($payments as $key => $payment)
                            <tr>
                                <td class="kalimati-font text-center">{{ $payments->firstItem() + $key }}</td>
                                <td class="kalimati-font">{{ optional($payment->paid_date)->format('Y-m-d') }}</td>

                                <td class="kalimati-font">{{ number_format($payment->total, 2) }}</td>
                                <td>{{ $payment->title ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">भुक्तानी डेटा उपलब्ध छैन</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end p-2">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
@endsection
