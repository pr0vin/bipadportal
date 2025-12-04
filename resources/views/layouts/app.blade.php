<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @isset($title)
            {{ $title }} |
        @endisset
        {{ settings()->get('app_name', $default = 'बिरामी दर्ता प्रणाली') }}

        {{-- {{ settings()->get("app_name", $default = "बिरामी दर्ता प्रणाली") }} --}}
        {{-- {{ config('app.name') }} --}}
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    @include('layouts.partials.styles')


    @stack('styles')

    <script src="{{ asset('OneSignalSDKWorker.js') }}"></script>
</head>

<body>
    @guest
        @yield('content')
    @endguest
    @auth
        <div class="{{ Auth::user()->roles[0]->name == 'doctor' ? '' : 'sidebar-opened' }}">

            <div id="sidebar" class="my-sidebar notPrintable bg-deep-blue" data-collapsed="false">
                <x-sidebar></x-sidebar>
            </div>
            <div id="content-area" class="flex-grow-1">
                <x-navbar></x-navbar>
                <div class="" style="overflow-x: hidden">
                    @yield('content')
                </div>
            </div>
        </div>
    @endauth

    @include('layouts.partials.scripts')


</body>
<script>
    const sidebar1 = document.querySelector(".sidebar1");
    const blockDom = document.querySelector(".sidebar1 .block-dom");
    const closeSideBar1 = document.querySelector(".sidebar1 .sidebar1-content .close-sidebar1")
    const showSideBar1 = document.querySelector(".show-sidebar1");

    if (showSideBar1) {
        showSideBar1.addEventListener("click", () =>
            sidebar1.classList.add("show"))
    }

    if (closeSideBar1) {
        closeSideBar1.addEventListener("click", () => sidebar1.classList.remove("show"))
    }

    if (blockDom) {
        blockDom.addEventListener("click", () => sidebar1.classList.remove("show"))
    }
</script>

<script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.7.2/axios.min.js"></script>
<script>
    window.OneSignalDeferred = window.OneSignalDeferred || [];
    OneSignalDeferred.push(async function(OneSignal) {
        await OneSignal.init({
            appId: "{{ config('services.onesignal.app_id') }}",
        });
        const onesignalId = OneSignal.User.PushSubscription.id;
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let userId = "{{ auth()->id() }}";

        let url = "{{ route('token.store') }}";
        if (onesignalId) {
            axios.post(url, {
                'token': onesignalId,
                'user_id': userId
            }, {
                headers: {
                    'X-CSRF-TOKEN': token
                }
            }).then((response) => {
                // Handle the response here
                console.log(response);
            }).catch((error) => {
                // Handle errors here
                console.error(error);
            });
        }

    });

    $("#btnPrint").on('click', () => {
        window.print();
    })
</script>

@stack('myScript')

</html>
