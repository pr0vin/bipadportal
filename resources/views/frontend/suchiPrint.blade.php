
@extends('layouts.letter')

@section('content')
    @push('styles')
        <style>
            .doc-border {
                padding: 2px;
                border: 7px solid;
                border-image: url('<?php echo asset('assets/img/border-image-kite.png'); ?>') 33 / 7px / 0px repeat;
                border: 7px solid;
                border-image: url('<?php echo asset('assets/img/border-image-kite.png'); ?>') 33 / 7px / 0px repeat;
            }

            .doc-border-line {
                border: 5px solid;
                border-image: url(https://yari-demos.prod.mdn.mozit.cloud/en-US/docs/Web/CSS/CSS_Background_and_Borders/Border-image_generator/border-image-5.png) 12 / 5px / 0px repeat;
            }

            .doc-border>div {
                content: '';
                border: 2px solid #000;
            }

            .border {
                border: 2px solid #1f1d1d !important;
            }

            table {
                width: 100%;
            }

            table th,
            table td {
                font-size: 1.5em !important;
                border: 2px solid #000 !important;
                padding: 5px 10px;
            }

            .underline {
                border-bottom: 2px dashed #000;
                padding: 0 10px;
            }

            .underline1 {
                border-bottom: 1px dashed #000;
                padding: 0 10px;
            }

            .resizable-block {
                font-size: 20px !important;
            }

            .para-size {
                font-size: 16px !important;
            }

            .heading {
                font-size: 20px !important;
                font-weight: bold !important;
            }

            @media print {
                .underline1 {
                    border: none;
                    padding: 0 10px;
                }
            }
        </style>
    @endpush


    {{-- {{-- @if ($patient->disease->application_types[0]->id == '1') --}}
        @include('frontend.tokens.dirgha');
    {{-- @elseif ($patient->disease->application_types[0]->id == '2')
        @include('frontend.tokens.bipanna');
    @else 
        @include('frontend.tokens.samajik');
    @endif --}}
@endsection
