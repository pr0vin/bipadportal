@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>{{ isset($resource) ? 'सामाग्री सम्पादन गर्नुहोस्' : 'नयाँ सामाग्री सिर्जना गर्नुहोस्' }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ isset($resource) ? route('resources.update', $resource->id) : route('resources.store') }}">
                        @csrf
                        @if(isset($resource))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="name" class="form-label">सामाग्री<span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" 
                                   value="{{ old('name', $resource->name ?? '') }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="unit_id" class="form-label">ईकाई<span class="text-danger">*</span></label>
                            <select class="form-control @error('unit_id') is-invalid @enderror" 
                                    id="unit_id" name="unit_id" required>
                                <option value="">ईकाई चयन गर्नुहोस्</option>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}" 
                                            {{ old('unit_id', $resource->unit_id ?? '') == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('unit_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">परिमाण<span class="text-danger">*</span></label>
                            <input type="number" class="form-control kalimati-font @error('quantity') is-invalid @enderror" 
                                   id="quantity" name="quantity" 
                                   value="{{ old('quantity', $resource->quantity ?? 0) }}" 
                                   min="0" required>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">विवरण</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" 
                                      rows="3">{{ old('description', $resource->description ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('resources.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> सूचीमा फिर्ता जानुहोस्
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> {{ isset($resource) ? 'सम्पादन गर्नुहोस्' : 'पेश गर्नुहोस्' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection