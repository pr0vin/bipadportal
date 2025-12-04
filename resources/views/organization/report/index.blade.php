@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- @include('organization.report.dirghaReport.menu') --}}

    @livewire('organization-report',['message'=>$message, 'applicationTypeCounts' => $applicationTypeCounts])
</div>
@endsection