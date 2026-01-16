@extends('layouts.app')
@section('content')
<div class="container-fluid">
    @livewire('organization-report',['message'=>$message,   'applicationTypeId' => $applicationTypeId])
</div>
@endsection