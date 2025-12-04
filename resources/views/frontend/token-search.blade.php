@extends('layouts.frontend')

@section('content')
    <div class="my-4"></div>
    <div class="container">
        <div class="card z-depth-0">
            <div class="card-body">
                <livewire:token-search-form :token-number="$tokenNumber">
            </div>
        </div>
    </div>
@endsection
