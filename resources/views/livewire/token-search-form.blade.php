<div>
    @if($this->organization->id)
    <div class="row">
        <div class="col-md-6">
            <table class="table table-borderless table-responsive">
                <tr>
                    <td>सेवाग्रहिको नाम:</td>
                    <td>{{ $this->organization->name }}</td>
                    {{-- <td class="font-weight-bolder">{{ $organization->org_name }}</td> --}}
                </tr>
                <tr>
                    <td>सम्पर्क व्यक्ति:</td>
                    <td>{{ $this->organization->contact_person }}</td>
                </tr>
                <tr>
                    <td>टोकन नम्बर:</td>
                    <td class="kalimati-font">{{ $tokenNumber }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <a class="btn btn-danger z-depth-0 btn-lg font-16px lang-english" wire:click="cancel">रद्द गर्नुहोस्</a>
                        <a class="btn btn-success z-depth-0 btn-lg font-16px lang-english" href="{{ route('suchi-print-application', $this->organization ?? '') }}"><span class="mr-3"><i class="fa fa-print"></i></span>निवेदन छाप्नुहोस्</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    @else
    <form wire:submit.prevent="search" class="form">
        @if($message)
        <div class="alert alert-danger alert-dismissible font-noto fade show z-depth-0" role="alert">
            {{ $message }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true" class="text-white">&times;</span>
            </button>
        </div>
        @endif
        <div class="form-group text-center">
            <h1 class="h1-responsive font-weight-bolder indigo-text font-noto">@lang('app.token_number')</h1>
        </div>
        <div class="form-group text-center">
            <div class="input-group w-responsive d-inline-flex my-2">
                <input type="number" wire:model="tokenNumber" class="form-control @error('tokenNumber') is-invalid @enderror form-control-lg" autocomplete="off" autofocus>
                @error('tokenNumber')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group text-center font-noto">
                <button class="btn btn-indigo z-depth-0"><span class="svg-icon svg-baseline font-16px mr-2">@include('svg.search')</span>Search</button>
            </div>
        </div>
    </form>
    @endif
</div>
