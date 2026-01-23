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


        <li id="sidebarCollapse " class="{{ setActive('newApplication') }} mb-1">
            <a class="nav-link text-dark"
                href="{{ route('newApplication') }}?fiscal_year={{ $runningFiscalYear->id }}&ward={{ session()->get('ward_number') }}">
                <span class=" pr-3">
                    <i>
                        <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-3 5h3m-6 0h.01M12 16h3m-6 0h.01M10 3v4h4V3h-4Z" />
                        </svg>
                    </i>
                </span>@lang('navigation.online_forms')
            </a>
        </li>

        <li id="sidebarCollapse " class="{{ setActive('regLocation') }} mb-1">
            <a class="nav-link text-dark"
                href="{{ route('regLocation') }}?fiscal_year={{ $runningFiscalYear->id }}&ward={{ session()->get('ward_number') }}">
                <span class=" pr-3">
                    <i><svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 3v4a1 1 0 0 1-1 1H5m4 6 2 2 4-4m4-8v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1Z" />
                        </svg>
                    </i>
                </span>दर्ता भएका
            </a>
        </li>


        <li id="sidebarCollapse " class="{{ setActive('decision.index') }} mb-1">
            <a class="nav-link text-dark" href="{{ route('decision.index') }}">
                <span class=" pr-3">
                    <i><svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5m-1.414-9.414a2 2 0 1 1 2.828 2.828L11.828 15H9v-2.828l8.586-8.586Z" />
                        </svg>
                    </i>
                </span> निर्णय
            </a>
        </li>

        <li id="sidebarCollapse " class="{{ setActive('payments.index') }} mb-1">
            <a class="nav-link text-dark" href="{{ route('payments.index') }}">
                <span class=" pr-3">
                    <i> <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none"
                            viewBox="0 0 24 24">
                            <!-- Money/Payment icon -->
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2Z" />
                        </svg>
                    </i>
                </span> भुक्तानी
            </a>
        </li>

        {{-- <li id="sidebarCollapse " class="{{ setActive('distributions.index') }} mb-1">
            <a class="nav-link text-dark" href="{{ route('distributions.index') }}">
                <span class=" pr-3">
                    <i>
                        <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 6v13m0-13V4a1 1 0 0 1 1-1h3.9a1 1 0 0 1 .7.3l2.6 2.6a1 1 0 0 1 .3.7V10a1 1 0 0 1-1 1H12m0-5H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-3" />
                        </svg>
                    </i>
                </span>राहत सामाग्री वितरण
            </a>
        </li> --}}

        <li class="mt-1">
            <a href="#resourceSubmenu" data-toggle="collapse" aria-expanded="false"
                class="dropdown-toggle text-dark">
                <span class="pr-3">
                    <i>
                        <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 6v13m0-13V4a1 1 0 0 1 1-1h3.9a1 1 0 0 1 .7.3l2.6 2.6a1 1 0 0 1 .3.7V10a1 1 0 0 1-1 1H12m0-5H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-3" />
                        </svg>
                    </i>
                </span>
                राहत सामाग्री वितरण
            </a>

            <ul class="collapse list-unstyled" id="resourceSubmenu">
                <li>
                    <a class="nav-link text-dark" href="{{ route('distributions.index') }}">
                        सामाग्री वितरण
                    </a>
                </li>

                <li>
                    <a class="nav-link text-dark" href="{{ route('resources.index') }}">
                        सामग्री
                    </a>
                </li>
            </ul>
        </li>




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

                <li>
                    <a class="nav-link text-dark"
                        href="{{ route('organization.report.dirghaReport') }}?diseaseType=1&ward={{ session()->get('ward_number') }}">प्रकोपको
                        सङख्या र क्षतिको विवरण</a>
                </li>
                <li>
                    <a class="nav-link text-dark" href="{{ route('organization.relief-report') }}">
                        वितरण गरिएका राहतको विवरण
                    </a>
                </li>

                <li>
                    <a class="nav-link text-dark" href="{{ route('organization.resource-distribution-report') }}">
                        राहत उद्धार सामग्रीहरुको विवरण
                    </a>
                </li>

            </ul>
        </li>

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
                    {{-- @canany(['disease.store', 'disease.edit', 'disease.delete'])
                        <li>
                            <a class="nav-link text-dark" href="{{ route('disease.index') }}">प्रकोप सूची</a>
                        </li>
                    @endcanany --}}

                    <li>
                        <a class="nav-link text-dark" href="{{ route('application-types.index') }}">घटना सूची</a>
                    </li>

                    <li>
                        <a class="nav-link text-dark" href="{{ route('resources.index') }}">सामाग्री</a>
                    </li>

                    <li>
                        <a class="nav-link text-dark" href="{{ route('units.index') }}">ईकाई</a>
                    </li>

                    @canany(['disease.store', 'disease.edit', 'disease.delete'])
                        <li>
                            <a class="nav-link text-dark" href="{{ route('diseases.index') }}">प्रभाव सूची</a>
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
                        <li>
                            <a class="nav-link text-dark" href="{{ route('admin.logs') }}" target="_blank">
                                @lang('System Logs')
                            </a>

                        </li>
                    @endrole
                </ul>
            </li>
        @endcanany


    </ul>
</nav>


<style>
    /* @import "https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"; */
    /* color: #fff; */
    @import url('https://fonts.googleapis.com/css2?family=Baloo+2:wght@400..800&family=Noto+Serif+Devanagari:wght@100..900&family=Tiro+Devanagari+Marathi:ital@0;1&display=swap');

    body {
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
