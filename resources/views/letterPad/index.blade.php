@extends('layouts.app')

@section('content')
    <div class="container">
        @include('alerts.all')
    </div>

    <div class="container">
        <div class="card z-depth-0">
            <div class="card-body">
                <h4 class="font-weight-bold">मेरो सेटिंग्स</h4>
                <div class="p-3 mb-4" style="background-color: #FAFAFA;border-bottom:1px solid #ccc">
                    letterpad Preview
                </div>
                <div class="preview mb-5" style="border-bottom: 5px solid #000">
                    <div class="d-flex justify-content-between pb-4">
                        <img src="{{ asset('assets/img/nep-gov-logo-sm.png') }}" alt="" style="max-height: 100px"
                            srcset="">
                        <div class="text-center" style="color: #DC3545">
                            <h2 class="h2-responsive font-weight-bold" id="lbl_municipality_name">
                                {{ $letterPad->municipality_name ?? 'डेमो नगरपालिका' }}</h2>
                            <div class="my-2"></div>
                            <h4 class="h4-responsive font-weight-bold" id="lbl_tag_line">
                                {{ $letterPad->tag_line ?? 'नगर कार्यपालिकाको कार्यालय' }}
                            </h4>
                            <div class="font-weight-bold">
                                <div id="lbl_address_one">{{ $letterPad->address_line_one ?? 'डेमो, ठेगाना' }}</div>
                                <div id="lbl_address_two">{{ $letterPad->address_line_two ?? 'सुदूरपश्चिम प्रदेश, नेपाल' }}
                                </div>
                            </div>
                        </div>
                        <div style="min-width: 200px" class="d-block">
                            @if ($letterPad)
                                <div id="spn_phone" class="{{ $letterPad->phone ? '' : 'd-none' }}"><i
                                        class="fa fa-phone"></i> <span id="lbl_phone">{{ $letterPad->phone }}</span></div>
                                <div id="spn_gmail" class="{{ $letterPad->email ? '' : 'd-none' }}"><i
                                        class="fa fa-envelope" aria-hidden="true"></i> <span
                                        id="lbl_gmail">{{ $letterPad->email }}</span> </div>
                                <div id="spn_web" class="{{ $letterPad->website ? '' : 'd-none' }}"><i
                                        class="fas fa-globe"></i> <span id="lbl_web">{{ $letterPad->website }}</span>
                                </div>
                            @else
                                <div id="spn_phone" class="d-none"><i
                                        class="fa fa-phone"></i> <span id="lbl_phone"></span></div>
                                <div id="spn_gmail" class="d-none"><i
                                        class="fa fa-envelope" aria-hidden="true"></i> <span
                                        id="lbl_gmail"></span> </div>
                                <div id="spn_web" class="d-none"><i
                                        class="fas fa-globe"></i> <span id="lbl_web"></span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <h5 class="font-weight-bold text-black-50">Letterpad Settings</h5>
                <small>These values are used to construct the letter pad for your ward.</small>
                <form action="{{ $letterPad ? route('letterpadding.update',$letterPad->id) : route('letterpadding.store') }}" method="POST">
                    @csrf
                    @isset($letterPad)
                        @method('PUT')
                    @endisset
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Municipality Name</label>
                                <input type="text" id="municipality_name" name="municipality_name"
                                    value="{{ old('municipality_name', $letterPad->municipality_name ?? '') }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tagline</label>
                                <input type="text" id="tag_line" name="tag_line"
                                    value="{{ old('tag_line', $letterPad->tag_line ?? '') }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Address Line One</label>
                                <input type="text" id="address_one" name="address_line_one"
                                    value="{{ old('address_line_one', $letterPad->address_line_one ?? '') }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Address Line Two</label>
                                <input type="text" id="address_two" name="address_line_two"
                                    value="{{ old('address_line_two', $letterPad->address_line_two ?? '') }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" id="phone" name="phone"
                                    value="{{ old('phone', $letterPad->phone ?? '') }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" id="gmail" name="email"
                                    value="{{ old('email', $letterPad->email ?? '') }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Website</label>
                                <input type="text" id="web" name="website"
                                    value="{{ old('website', $letterPad->website ?? '') }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-info">{{ $letterPad ? 'update' : 'Save' }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(() => {
            $("#municipality_name").on('input', () => {
                let name = $("#municipality_name").val();
                if (name.length <= 0) {
                    name = "डेमो नगरपालिका";
                }
                $("#lbl_municipality_name").text(name)
            });

            $("#tag_line").on('input', () => {
                let name = $("#tag_line").val();
                if (name.length <= 0) {
                    name = "नगर कार्यपालिकाको कार्यालय";
                }
                $("#lbl_tag_line").text(name)
            })
            $("#address_one").on('input', () => {
                let name = $("#address_one").val();
                if (name.length <= 0) {
                    name = "डेमो, ठेगाना";
                }
                $("#lbl_address_one").text(name)
            })
            $("#address_two").on('input', () => {
                let name = $("#address_two").val();
                if (name.length <= 0) {
                    name = "सुदूरपश्चिम प्रदेश, नेपाल";
                }
                $("#lbl_address_two").text(name)
            })
            $("#phone").on('input', () => {
                let name = $("#phone").val();
                if (name.length <= 0) {
                    $("#spn_phone").addClass('d-none')
                }else{
                    $("#spn_phone").removeClass('d-none')
                }
                $("#lbl_phone").text(name)
            })
            $("#gmail").on('input', () => {
                let name = $("#gmail").val();
                if (name.length <= 0) {
                    $("#spn_gmail").addClass('d-none')
                }else{
                    $("#spn_gmail").removeClass('d-none')
                }
                $("#lbl_gmail").text(name)
            })
            $("#web").on('input', () => {
                let name = $("#web").val();
                if (name.length <= 0) {
                    $("#spn_web").addClass('d-none')
                }else{
                    $("#spn_web").removeClass('d-none')
                }
                $("#lbl_web").text(name)
            })
        })
    </script>
@endpush

@push('styles')
    <style>
        .position-absolute {
            position: absolute !important;
        }
    </style>
@endpush
