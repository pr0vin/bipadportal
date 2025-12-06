<nav id="sidebar" class="notPrintable">
    @php
        $applicationTypes = App\ApplicationType::latest()->get();
        $runningFiscalYear = App\FiscalYear::where('is_running', 1)->first();
    @endphp

    <a href="{{ route('home') }}" class="cursor-pointer sidebar-header  d-flex justify-content-center ">
        <div>
            <figure class="d-flex justify-content-center">
                <img class="img-reponsive" src="{{ asset(config('constants.nep_gov.logo_sm')) }}"
                    alt="Nepal Government Logo" height="50px">
            </figure>
            <div class=" cursor-pointer  font-nep text-center  " style="font-size: 20px; margin-left:10px;">
                {{ __('app.name') }}
            </div>
        </div>
    </a>
    <ul class="list-unstyled components font-nep">
        <li id="sidebarCollapse " class="{{ setActive('home') }} mb-1">
            <a class="nav-link text-dark" href="{{ route('home') }}">
                <span class=" pr-3 "><i><svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.143 4H4.857A.857.857 0 0 0 4 4.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 10 9.143V4.857A.857.857 0 0 0 9.143 4Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 20 9.143V4.857A.857.857 0 0 0 19.143 4Zm-10 10H4.857a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286A.857.857 0 0 0 9.143 14Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286a.857.857 0 0 0-.857-.857Z" />
                        </svg>
                    </i></span>@lang('navigation.dashboard')
            </a>
        </li>
        <li id="sidebarCollapse " class="{{ setActive('online-application.index') }} mb-1">
            <a class="nav-link text-dark" href="{{ route('online-application.index') }}">
                <span class=" pr-3"><i><svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9V4a1 1 0 0 0-1-1H8.914a1 1 0 0 0-.707.293L4.293 7.207A1 1 0 0 0 4 7.914V20a1 1 0 0 0 1 1h4M9 3v4a1 1 0 0 1-1 1H4m11 6v4m-2-2h4m3 0a5 5 0 1 1-10 0 5 5 0 0 1 10 0Z" />
                        </svg>
                    </i> </span>नयाँ आबेदन
            </a>
        </li>
        {{-- @canany(['dirgha.application', 'bipanna.application', 'samajik.application', 'nagarpalika.application']) --}}
            <li class="{{ setActive('newApplication') }} mt-1" id="sidebarCollapse">

                <a href="#newAppSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle text-dark"> <span
                        class=" pr-3"><i><svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-3 5h3m-6 0h.01M12 16h3m-6 0h.01M10 3v4h4V3h-4Z" />
                            </svg>

                        </i> </span>@lang('navigation.online_forms')</a>
                <ul class="collapse list-unstyled {{ setShow('newApplication') }}" id="newAppSubmenu">
                    {{-- @can('dirgha.application') --}}
                        <li>
                            <a class="nav-link text-dark"
                                href="{{ route('newApplication') }}?diseaseType=1&fiscal_year={{ $runningFiscalYear->id }}&ward={{ session()->get('ward_number') }}">आगलागी पिडित</a>
                        </li>
                    {{-- @endcan --}}
                    {{-- @can('bipanna.application') --}}
                        <li>
                            <a class="nav-link text-dark"
                                href="{{ route('newApplication') }}?diseaseType=2&fiscal_year={{ $runningFiscalYear->id }}&ward={{ session()->get('ward_number') }}">वाढी डुबान पिडित</a>
                        </li>
                    {{-- @endcan --}}
                    {{-- @can('samajik.application') --}}
                        <li>
                            <a class="nav-link text-dark"
                                href="{{ route('newApplication') }}?diseaseType=3&fiscal_year={{ $runningFiscalYear->id }}&ward={{ session()->get('ward_number') }}">चत्याङ पिडित</a>
                        </li>
                    {{-- @endcan
                    @can('nagarpalika.application') --}}
                        <li>
                            <a class="nav-link text-dark"
                                href="{{ route('newApplication') }}?diseaseType=4&fiscal_year={{ $runningFiscalYear->id }}&ward={{ session()->get('ward_number') }}">भुईचालो पिडित</a>
                        </li>
                    {{-- @endcan --}}

                    {{-- @can('nagarpalika.application') --}}
                        <li>
                            <a class="nav-link text-dark"
                                href="{{ route('newApplication') }}?diseaseType=5&fiscal_year={{ $runningFiscalYear->id }}&ward={{ session()->get('ward_number') }}">सितलहर पिडित</a>
                        </li>
                    {{-- @endcan --}}

                     <li>
                            <a class="nav-link text-dark"
                                href="{{ route('newApplication') }}?diseaseType=6&fiscal_year={{ $runningFiscalYear->id }}&ward={{ session()->get('ward_number') }}">हावाहुरी पिडित</a>
                        </li>

                         <li>
                            <a class="nav-link text-dark"
                                href="{{ route('newApplication') }}?diseaseType=7&fiscal_year={{ $runningFiscalYear->id }}&ward={{ session()->get('ward_number') }}">दुर्घटना पिडित</a>
                        </li>

                         <li>
                            <a class="nav-link text-dark"
                                href="{{ route('newApplication') }}?diseaseType=8&fiscal_year={{ $runningFiscalYear->id }}&ward={{ session()->get('ward_number') }}">धानबाली दुवेको पिडित</a>
                        </li>

                </ul>
            </li>
        {{-- @endcanany --}}
        {{-- @canany(['dirgha.registered', 'bipanna.registered', 'samajik.registered', 'nagarpalika.registered']) --}}
            <li class="{{ setActive('regLocation') }} mt-1" id="sidebarCollapse">
                <a href="#registeredSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle text-dark"><span
                        class=" pr-3"><i><svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 3v4a1 1 0 0 1-1 1H5m4 6 2 2 4-4m4-8v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1Z" />
                            </svg>


                        </i> </span>दर्ता/सिफारिस भएका</a>
                <ul class="collapse list-unstyled {{ setShow('regLocation') }}" id="registeredSubmenu">

                    {{-- @can('dirgha.registered') --}}
                        {{-- <li class="sidebarCollapse">
                            <a href="#dirghaMenu" data-toggle="collapse" aria-expanded="false" class=""><span
                                    class=""></span>दीर्घरोगी
                                मासिक उपचार खर्च</a>

                            <ul class="collapse list-unstyled" id="dirghaMenu">
                                <li>
                                    <a class="nav-link pl-5" href="{{ route('payment.procedure') }}">विवरण</a>
                                </li>
                                <li>
                                    <a class="nav-link pl-5" href="{{ route('payment.procedure') }}">भुक्तानी सिफारिस</a>
                                </li>
                            </ul>
                        </li> --}}
                        {{-- <li class="sidebarCollapse">
                            <a class="nav-link text-dark"
                                href="{{ route('regLocation') }}?diseaseType=1&fiscal_year={{ $runningFiscalYear->id }}&ward={{ session()->get('ward_number') }}">दीर्घरोगी
                                मासिक उपचार खर्च</a>
                        </li> --}}
                            <li class="sidebarCollapse">
                            <a class="nav-link text-dark"
                                href="{{ route('regLocation') }}?diseaseType=1&fiscal_year={{ $runningFiscalYear->id }}&ward={{ session()->get('ward_number') }}">आगलागी पिडित</a>
                        </li>
                        {{-- <li>
                            <a class="nav-link" href="{{ route('payment.procedure') }}"><i class="fa fa-caret-right pr-2"></i>भुक्तानी सिफारिस</a>
                        </li> --}}
                    {{-- @endcan --}}
                    {{-- <li>
                        <a class="nav-link" href="{{ route('payment.procedure') }}">भुक्तानी सिफारिस</a>
                    </li> --}}
                    {{-- @can('bipanna.registered') --}}
                        <li>
                            <a class="nav-link text-dark"
                                href="{{ route('regLocation') }}?diseaseType=2&fiscal_year={{ $runningFiscalYear->id }}&ward={{ session()->get('ward_number') }}">वाढी डुबान पिडित</a>
                        </li>
                    {{-- @endcan --}}
                    {{-- @can('samajik.registered') --}}
                        <li>
                            <a class="nav-link text-dark"
                                href="{{ route('regLocation') }}?diseaseType=3&fiscal_year={{ $runningFiscalYear->id }}&ward={{ session()->get('ward_number') }}">चत्याङ पिडित</a>
                        </li>
                    {{-- @endcan --}}
                    {{-- @can('nagarpalika.registered') --}}
                        <li>
                            <a class="nav-link text-dark"
                                href="{{ route('regLocation') }}?diseaseType=4&fiscal_year={{ $runningFiscalYear->id }}&ward={{ session()->get('ward_number') }}">भुईचालो पिडित</a>
                        </li>
                    {{-- @endcan --}}

                     <li>
                            <a class="nav-link text-dark"
                                href="{{ route('regLocation') }}?diseaseType=5&fiscal_year={{ $runningFiscalYear->id }}&ward={{ session()->get('ward_number') }}">सितलहर पिडित</a>
                        </li>

                         <li>
                            <a class="nav-link text-dark"
                                href="{{ route('regLocation') }}?diseaseType=6&fiscal_year={{ $runningFiscalYear->id }}&ward={{ session()->get('ward_number') }}">हावाहुरी पिडित</a>
                        </li>

                         <li>
                            <a class="nav-link text-dark"
                                href="{{ route('regLocation') }}?diseaseType=7&fiscal_year={{ $runningFiscalYear->id }}&ward={{ session()->get('ward_number') }}">दुर्घटना पिडित</a>
                        </li>

                        <li>
                            <a class="nav-link text-dark"
                                href="{{ route('regLocation') }}?diseaseType=8&fiscal_year={{ $runningFiscalYear->id }}&ward={{ session()->get('ward_number') }}">धानबाली दुवेको पिडित</a>
                        </li>
                </ul>
            </li>
        {{-- @endcanany --}}

        {{-- @canany(['dirgha.report', 'bipanna.report', 'samajik.report', 'nagarpalika.report', 'closed.report',
            'renewed.report', 'notRenewed.report']) --}}

            <li class=" mt-1" id="sidebarCollapse">
                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle text-dark">
                    <span class=" pr-3"><i><svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 4.5V19a1 1 0 0 0 1 1h15M7 14l4-4 4 4 5-5m0 0h-3.207M20 9v3.207" />
                            </svg>
                        </i> </span>@lang('navigation.report')</a>
                <ul class="collapse list-unstyled" id="homeSubmenu">
                    {{-- @can('dirgha.report') --}}
                        <li>
                            <a class="nav-link text-dark"
                                href="{{ route('organization.report.dirghaReport') }}?diseaseType=1&ward={{ session()->get('ward_number') }}">प्रकोपको सङख्या र क्षतिको विवरण</a>
                        </li>
                    {{-- @endcan --}}
                    @can('bipanna.report')
                        <li>
                            <a class="nav-link text-dark" href="{{ route('organization.bipanna-final-report') }}">बिपन्न
                                सहयोगको सिफारिस</a>
                        </li>
                    @endcan
                    @can('samajik.report')
                        <li>
                            <a class="nav-link text-dark"
                                href="{{ route('social-development.report') }}?ward_number={{ session()->get('ward_number') }}">सामाजिक
                                विकास मन्त्रालय</a>
                        </li>
                    @endcan
                    @can('nagarpalika.report')
                        <li>
                            <a class="nav-link text-dark"
                                href="{{ route('municipalityReport') }}?ward_number={{ session()->get('ward_number') }}">पालिकाको
                                स्वास्थ्य राहत कोष</a>
                        </li>
                    @endcan
                    @can('closed.report')
                        <li>
                            <a class="nav-link text-dark"
                                href="{{ route('closedPatient') }}?fiscal_year={{ $runningFiscalYear->id }}&ward={{ session()->get('ward_number') }}">लागतकट्टा
                                भएका</a>
                        </li>
                    @endcan
                    @can('renewed.report')
                        <li>
                            <a class="nav-link text-dark"
                                href="{{ route('renewedPatient') }}?fiscal_year={{ $runningFiscalYear->id }}&ward={{ session()->get('ward_number') }}">नाविकरण
                                भएका</a>
                        </li>
                    @endcan
                    @can('notRenewed.report')
                        <li>
                            <a class="nav-link text-dark"
                                href="{{ route('dateExpiredPatient') }}?fiscal_year={{ $runningFiscalYear->id }}&ward={{ session()->get('ward_number') }}">नाविकरण
                                नभएका</a>
                        </li>
                    @endcan
                </ul>
            </li>
        {{-- @endcanany --}}
        @canany(['user.store', 'user.edit', 'user.delete', 'user.password'])
            <li id="sidebarCollapse " class="{{ setActive('user.index') }} mb-1">
                <a class="nav-link text-dark" href="{{ route('user.index') }}">
                    <span class=" pr-3"><i><svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                    d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>




                        </i> </span>@lang('navigation.users')
                </a>
            </li>
        @endcanany
        @canany(['application.setting', 'downloadDocument.setting', 'colsedReason.setting', 'position.setting',
            'committeePosition.setting'])
            <li id="sidebarCollapse " class="{{ setActive('settings.system') }} mb-1">
                <a class="nav-link text-dark" href="{{ route('settings.system') }}">
                    <span class=" pr-3"><i class="fas fa-cogs"></i></span>@lang('navigation.settings')
                </a>
            </li>
        @endcanany
        @canany(['newPalika.store', 'newPalika.edit', 'newPalika.delete'])
            <li id="sidebarCollapse " class="{{ setActive('organization.index') }} mb-1">
                <a class="nav-link text-dark" href="{{ route('organization.index') }}">
                    <span class=" pr-3"><i class="fas fa-cog"></i></span>पालिका दर्ता
                </a>
            </li>
        @endcanany
        @canany(['role.store', 'role.edit', 'role.delete', 'role.permission', 'fiscalYear.store', 'fiscalYear.edit',
            'fiscalYear.delete', 'disease.store', 'disease.edit', 'disease.delete', 'hospital.store', 'hospital.edit',
            'hospital.delete', 'committee.store', 'committee.edit', 'committee.delete', 'member.store', 'member.edit',
            'member.delete', 'ward.store', 'ward.edit', 'ward.delete'])
            <li class=" mt-1 {{ setActive('fiscal-year.index') }} {{ setActive('province.index') }} {{ setActive('district.index') }} {{ setActive('municipality.index') }} {{ setActive('disease.index') }}"
                id="sidebarCollapse">

                <a href="#configSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                        class="fas fa-tools  mr-3"></i></span>@lang('navigation.configurations')</a>
                <ul class="collapse list-unstyled" id="configSubmenu">
                    @canany(['fiscalYear.store', 'fiscalYear.edit', 'fiscalYear.delete'])
                        <li>

                            <a class="nav-link text-dark" href="{{ route('fiscal-year.index') }}">@lang('navigation.fiscal_year')</a>
                        </li>
                    @endcanany
                    @canany(['disease.store', 'disease.edit', 'disease.delete'])
                        <li>
                            <a class="nav-link text-dark" href="{{ route('disease.index') }}">राेग</a>
                        </li>
                    @endcanany
                    @canany(['hospital.store', 'hospital.edit', 'hospital.delete'])
                        <li>
                            <a class="nav-link text-dark" href="{{ route('hospital.index') }}">अस्पताल</a>
                        </li>
                    @endcanany
                    @canany(['committee.store', 'committee.edit', 'committee.delete', 'member.store', 'member.edit',
                        'member.delete'])
                        <li>
                            <a class="nav-link text-dark" href="{{ route('committee.index') }}">समिति</a>
                        </li>
                    @endcanany
                    @canany(['role.store', 'role.edit', 'role.delete', 'role.permission'])
                        <li>
                            <a class="nav-link text-dark" href="{{ route('role.index') }}">प्रयोगकर्ता भूमिका</a>
                        </li>
                    @endcanany
                    @role('super-admin')
                        <li>
                            <a class="nav-link text-dark" href="{{ route('relation.index') }}">बिरामीसंगको नाता</a>
                        </li>
                        {{-- @endrole --}}
                        {{-- <li>
                        <a class="nav-link" href="{{ route('member.index') }}">सदस्य</a>
                    </li> --}}

                        <li>
                            {{-- @role('super-admin') --}}
                            <a class="nav-link text-dark" href="{{ route('admin.logs') }}" target="_blank">
                                @lang('System Logs')
                            </a>

                        </li>
                    @endrole
                </ul>
            </li>
        @endcanany
        {{-- @endhasanyrole --}}

    </ul>
</nav>


<style>
    /*
    DEMO STYLE
*/

    /* @import "https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"; */
    /* color: #fff; */
    @import url('https://fonts.googleapis.com/css2?family=Baloo+2:wght@400..800&family=Noto+Serif+Devanagari:wght@100..900&family=Tiro+Devanagari+Marathi:ital@0;1&display=swap');

    body {
        /* font-family: 'Poppins', sans-serif; */
        font-family: "Tiro Devanagari Marathi", system-ui;
        font-weight: bold;
        background: #fafafa;
    }

    .font-nep {
        font-family: "Tiro Devanagari Marathi", system-ui;
        font-weight: bold;
        font-style: normal;
    }

    p {
        font-family: 'Poppins', sans-serif;
        font-size: 1.1em;
        font-weight: 300;
        line-height: 1.7em;
        color: #999;
    }

    .text-red {
        color: #be020bb4;

    }

    a,
    a:hover,
    a:focus {
        color: inherit;
        text-decoration: none;
        transition: all 0.3s;
    }

    .navbar {
        padding: 15px 10px;
        background: #fff;
        border: none;
        border-radius: 0;
        margin-bottom: 40px;
        box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
    }

    .navbar-btn {
        box-shadow: none;
        outline: none !important;
        border: none;
    }

    .line {
        width: 100%;
        height: 1px;
        border-bottom: 1px dashed #ddd;
        margin: 40px 0;
    }

    /* ---------------------------------------------------
    SIDEBAR STYLE
----------------------------------------------------- */

    .wrapper {
        display: flex;
        width: 100%;
        align-items: stretch;
    }

    #sidebar {
        min-width: 250px;
        max-width: 250px;
        /* background: #1C4267; */
        background: white;
        color: #363638dc;
        transition: all 0.3s;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;

    }

    #sidebar.active {
        margin-left: -250px;
    }

    #sidebar .sidebar-header {
        padding: 20px 10px;
        color: #fff;
        background: #041e48
    }

    #sidebar ul.components {
        padding: 20px 5px 20px 5px;
        border-bottom: 1px solid #47748b;
    }

    #sidebar ul p {
        color: #fff;
        padding: 10px;
    }

    #sidebar ul li a {
        padding: 10px;
        font-size: 1.2em;
        /* display: block; */
        display: flex !important;
        align-items: center;
        font-family: "Tiro Devanagari Marathi", system-ui;



    }

    #sidebar ul li a:hover {
        /* color: #be020bb4; */
        /* background: #7386D5; */
        background: #e2e2e2;
        /* background: #073378; */
    }

    #sidebar ul li i {
        /* color: green; */
        color: #be020bc9;


    }



    #sidebar ul li.active>a,
    a[aria-expanded="true"] {
        /* color: #fff; */
        /* background: #041e48; */
        color: #041e48;
        border-left: 5px solid #be020b;
        background: #c5c8e4d2;

    }


    #sidebar ul li.active>a i,
    a i[aria-expanded="true"] {
        /* color: #fff;
        background: #041e48; */
        color: #041e48;

    }





    a[data-toggle="collapse"] {
        position: relative;
    }

    .dropdown-toggle::after {
        display: block;
        position: absolute;
        top: 50%;
        right: 20px;
        transform: translateY(-50%);
    }

    ul ul a {
        font-size: 1.1em !important;
        padding-left: 30px !important;
        /* background: #041e48; */
        background: #dde3ee91;
    }

    ul.CTAs {
        padding: 20px;
    }

    ul.CTAs a {
        text-align: center;
        font-size: 0.9em !important;
        display: block;
        border-radius: 5px;
        margin-bottom: 5px;
        font-size: 1.2em;

    }

    a.download {
        background: #fff;
        color: #7386D5;
    }

    a.article,
    a.article:hover {
        background: #6d7fcc !important;
        color: #fff !important;
    }

    /* ---------------------------------------------------
    CONTENT STYLE
----------------------------------------------------- */

    #content {
        width: 100%;
        padding: 20px;
        min-height: 100vh;
        transition: all 0.3s;
    }

    /* ---------------------------------------------------
    MEDIAQUERIES
----------------------------------------------------- */

    @media (max-width: 768px) {
        #sidebar {
            margin-left: -250px;
        }

        #sidebar.active {
            margin-left: 0;
        }

        #sidebarCollapse span {
            display: none;
        }
    }

    .cursor-pointer {
        cursor: pointer;
    }
</style>
