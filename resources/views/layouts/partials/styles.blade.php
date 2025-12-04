<link rel="icon" href="{{ asset(config('constants.nep_gov.logo_sm')) }}">

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
<link href="{{ asset('assets/mdb/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/mdb/css/mdb.min.css') }}" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400..800&family=Noto+Serif+Devanagari:wght@100..900&family=Tiro+Devanagari+Marathi:ital@0;1&display=swap"
    rel="stylesheet">
<style>
    @font-face {
        font-family: Kalimati;
        src: url("{{ asset('assets/fonts/Kalimati.ttf') }}") format('truetype');

    }

    .kalimati-font {
        font-family: 'Kalimati' !important;
    }

    #project {
        background-color: #12213A;
    }

    .andp-datepicker-container.open {
        z-index: 999999999999999999;
    }

    #custom-confirm {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .modal-content {
        background: white;
        padding: 20px;
        border-radius: 5px;
        width: 300px;
        /* text-align: center; */
    }

    .modal-content button {
        /* margin: 10px;
    padding: 10px 20px; */
        width: 100px;
    }
</style>
<link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/utilities.css') }}">
<link href="{{ asset('assets/mdb/css/addons/datatables.min.css') }}" rel="stylesheet">

{{-- <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet"> --}}
@guest
    <link rel="stylesheet" href="{{ asset('assets/css/guest.css') }}">
@endguest
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@livewireStyles
<link rel="stylesheet" href="{{ asset('nepali-date-picker.min.css') }}">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    * {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    *::-webkit-scrollbar {
        display: none;
    }

    .dashboard-card-title {
        font-size: 14px;
    }

    .font-14,
    label {
        font-size: 14px !important;
    }

    #sidebar ul li {
        font-size: 14px !important;
    }

    h5 {
        font-size: 15px !important;
    }

    select,
    input,
    button,
    .btn {
        font-size: 14px !important;
    }

    table tr th {
        font-size: 14px !important;
        /* text-align: center !important; */
    }

    table tr td {
        font-size: 13px !important;
        /* text-align: center !important; */
    }

    .btn-option {
        background-color: #3f7de85f;
        color: #fff;
        padding: 0 10px !important;
        cursor: pointer;
    }

    .btn-option label {
        cursor: pointer;
    }

    .main-container {
        min-height: calc(100vh - 140px)
    }

    .table thead th {
        font-weight: bold !important;
    }

    #content-area {
        transition: .3s !important;
    }

    @import url('https://fonts.googleapis.com/css2?family=Noto+Serif+Devanagari:wght@100..900&display=swap');

    *,
    body {
        font-family: 'kalimati-font'
    }

    .custom-dropdown {
        font-family: 'kalimati-font'
    }

    .custom-container .select2-selection {
        font-family: 'Kalimati', Arial, sans-serif;
    }

    /* Style the dropdown options */
    .custom-dropdown .select2-results__option {
        font-family: 'Kalimati', Arial, sans-serif;
    }

    #js-example-basic-single {
        height: 100px;
        padding: 10px !important;
    }

    .select2-container .select2-selection--single {
        font-family: 'Kalimati', Arial, sans-serif !important;
        height: 35px;
        display: flex;
        padding: 10px !important;
        align-items: center;
        /* Vertically center the text */
    }

    .select2-selection__arrow b {
        position: absolute !important;
        top: 10px !important
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        font-family: 'Kalimati', Arial, sans-serif !important;
        /* Ensure font is applied */
        font-size: 14px !important
    }

    /* Set height for the dropdown options */
    .select2-results__option {
        height: 40px;
        /* Adjust the height of each option */
    }

    .dataTables_paginate a {
        padding: 6px 9px !important;
        background: #54c5e6 !important;
        border-color: #2196F3 !important;
    }

    #sidebar {
        overflow-y: scroll !important;
        scrollbar-width: none;
        /* Firefox */
        -ms-overflow-style: none;
        /* Internet Explorer 10+ */
    }

    #sidebar::-webkit-scrollbar {
        /* WebKit */
        width: 0;
        height: 0;
    }

    .permission_table td {
        border: 1px solid #ccc;
        padding: 10px;
    }

    .reportButton {
        background-color: #dfdfdf;
    }
    .printable{
        display: none !important;
    }
    </style>

<style>
    @media print {
        .printable{
            display: block !important;
        }
        .table_print {
            border: 1px solid #ccc;
            border-collapse: collapse;
        }

        .table_print tr,
        .table_print th {
            border: 1px solid #ccc;
        }

        .notPrintable {
            display: none !important;
        }
        .cardPrints{
            margin: 0 !important;
            padding: 0 !important;
            border: none !important;
        }

        .sidebar-opened #content-area {
            margin: 0 !important
        }

        .printableCard {
            box-shadow: none !important;
            border: none !important;
        }
        .card-border-0{
            border: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
        }

    }
    .text-decoration-line-through{
        text-decoration: line-through;
    }
    @media only screen and (max-width: 775px){
        .pagination{
            justify-content: center !important;
        }
    }
    </style>

{{-- <link href="https://fonts.googleapis.com/css2?family=kalimati-font&display=swap" rel="stylesheet"> --}}
