@extends('layouts.letter')

@section('content')
<x-format.token-letter :patient="$patient" :onlineApplication="$onlineApplication"></x-format.token-letter>
@endsection
