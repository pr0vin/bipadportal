<div id="navbar" class="sticky-top " style="z-index: 990;height:99px">
    <nav class="navbar navbar-expand-lg border-bottom navbar-dark bg-deep-blue flex-fill z-depth-0">
        @if (Auth::user()->roles[0]->name != 'doctor')
            <a id="sidebar-toggler" class="text-dark mr-3" onclick="toggleSidebar()">
                <span class="fa fa-bars"></span>
            </a>
        @endif
        @if (Auth::user()->roles[0]->name != 'doctor')
            @role('super-admin')
                <form action="{{ route('setOrganization') }}" method="GET">
                    <select name="address_id" class="border-0 form-control devanagiri-font-size font-14 "
                        style="background-color: transparent" onchange="this.form.submit()">
                        <option value="">पालिका छान्नुहोस्</option>
                        @foreach (\App\Organization::latest()->get() as $organization)
                            <option value="{{ $organization->address_id }}"
                                {{ Session::get('municipality_id') == $organization->address_id ? 'selected' : '' }}>
                                {{ $organization->address->municipality }}</option>
                        @endforeach
                    </select>
                </form>
            @else
                <a class="navbar-brand  devanagiri-font-size font-nep text-danger"
                    href="{{ route('home') }}">{{ Auth::user()->municipality->municipality }}</a>
            @endrole
        @else
            <a class="navbar-brand  devanagiri-font-size font-nep text-danger"
                href="{{ route('home') }}">{{ settings()->get('app_name', $default = 'विपद दर्ता प्रणाली') }}</a>
        @endif

        <div class="d-flex justify-content-end ml-4">
            <div class="letsgo">
                <div class="select">
                    <div class="d-flex">
                        <input type="text" class="search-input" placeholder="पिडित खोजि गर्नुहोस्...">
                        <button class="search bg-transparent search-btn"><i class="fa fa-search"></i></button>
                    </div>
                    <div class="list">
                    </div>
                </div>
            </div>
        </div>

        <div class="collapse navbar-collapse" id="navbarSupportedContent-333">

            <ul class="navbar-nav ml-auto nav-flex-icons" style="min-width: 150px">
                <li class="nav-item dropdown " style="background-color: #fff">
                    <a class="nav-link  text-dark font-14" id="navbarDropdownMenuLink-333" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i> {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-default"
                        aria-labelledby="navbarDropdownMenuLink-333">
                        @if (Auth::user()->roles[0]->name == 'doctor')
                            <a class="dropdown-item font-14"
                                href="{{ route('password.change.form', Auth::user()) }}">Profile</a>
                        @endif
                        <a class="dropdown-item font-14"
                            href="{{ route('password.change.form', Auth::user()) }}">Change
                            Password</a>
                        <a class="dropdown-item font-14 font-nep"
                            href="{{ route('user.settings.index') }}">@lang('navigation.my_settings')</a>
                        <a class="dropdown-item font-14" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>

            </ul>
        </div>
    </nav>
</div>

<style>
    .nav-item.dropdown.show {
        background-color: #fff !important
    }

    .nav-item.dropdown.show a {
        background-color: #fff !important
    }

    .letsgo {
        position: relative;
        padding: 0;
        /* overflow: hidden; */
    }

    .select {
        z-index: 999;
        position: absolute;
        top: -20px;
        /* box-shadow: 0px 1px 5px 3px rgba(0, 0, 0, 0.12); */
        border: 1px solid #cccccc6d;
        border-radius: 5px;
        overflow: hidden !important;
    }

    .search-input {
        outline: none !important;
        padding: 7.5px;
        /* border-color: #fff; */
        border: 1px solid #fff;
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
        width: 300px;
        /* background-color: #cccccc16; */

    }

    .select .d-flex {
        /* box-shadow: 0px 1px 5px rgba(0, 0, 0, 0.1); */

    }

    .list {
        background-color: #fff;
    }

    .list li {
        list-style: none;
        padding: 5px 10px;
        cursor: pointer;
    }

    .list li:hover {
        padding: 5px 10px;
        color: #fff;
        background-color: rgba(0, 0, 0, 0.5)
    }

    .search-btn {
        border: 1px solid #fff;
        border-left: none;
        border-bottom-right-radius: 4px;
        border-top-right-radius: 4px;
        padding: 0 10px;
        /* background-color: #cccccc16 !important; */
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.7.7/axios.min.js"></script>
<script>
    let suggestions = [];

    const searchWrapper = document.querySelector(".select");
    const inputBox = searchWrapper.querySelector("input");
    const suggBox = searchWrapper.querySelector(".list");
    const icon = searchWrapper.querySelector(".search");
    let webLink;

    inputBox.onkeyup = (e) => {

        let userData = e.target.value;
        if (userData.length > 0) {
            getPatient(userData);
        }else{
            suggBox.innerHTML="";
        }
        // getPatient(e.target.value);

    }

    function getPatient(userData) {
        let url = `{{ route('searchPatient', ':id') }}`.replace(':id', userData);
        axios.get(url).then(function(response) {
            console.log(response.data);
            suggestions = [];
            response.data.forEach(item => {
                suggestions.push(item);

                // console.log(item)
            });
            if (userData) {

                icon.onclick = () => {
                    console.log(`user send : ${userData}`);
                }
                console.log("sug" + suggestions);
                emptyArray = suggestions.filter((data) => {
                    return data.name.toLocaleLowerCase().startsWith(userData.toLocaleLowerCase());
                });
                console.log("Emp" + emptyArray)
                emptyArray = suggestions.map((data) => {
                    return data = `<li class="kalimati-font" data-id="${data.id}">${data.name} (${data.mobile_number})</li>`;
                });
                searchWrapper.classList.add("active");
                showSuggestions(emptyArray);
                let allList = suggBox.querySelectorAll("li");
                for (let i = 0; i < allList.length; i++) {
                    allList[i].setAttribute("onclick", "select(this)");
                }
            } else {
                alert('sdfs')
                searchWrapper.classList.remove("active");
            }
            // console.log("Suggestions="+suggestions);
        })
    }

    function select(element) {
        const selectData = element.getAttribute('data-id');
        const baseUrl = "{{ url('/') }}" + "/patient/" + (selectData ?? 1) + "/show";
        window.location.href = baseUrl;
    }

    function showSuggestions(list) {
        let listData;
        console.log("==============")
        console.log("List=" + list)
        if (!list.length) {
            userValue = inputBox.value;
            listData = `<li>${userValue.name}</li>`;
        } else {
            listData = list.join('');
        }
        suggBox.innerHTML = listData;
    }
</script>
