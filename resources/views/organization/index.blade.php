@extends('layouts.app')

@section('content')
    <div class="container">
        @include('alerts.all')
    </div>

    <div class="container-fluid">
        <x-organizations-table :isRegistered="$isRegistered" :deasiseTypes="$deasiseTypes" :isrecommended="$isrecommended"
            :organizations="$patients"></x-organizations-table>
        <div class="card mt-3 m-0 p-0 mb-3">
            @if ($patients->hasPages())
                <div class="pagination d-flex row px-5 justify-content-between  justify-content-center  p-2 font-nep text-secondary align-items-center"
                    style="font-size: 14px;">
                    <div class="m-0 p-0">
                        <span class="kalimati-font">{{ $patients->total() }}</span> रेकर्डहरू मध्ये <span
                            class="kalimati-font">{{ $patients->firstItem() }}</span> देखि <span
                            class="kalimati-font">{{ $patients->lastItem() }}</span> देखाउँदै
                    </div>
                    <span class="kalimati-font">
                        {{ $patients->appends(request()->input())->links() }}
                    </span>
                </div>
            @endif
        </div>

    </div>
@endsection