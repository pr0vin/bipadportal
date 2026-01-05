{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ settings('app_name') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.0/css/all.min.css"
        integrity="sha512-3PN6gfRNZEX4YFyz+sIyTF6pGlQiryJu9NlGhu9LrLMQ7eDjNgudQoFDK3WSNAayeIKc6B8WXXpo4a7HqxjKwg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            color: #fff;
        }

        .bg {
            background-image: linear-gradient(120deg, #155799, #159957);
            min-height: 100vh;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .mohrain-btn {
            padding: 10px;
            font-size: 20px;
            display: inline-block;
            margin-bottom: 1rem;
            color: rgba(255, 255, 255, 0.7);
            background-color: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.2);
            border-style: solid;
            border-width: 1px;
            border-radius: 0.25rem;
            transition: color 0.2s, background-color 0.2s, border-color 0.2s;
        }

        .mohrain-btn:hover {
            background-color: #155799;
            border-color: #155799;
            color: inherit;
        }

        .glass {

            background-size: cover;
            background-position-y: center;
            position: relative;
            box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;
        }

        .container {
            min-height: calc(100vh - 130px)
        }

        @media screen and (max-width: 991px) {
            .container {
                min-height: calc(100vh - 160px)
            }
        }

        @media screen and (max-width: 767px) {
            .container {
                min-height: calc(100vh - 257px)
            }
        }

        @media screen and (max-width: 575px) {
            .glass {
                min-height: 280px
            }
        }
    </style>
</head>

<body class="bg" style="overflow-x: hidden;margin:0;padding:0;">
    <div class="container py-2">
        <div class="d-flex justify-content-center brand-detail margin-zero" style="margin-top: 15%">
            <div class="logo">
                <a class="mr-2" href="/">
                    <img src="/assets/img/nep-gov-logo-sm.png" alt="Nepal Government" style="height: 100px;">
                </a>
            </div>
        </div>
        <div class="brand mb-4 font-noto-sans">
            <h1 class="text-center text-white mt-2 ">{{ __('app.name') }}</h1>
        </div>
        <div class="d-flex flex-column flex-sm-row text-center justify-content-center action-list mb-1">
            <a href="{{ route('frontent.apply') }}" class="mohrain-btn mr-2" style="text-decoration: none;">बिरामी
                दर्ता</a>
            <a href="{{ route('frontent.tokenSearch') }}" class="mohrain-btn mr-2" style="text-decoration: none;">टोकन
                नम्बर खोजी</a>
            @guest
                <a href="{{ route('login') }}" class="mohrain-btn mr-2" style="text-decoration: none;">कर्मचारी लगइन</a>
            @else
                <a href="{{ route('home') }}" class="mohrain-btn mr-2" style="text-decoration: none;">कर्मचारी लगइन</a>
            @endguest
        </div>

    </div>
    <div class="glass p-0 ,mb-5" style="height:100%">
        @php
            $downloads = App\Download::latest()->get();
        @endphp
        <div class=" row py-3 pl-5">
            <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                @foreach ($downloads as $download)
                    <a target="__blank" href="{{ asset('storage') . '/' . $download->document }}"
                        class="text-white col-lg-3 col-md-6 mb-2">{{ $download->document_name }}</a>
                @endforeach
            </marquee>
        </div>
        <div class="bg-dark d-sm-block font-lato-sans pl-5 py-3">
            <div class="row align-items-center">
                <div class="col-lg-3">
                    <img src="/assets/img/nep-gov-logo-sm.png" alt="Nepal Government" style="height: 50px;">
                    {{ __('app.name') }}
                </div>
                <label class=" col-lg-3 col-sm-6"><i class="fa fa-phone-square mr-2"></i>
                    {{ settings('municipality_phone') ?? ' 091-524243' }} </label>
                <br>
                <label class=" col-lg-3 col-sm-6"><i class="fas fa-envelope-square mr-2"></i>
                    {{ settings('municipality_email') ?? ' info@mohrain.com ' }} </label>
                <br>
                <label class=" col-lg-3 col-sm-12"><i class="fas fa-globe mr-2"></i>
                    {{ settings('municipality_website') ?? ' mohrain.com ' }} </label>
            </div>
        </div>
    </div>
</body>

</html> --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ settings('app_name') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.0/css/all.min.css"
        integrity="sha512-3PN6gfRNZEX4YFyz+sIyTF6pGlQiryJu9NlGhu9LrLMQ7eDjNgudQoFDK3WSNAayeIKc6B8WXXpo4a7HqxjKwg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400..800&family=Noto+Serif+Devanagari:wght@100..900&family=Tiro+Devanagari+Marathi:ital@0;1&display=swap"
        rel="stylesheet">
    <style>
        /* body {
            color: #fff;
        } */
        .font-bool {
            font-family: "Tiro Devanagari Marathi", serif;
            font-weight: 400;
            font-style: normal;
        }

        .font-dev {
            font-family: "Noto Serif Devanagari", serif;
            font-optical-sizing: auto;
            font-weight: 400;
            font-style: normal;
            font-variation-settings:
                "wdth" 100;
        }

        .red {
            color: #BE020A;
        }



        .blue {
            color: #155799
        }

        .green {
            color: #28621A;
        }

        .bg-download-title {
            /* color: #BE020A; */
            color: white;
            background-color: #155799;
            font-weight: 700;
        }

        .bg {
            /* background-image: linear-gradient(120deg, #155799, #159957); */
            background-color: #e2e5f5c9;
            /* min-height: 100vh; */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .mohrain-btn {
            padding: 10px 50px;
            /* font-size: 20px; */
            display: inline-block;
            margin-bottom: 1rem;
            /* color: rgba(255, 255, 255, 0.7); */
            /* background-color: rgba(255, 255, 255, 0.08); */
            /* background-color: #1F60BA; */
            background-color: #0bb945;
            color: #fff;
            border-color: rgba(255, 255, 255, 0.2);
            border-style: solid;
            border-width: 1px;
            border-radius: 0.25rem;
            transition: color 0.2s, background-color 0.2s, border-color 0.2s;
        }

        .mohrain-btn:hover {
            /* background-color: #155799;
            border-color: #155799;
            color: inherit; */

            /* background-color: #1F60BA; */
            color: #fff;
        }

        .bg1 {
            /* background: rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(50px);
            -webkit-backdrop-filter: blur(50px);
            border: 1px solid rgba(255, 255, 255, 0.3); */
        }

        .hide-data {
            display: block !important;
        }

        .my-shadow {
            box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;
        }

        .link {
            color: #4a4a4e
        }

        .link:hover {
            /* color: #BE020A; */
            color: #155799;
        }



        @media screen and (max-width: 767px) {
            .org-info {
                position: relative;
                left: 100px;
            }

            .hide-on-mobile {
                display: none;
            }
        }



        .img img {
            height: 40px;
            border-radius: 50%;
        }

        .img {
            margin-left: -10px;
        }

        .scroll {
            -ms-overflow-style: none;
            /* Internet Explorer 10+ */
            scrollbar-width: none;
            /* Firefox */
            list-style: none;
        }

        .scroll::-webkit-scrollbar {
            display: none;
            /* Safari and Chrome */
        }

        .card-body {
            position: relative;
        }

        /* .card-title::after{
            content: '';
            position: absolute;
            height: 15px;
            width: 15px;
            background-color: #343A40;
            border-radius: 50%;
            top: 10px;
            left: 50%;
        } */
        .form-control:focus {
            border: 1px solid #ccc;
            outline: none;
            border-color: #28a745;
            /* Custom border color */
            box-shadow: 0 0 0 1px #ccc;
        }

        .form-control:focus {
            outline: none !important;
            border: none !important;
        }

        .info:hover {
            color: #155799 !important;
        }
    </style>
</head>

<body class="bg font-bool" style="overflow-x: hidden;margin:0;padding:0; min-height:60vh">
    <div class=" ">
        <nav class="container  py-2  d-flex  justify-content-between align-items-center border-bottom border-white">
            <a class=" d-flex  align-items-center" href="/">
                <img src="/assets/img/nep-gov-logo-sm.png" alt="Nepal Government" style="height: 70px;">
                <div class="d-block ml-2">
                    <h3 class="font-weight-bold red">{{ __('app.name') }}</h3>
                    <h5 class="red">Government of Nepal</h5>
                </div>
            </a>

            <div>

                <figure class="hide-on-mobile" style="width: 5rem; height:5rem">
                    <img class="" style="width: 5rem; height:5rem"
                        src="https://assembly.sudurpashchim.gov.np/images/nepalflag.gif" alt="nepal">
                </figure>


                {{-- @guest
                    <a href="{{ route('login') }}"
                        class="d-flex d-inline-flex rounded text-white bg-primary  align-items-center p-2 ms-2 border "
                        style="text-decoration: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d=" M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0
                                                    1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0
                                                    0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z" />
                            <path fill-rule="evenodd"
                                d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                        </svg>
                        <span class="px-2">
                            लगइन</span></a>
                @endguest --}}

            </div>
        </nav>
    </div>
    <div class="container mt-3">
        <div class="row">
            <div class="col-12 d-flex justify-content-end align-items-center">
                <a href="{{ route('frontent.faqs') }}" style="color: #8e8b8b" class="mr-3 info">FAQ</a>
                <a href="{{settings()->get('user_manual') ? asset('storage').'/'.settings()->get('user_manual') : ''}}" target="__blank" title="Help" style="color: #aca9a9"><svg class="w-6 h-6 text-gray-800 dark:text-white info"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11h2v5m-2 0h4m-2.592-8.5h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </a>
            </div>
        </div>
        <div class="row mt-3" style="min-height: 65vh">
            <div class="col-lg-6 mb-5 ">
                {{-- <h1 class="mb-3 font-weight-bold blue text-center">{{ __('app.name') }}</h1> --}}
                <label class="mb-3  font-dev" style="text-align: justify; ">यस प्रणालीमा
                    मृगाैला
                    प्रत्यारोपण
                    गरेका, डायलाइसिस
                    गरिरहेका, क्यान्सर रोगी र
                    मेरूदण्ड पक्षाघात भई दिर्घरोगी भएका व्यक्तिहरूको मासिक औषधि उपचार खर्च व्यवस्थापनका साथसाथै
                    विपन्न नागरिक हरूलाइ मन्त्रालयले ताेकेका विभिन्न अस्पतालबाट पाउने औषधी उपचार खर्चको सिफारिस,
                    सामाजिक विकास मन्त्रालयबाट गरिने स्वास्थ्य उपचार आर्थिक सुविधाका सिफारिस लगायत पालिकाबाट पाउने
                    उपचार खर्च व्यवस्थापन गर्न सकिन्छ ।</label>
                <div class="w-full mb-5">

                    <div class="col-10 mx-auto">



                        <form class="my-3" action="{{ route('token.search') }}" method="GET">
                            <div class="input-group ">
                                <!-- Input field for token number -->
                                <input type="text" name="tokenNumber" class="form-control" placeholder="टोकन नम्बर"
                                    aria-label="Token Number" aria-describedby="basic-addon2" required>

                                <div class="input-group-append">
                                    <!-- Search button to submit the form -->
                                    <button class="input-group-text px-3" id="basic-addon2" type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                            <path
                                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                        </svg>
                                    </button>
                                </div>


                            </div>
                            @if (session('error'))
                                <div class="text-danger fw-bold px-2 pt-1">
                                    {{ session('error') }}
                                </div>
                            @endif


                        </form>

                        <div class="py-3 d-flex justify-content-center  w-full ">
                            <a href="{{ route('frontent.apply') }}" class="mohrain-btn mr-2   "
                                style="text-decoration: none;">नयाँ दर्ता</a>




                            {{-- <a href="{{ route('frontent.tokenSearch') }}" class="mohrain-btn mr-2"
                    style="text-decoration: none;">टोकन
                    नम्बर खोजी</a> --}}
                            {{-- @guest
                    <a href="{{ route('login') }}" class="mohrain-btn mr-2" style="text-decoration: none;">कर्मचारी
                        लगइन</a>
                @else
                    <a href="{{ route('home') }}" class="mohrain-btn mr-2" style="text-decoration: none;">कर्मचारी
                        लगइन</a>
                @endguest --}}
                        </div>

                        <div class="text-center font-weight-bold text-danger ">
                            OR
                        </div>

                        <div class="py-3 d-flex justify-content-center text-secondary  w-full ">


                            <span>
                                के तपाईं कर्मचारी हुनुहुन्छ ? <strong> <a
                                        style="text-decoration: underline; font-size:18px;" href="{{ route('login') }}">
                                        Login</a></strong></span>
                        </div>
                    </div>
                </div>

                {{-- <div class="trustedBy d-flex pl-2 align-items-center">
                    <div class="img"><img
                            src="https://framerusercontent.com/images/2Y7D9JS4krqAwKQy2bnTL8Hqfg.png"
                            alt=""></div>
                    <div class="img"><img
                            src="https://framerusercontent.com/images/uNyXIhuGNBdSRHCDQcDtk8Wtjk.png"
                            alt=""></div>
                    <div class="img"><img
                            src="https://framerusercontent.com/images/DqlCOuEt50xoB9OtRSkK9tDWTjQ.png"
                            alt=""></div>
                    <div class="img"><img
                            src="https://framerusercontent.com/images/Mp7qaShG98j2qmmBNdftQVFjYag.png"
                            alt=""></div>
                    <h5 class="font-weight-bold ml-3">{{ englishToNepaliLetters(App\Patient::count()) }}+ सिफारिस
                    </h5>
                </div> --}}
            </div>

            <div class="col-lg-6   d-flex justify-content-end ">
                <div class="card col-12 bg1 p-0 m-0 mb-5 bg-light " style="height: 60vh;">
                    <div class="card-body p-0 m-0   ">
                        <h5 class="bg-download-title text-center p-2 mb-3 card-title ">सम्बन्धित कागजातहरु </h5>
                        @php
                            $downloads = App\Download::latest()->get();
                        @endphp

                        <ul class="px-3 scroll" style="height: 58vh;overflow-y:auto">
                            @foreach ($downloads as $download)
                                <li class=" mb-3 border-bottom border-light d-flex">
                                    <div>

                                        <i class="text-danger"> <svg xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" fill="currentColor"
                                                class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8" />
                                            </svg></i>
                                    </div>
                                    <div>

                                        <a href="{{ asset('storage') . '/' . $download->document }}"
                                            class="text-decoration-underline  link"
                                            target="__blank">{{ $download->document_name }}</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                    {{-- <div class="">
                        <a href="#" class="p-1  " style="font-size: 12px ; ">read more</a>
                    </div> --}}
                </div>
                {{-- <img src="{{asset('img.png')}}" style="width:90%" alt=""> --}}
            </div>

        </div>


    </div>
    @include('frontend.partials.footer')


</body>

</html>
