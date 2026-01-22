<div class="card z-depth-0">
    <div class="card-body  d-flex  ">
        @role('super-admin')
            <a href="{{ route('settings.system') }}" class="my-menu {{ setActive('settings.system') }} mb-2 mr-1">प्रणाली
                सेटिङ</a>
        @endrole
        {{-- @can('application.setting')
            <a href="{{ route('settings.application') }}"
                class="my-menu mb-2 {{ setActive('settings.application') }} mr-1">आवेदन सेटिङ</a>
        @endcan --}}
        {{-- @can('downloadDocument.setting')
            <a href="{{ route('settings.document') }}" class="my-menu mb-2 {{ setActive('settings.document') }} mr-1">डाउनलोड
                योग्य कागजातहरू</a>
        @endcan --}}
        {{-- @can('colsedReason.setting')
            <a href="{{ route('settings.reason') }}" class="my-menu mb-2 {{ setActive('settings.reason') }} mr-1">लागतकट्टाका
                कारणहरु</a>
        @endcan --}}
        @can('position.setting')
            <a href="{{ route('settings.position') }}" class="my-menu mb-2 {{ setActive('settings.position') }} mr-1">पद</a>
        @endcan
        @can('committeePosition.setting')
            <a href="{{ route('settings.committeePosition') }}"
                class="my-menu mb-2 {{ setActive('settings.committeePosition') }} mr-1">समितिको पद</a>
        @endcan
        @role('super-admin')
            <a href="{{ route('sms.index') }}" class="my-menu mb-2 {{ setActive('sms.index') }} mr-1">SMS</a>
            <a href="{{ route('token.onesignal') }}" class="my-menu mb-2 {{ setActive('token.onesignal') }} mr-1">One
                signal</a>
        @endrole
        {{-- <a href="#">आवेदन सेटिङ</a> --}}
    </div>
</div>

<style>
    .my-menu {
        padding: 8px 10px;
        position: relative;
        /* display: block;
        width: 100%; */
        border-radius: 5px;
    }

    .my-menu.active {
        background-color: #cccccca3;
    }

    .my-menu:hover {
        background-color: #cccccca3;
    }
</style>
