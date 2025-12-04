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
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}

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


        .bg {
            background-color: #e2e5f5c9;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .mohrain-btn {
            padding: 10px 50px;
            display: inline-block;
            margin-bottom: 1rem;
            background-color: #0bb945;
            color: #fff;
            border-color: rgba(255, 255, 255, 0.2);
            border-style: solid;
            border-width: 1px;
            border-radius: 0.25rem;
            transition: color 0.2s, background-color 0.2s, border-color 0.2s;
        }

        .accordion {
            width: 100%;
        }

        .accordion-item {
            width: 100%;
        }

        .accordion-header {
            width: 100%;
        }

        .accordion-button {
            width: 100%;
            background-color: #155799;
            color: #fff;
            text-align: left;
            padding: 12px;
            font-size: 16px;
            border: none;
            transition: 1s;
        }

        .accordion-header .accordion-button.collapsed {
            color: #000;
            width: 100%;
            background-color: #f9f9f9;
            text-align: left;
            padding: 12px;
            font-size: 16px;
            border: none;
        }

        .accordion-collapse {
            position: relative;
            top: -10px;
        }

        .accordion-body {
            padding: 15px 10px 5px 10px;
            background-color: #fff;
            text-align: justify;
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
            </div>

        </nav>

    </div>
    <div class="container mt-3">
        <div class="row mt-3" style="min-height: 60vh">
            <div class="col-lg-12 mb-5 ">
                <h5 class="text-center"><u>प्राय: सोधिने प्रश्नहरु</u></h5>
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseOne" aria-expanded="false"
                                aria-controls="flush-collapseOne">
                                परिभाषा (नागरिक स्वास्थ्य उपचार व्यवस्थापन प्रणाली के हो ?)
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse" aria-labelledby="flush-headingOne"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                यस प्रणालीमा मृगाैला प्रत्यारोपण गरेका, डायलाइसिस गरिरहेका, क्यान्सर रोगी र मेरूदण्ड
                                पक्षाघात भई दिर्घरोगी भएका व्यक्तिहरूको मासिक औषधि उपचार खर्च व्यवस्थापनका साथसाथै
                                विपन्न नागरिक हरूलाइ मन्त्रालयले ताेकेका विभिन्न अस्पतालबाट पाउने औषधी उपचार खर्चको
                                सिफारिस, सामाजिक विकास मन्त्रालयबाट गरिने स्वास्थ्य उपचार आर्थिक सुविधाका सिफारिस लगायत
                                पालिकाबाट पाउने उपचार खर्च व्यवस्थापन गर्न सकिन्छ ।
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                aria-controls="flush-collapseTwo">
                                कसरी दर्ता गर्ने
                            </button>
                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse"
                            aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <p>कृपया दर्ता गर्न निम्न चरणहरू प्रवाह गर्नुहोस्</p>
                                <ul>
                                    <li>आफ्नो मनपर्ने ब्राउजरमा https://patientportal.mohrain.xyz/ खोल्नुहोस्</li>
                                    <li>नयाँ बिरामी दर्तामा क्लिक गर्नुहोस र तपाईको विवरणहरू भर्नुहोस्</li>
                                    <li>अन्तिममा पेश गर्नुहोसमा क्लिक गर्नुहोस्।</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseThree" aria-expanded="false"
                                aria-controls="flush-collapseThree">
                                Accordion Item #3
                            </button>
                        </h2>
                        <div id="flush-collapseThree" class="accordion-collapse collapse"
                            aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">Placeholder content for this accordion, which is intended to
                                demonstrate the <code>.accordion-flush</code> class. This is the third item's accordion
                                body. Nothing more exciting happening here in terms of content, but just filling up the
                                space to make it look, at least at first glance, a bit more representative of how this
                                would look in a real-world application.</div>
                        </div>
                    </div> --}}
                </div>
                {{-- <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                          Accordion Item #1
                        </button>
                      </h2>
                      <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                        <div class="accordion-body">
                          <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                      </div>
                    </div>
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                          Accordion Item #2
                        </button>
                      </h2>
                      <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                        <div class="accordion-body">
                          <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                      </div>
                    </div>
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                          Accordion Item #3
                        </button>
                      </h2>
                      <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                        <div class="accordion-body">
                          <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                      </div>
                    </div>
                  </div> --}}
            </div>

        </div>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    @include('frontend.partials.footer')


</body>

</html>
