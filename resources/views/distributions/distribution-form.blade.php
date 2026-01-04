@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-deep-blue text-dark">
                <h4 class="mb-0">वितरण फारम</h4>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('distributions.distribution.form') }}" id="distributionForm">
                    @csrf
                    
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label for="distribution_date" class="form-label">मिति *</label>
                            <input type="text" 
                                   name="distribution_date" 
                                   id="distribution_date" 
                                   class="form-control kalimati-font" 
                                   value="{{ old('distribution_date', ad_to_bs(now()->format('Y-m-d'))) }}" 
                                   required>
                            @error('distribution_date')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="title" class="form-label">शीर्षक *</label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   class="form-control kalimati-font" 
                                   value="{{ old('title') }}" 
                                   placeholder="वितरणको शीर्षक प्रविष्ट गर्नुहोस्" 
                                   required>
                            @error('title')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                       
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="distributionTable">
                            <thead class="bg-light">
                                <tr>
                                    <th width="50">क्र.सं.</th>
                                    <th width="300">बिरामीको नाम थर</th>
                                    <th width="150">अनुमानित रकम</th>
                                    <th width="150">वितरण गरिएको रकम *</th>
                                    <th width="200">कैफियत</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($patients as $index => $patient)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $patient->name }}</strong><br>
                                    </td>
                                    
                                    <td>
                                        <span class="estimated-amount" data-value="{{ $patient->estimated_amount }}">
                                            रु {{ number_format($patient->estimated_amount, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <input type="hidden" name="patients[{{ $index }}][id]" value="{{ $patient->id }}">
                                        <input type="hidden" name="patients[{{ $index }}][estimated_amount]" value="{{ $patient->estimated_amount }}">
                                        
                                        <input type="number" name="patients[{{ $index }}][supplied_amount]"  class="form-control supplied-amount kalimati-font" min="0" 
                                               max="{{ $patient->estimated_amount }}"
                                               step="0.01" data-patient-id="{{ $patient->id }}" placeholder="रकम">
                                        @error("patients.{$index}.supplied_amount")
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="text" name="patients[{{ $index }}][remark]" class="form-control kalimati-font" rows="2"  placeholder="कैफियत">{{ old("patients.{$index}.remark") }}</textarea>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>जम्मा:</strong></td>
                                  
                                    <td colspan="2"><strong id="totalSupplied">रु 0.00</strong></td>
                                    
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="mt-4">
                        <div class="row text-end ">
                            
                            <div class="col-md-8 ">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-save"></i> वितरण सेभ गर्नुहोस्
                                </button>
                                <button type="button" class="btn btn-secondary btn-lg" onclick="window.history.back()">
                                    <i class="fas fa-times"></i> रद्द गर्नुहोस्
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Nepali Date Picker -->
    <link href="https://nepalidatepicker.sajanmaharjan.com.np/v5/nepali.datepicker/css/nepali.datepicker.v5.0.6.min.css" rel="stylesheet">
@endsection

@section('scripts')
    <script src="https://nepalidatepicker.sajanmaharjan.com.np/v5/nepali.datepicker/js/nepali.datepicker.v5.0.6.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Initialize Nepali Date Picker
        document.addEventListener('DOMContentLoaded', function() {
            var datePicker = document.getElementById('distribution_date');
            datePicker.nepaliDatePicker({
                ndpYear: true,
                ndpMonth: true,
                ndpYearCount: 10,
                readOnlyInput: false,
                disableBefore: "2020-01-01",
                language: "nepali"
            });

            // Calculate totals on page load
            calculateTotals();

            // Select all functionality
            document.getElementById('selectAll').addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.patient-select');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            // Auto-calculate supplied amount when changed
            document.querySelectorAll('.supplied-amount').forEach(input => {
                input.addEventListener('input', function() {
                    const estimated = parseFloat(this.closest('tr').querySelector('.estimated-amount').dataset.value) || 0;
                    const supplied = parseFloat(this.value) || 0;
                    
                    if (supplied > estimated) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'चेतावनी',
                            text: 'वितरण रकम अनुमानित रकम भन्दा बढी छ!',
                            confirmButtonText: 'ठिक छ'
                        });
                        this.value = estimated;
                    }
                    
                    calculateTotals();
                });
            });

            // Calculate totals when checkbox is toggled
            document.querySelectorAll('.patient-select').forEach(checkbox => {
                checkbox.addEventListener('change', calculateTotals);
            });

            // Form validation
            document.getElementById('distributionForm').addEventListener('submit', function(e) {
                const selectedPatients = document.querySelectorAll('.patient-select:checked');
                const distributionDate = document.getElementById('distribution_date').value;
                const title = document.getElementById('title').value;
                
                if (selectedPatients.length === 0) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'त्रुटि',
                        text: 'कृपया कम्तिमा एक बिरामी चयन गर्नुहोस्!',
                        confirmButtonText: 'ठिक छ'
                    });
                    return;
                }
                
                if (!distributionDate.trim()) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'त्रुटि',
                        text: 'कृपया मिति प्रविष्ट गर्नुहोस्!',
                        confirmButtonText: 'ठिक छ'
                    });
                    return;
                }
                
                if (!title.trim()) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'त्रुटि',
                        text: 'कृपया शीर्षक प्रविष्ट गर्नुहोस्!',
                        confirmButtonText: 'ठिक छ'
                    });
                    return;
                }
                
                // Validate each selected patient has supplied amount
                let hasError = false;
                selectedPatients.forEach(checkbox => {
                    const row = checkbox.closest('tr');
                    const suppliedInput = row.querySelector('.supplied-amount');
                    const suppliedAmount = parseFloat(suppliedInput.value) || 0;
                    
                    if (suppliedAmount <= 0) {
                        hasError = true;
                        suppliedInput.classList.add('is-invalid');
                    } else {
                        suppliedInput.classList.remove('is-invalid');
                    }
                });
                
                if (hasError) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'त्रुटि',
                        text: 'कृपया चयन गरिएका सबै बिरामीको वितरण रकम प्रविष्ट गर्नुहोस्!',
                        confirmButtonText: 'ठिक छ'
                    });
                }
            });
        });

        function calculateTotals() {
            let totalEstimated = 0;
            let totalSupplied = 0;
            
            document.querySelectorAll('#distributionTable tbody tr').forEach(row => {
                const checkbox = row.querySelector('.patient-select');
                if (checkbox && checkbox.checked) {
                    const estimated = parseFloat(row.querySelector('.estimated-amount').dataset.value) || 0;
                    const supplied = parseFloat(row.querySelector('.supplied-amount').value) || 0;
                    
                    totalEstimated += estimated;
                    totalSupplied += supplied;
                }
            });
            
            document.getElementById('totalEstimated').textContent = 'रु ' + totalEstimated.toFixed(2);
            document.getElementById('totalSupplied').textContent = 'रु ' + totalSupplied.toFixed(2);
        }

        // Format numbers with comma
        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>

    <style>
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
            text-align: center;
            vertical-align: middle;
        }
        
        .table td {
            vertical-align: middle;
        }
        
        .estimated-amount {
            font-weight: bold;
            color: #198754;
        }
        
        #totalEstimated, #totalSupplied {
            color: #0d6efd;
            font-size: 1.1em;
        }
        
        .supplied-amount:focus {
            border-color: #198754;
            box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
        }
        
        .form-check-input:checked {
            background-color: #198754;
            border-color: #198754;
        }
        
        .btn-success {
            background-color: #198754;
            border-color: #198754;
            padding: 10px 30px;
            font-weight: 600;
        }
        
        .btn-success:hover {
            background-color: #157347;
            border-color: #146c43;
        }
        
        .is-invalid {
            border-color: #dc3545 !important;
        }
        
        .kalimati-font {
            font-family: 'Kalimati', 'Preeti', 'Mangal', sans-serif;
            font-size: 16px;
        }
    </style>
@endsection