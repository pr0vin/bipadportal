<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @isset($title)
            {{ $title }} |
        @endisset
        {{ settings()->get('app_name', $default = 'बिरामी दर्ता प्रणाली') }}

    </title>

    @include('layouts.partials.styles')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        @page {
            /* size: auto; */
            /* auto is the initial value */
            /* this affects the margin in the printer settings */
            /* margin: 15mm 15mm 15mm 15mm; */
        }

        body {
            background-color: #fff;
            font-size: <?php echo settings('letter_font_size', 24) . 'pt'; ?>;
        }

        h4 {
            font-weight: bold;
        }

        @media print {
            .noprint {
                display: none;
            }

            .table th,
            .table td {
                border: 1px solid #808080 !important;
                -webkit-print-color-adjust: exact;
            }
        }

        /* Resizable */
        .resizable-block.resize-enabled .resizable {
            resize: both;
            overflow: visible;
            border: 1px dashed #e73b55;
        }

        .ui-resizable-e,
        .ui-resizable-w,
        .ui-resizable-n,
        .ui-resizable-s {
            width: 8px;
            height: 8px;
            background-color: yellow;
            border: 1px solid red;
            border-radius: 50%;
        }

        .ui-resizable-n {
            top: -5px;
            left: 50%;
        }

        .ui-resizable-w {
            left: -5px;
            top: 50%;
        }

        .ui-resizable-e {
            right: -5px;
            top: 50%;
        }

        .ui-resizable-s {
            bottom: -5px;
            left: 50%;
        }

        .btn-font-size {
            font-size: 13px !important
        }
    </style>
    @stack('styles')
    {!! settings('letter_head_scripts') !!}
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    @livewireStyles
</head>

<body>
    <div class="container">
        @if (\Request::route()->getName() != 'decision.document' && \Request::route()->getName() != 'print-decision')
            <div id="options-bar" class="card grey lighten-5 border my-4 noprint">
                <div class="card-body d-flex justify-content-between">
                    <a href="{{ url()->previous() }}" class="btn btn-danger btn-md z-depth-0 btn-font-size">Cancel</a>
                    <div class="d-flex">
                        <button class="btn btn-primary btn-md z-depth-0 btn-font-size"
                            onclick="printDocument()">Print</button>
                    </div>
                </div>
            </div>
        @elseif(\Request::route()->getName() == 'decision.document' || \Request::route()->getName() == 'print-decision')
            {{-- <div id="options-bar" class="card grey lighten-5 border my-4 noprint" style="z-index: 1">
                <div class="card-body d-flex justify-content-between">
                    <a href="{{ route('newApplication') }}?diseaseType=2"
                        class="btn btn-danger btn-md z-depth-0 btn-font-size">Cancel</a>
                    <div class="d-flex">
                        <button wire:click="exportData" class="btn btn-info btn-md z-depth-0 btn-font-size">Export word
                            file</button>
                        <button class="btn btn-primary btn-md z-depth-0 btn-font-size"
                            onclick="printDocument()">Print</button>
                    </div>
                </div>
            </div> --}}
        @endif

        @if (\Request::route()->getName() == 'decision.document')
            @yield('content')
        @else
            <div id="document-wrapper" contenteditable="{{ $contentEditable ?? 'true' }}">
                @yield('content')
            </div>
        @endif
    </div>

    @include('layouts.partials.scripts')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        var today = NepaliFunctions.ConvertDateFormat(NepaliFunctions.GetCurrentBsDate('YYYY-MM-DD'), 'YYYY/MM/DD');
        var nepaliDates = document.getElementsByClassName('nepali-date-today');
        // for (let i = 0; i <= nepaliDates.length; i++) {
        //     nepaliDates[i].innerHTML = today;
        // }
        nepaliDates.forEach(function(element) {
            element.innerHTML = today
        })

        function printDocument() {
            var optionsBar = document.getElementById('options-bar');
            var prtContent = document.getElementById("document-wrapper");
            optionsBar.classList.add('d-none');
            window.print();
            optionsBar.classList.remove('d-none');
        }

        function enableResizable() {
            let resizableBlocks = document.getElementsByClassName('resizable-block');
            resizableBlocks.forEach(element => {
                element.classList.add('resize-enabled');
            });
            $(".resize-enabled .resizable").resizable({
                handles: "n, e, s, w",
            });
            document.getElementById('enable-resize-btn').classList.add('d-none');
            document.getElementById('disable-resize-btn').classList.remove('d-none');
        }

        function disableResizable() {
            let resizableBlocks = document.getElementsByClassName('resizable-block');
            resizableBlocks.forEach(element => {
                element.classList.remove('resize-enabled');
            });
            $(".resizable").resizable("destroy");
            document.getElementById('disable-resize-btn').classList.add('d-none');
            document.getElementById('enable-resize-btn').classList.remove('d-none');
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                airMode: true,
                // popover: {
                //     air: [
                //         ['mybutton', ['uppercase']],
                //         ['style', ['bold', 'italic', 'underline']],
                //         ['fontsize', ['fontsize']],
                //         ['para', ['ul', 'ol', 'paragraph']],
                //         ['insert', ['table']]

                //     ]
                // },
            });
        });
    </script>

    @stack('script')
    @livewireScripts
</body>

</html>
