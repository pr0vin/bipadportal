@extends('layouts.app')

@section('content')
<div class="mb-3 d-flex">
    <div>
        <h4>कारोवार परिवर्तन फारम</h4>
        <div>व्यवसायको नाम: {{ $organization->org_name }}</div>
    </div>
    <div class="ml-auto">
        <a class="btn btn-primary btn-sm z-depth-0" href="{{ route('organization.show', $organization) }}">Back</a>
    </div>
</div>

<div class="card z-depth-0">
    <div class="card-body">
        @include('alerts.all')
        <form action="{{ route('karobar-paribartan.store', $organization) }}" method="POST" class="needs-validation" novalidate>
            @csrf
            <div class="row">
                <div class="col-md-4 form-group">
                    <label for="input-org-type" class="required">व्यवसायको प्रकृति</label>
                    <select name="org_type" class="custom-select">
                        <option value="">प्रकृति छान्नुहोस्</option>
                        @foreach ($organizationTypes as $organizationType)
                        <option value="{{ $organizationType->name }}" @if(old('org_type', $organization->org_type) == $organizationType->name) selected @endif>{{ $organizationType->name }}</option>
                        @endforeach
                    </select>
                    <x-invalid-feedback field="org_type"></x-invalid-feedback>
                </div>
                <div class="col-md-4 form-group">
                    <label for="" class="required">कारोबार गर्ने वस्तु</label>
                    <input type="text" name="org_product_type" class="form-control unicode-font rounded-0 {{ invalid_class('org_product_type') }}" value="{{ old('org_product_type', $organization->org_product_type ?? '' ) }}" required>
                    <x-invalid-feedback field="org_product_type"></x-invalid-feedback>
                </div>
            </div>

            <div classp hide-on-old-entry="form-group">
                <button class="btn btn-primary z-depth-0"><i class="fa fa-save fa-lg mr-2"></i>सुनिस्चित गर्नुहोस </button>
            </div>
        </form>

    </div>
</div>


<h5 class="mt-4">कारोवार परिवर्तन चार्ट</h5>
@foreach ($karobarParibartans as $item)
<div class="card z-depth-0 mt-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-5">
                <div>
                    <div>व्यवसायको प्रकृति: <b>{{ $item->old_org_type }}</b></div>
                    <div>कारोबार गर्ने वस्तु: <b>{{ $item->old_org_product_type }}</b></div>
                </div>
            </div>
            <div class="col-md-2 d-flex justify-content-center align-items-center text-primary"><i class="fa fa-arrow-right fa-lg"></i></div>
            <div class="col-md-5">
                <div>
                    <div>व्यवसायको प्रकृति: <b>{{ $item->new_org_type }}</b></div>
                    <div>कारोबार गर्ने वस्तु: <b>{{ $item->new_org_product_type }}</b></div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer bg-white d-flex justify-content-between">
        <div>जिम्मेवार अधिकारी : <b>{{ $item->processing_officer }}</b></div>
        <div>मिति : <b>{{ $item->date_np }}</b></div>
    </div>
</div>
@endforeach
@endsection

@push('scripts')
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

</script>
@endpush
