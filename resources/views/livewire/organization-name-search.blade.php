<div class="card z-depth-0 mb-4 font-noto">
    <div class="card-header bg-primary text-white">
        <h4 class="h4-responsive"> नयाँ नाम जाँच</h4>
    </div>
    <div class="card-body">
        <form wire:submit.prevent="search">
            <div class="form-group text-right">
                <x-romanized-keyboard-switcher />
            </div>
            <div class="form-group">
                <label for="" class="required">व्यवसायको नाम</label>
                <input type="text" name="name" wire:model.defer="organizationName" class="form-control unicode-font rounded-0 @if(session()->has('success')) is-valid @endif @if(session()->has('error'))  is-invalid @endif" placeholder="फर्मको नामजाँचको लागी यहाँ टाईप गर्नुहोस ।">
                <div class="{{ session()->has('success') ? 'valid-feedback' : '' }} {{ session()->has('error') ? 'invalid-feedback' : '' }}">
                    {{ session('success') ?? session('error') }}
                </div>
                <div class="small my-2">
                    (Space, ह्र्स्व ,दिर्घ, र , एण्ड राखेको आधारमा सिस्टमले नाम दिएमा त्यसलाई विभागले अस्विकृत गर्न सक्नेछ ।)
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary z-depth-0 font-15px"><span class="svg-icon svg-baseline">@include('svg.search')</span> नाम जाँच गर्नुहोस्</button>
                @if(session()->has('success'))
                <a class="btn btn-success z-depth-0 font-15px" href="{{ route('organization.new', ['org_name' => $organizationName]) }}">अगाडि बढ्नुहोस </a>
                @endif
            </div>
        </form>
    </div>
</div>
