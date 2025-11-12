@extends('layouts.app')
@section('pagetitle', 'Edit Tenant')
@section('main-content')
    {{-- Main section --}}
    <section class="section">
        <div class="section-header">
            <h1>Edit Tenant</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('tenants.index') }}">Tenants</a></div>
                <div class="breadcrumb-item">Edit Tenant</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Tenant</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('tenants.update', $tenant->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="owner_id">Select Owner</label>
                                            <select class="form-control @error('owner_id') is-invalid @enderror" id="owner_id" name="owner_id">
                                                <option value="">Select Owner</option>
                                                @foreach ($owners as $owner)
                                                    <option value="{{ $owner->id }}" {{ $tenant->owner_id == $owner->id ? 'selected' : '' }}>
                                                        {{ $owner->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('owner_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="name">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $tenant->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="email">Email Address </label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $tenant->email) }}">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone_number">Phone Number <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <select class="form-control col-md-2 @error('country_code') is-invalid @enderror" 
                                                        id="country_code" name="country_code">
                                                    <option value="+91" {{ old('country_code', $tenant->country_code) == '+91' ? 'selected' : '' }}>+91</option>
                                                    <option value="+93" {{ old('country_code', $tenant->country_code) == '+93' ? 'selected' : '' }}>+93</option>
                                                    <option value="+1"  {{ old('country_code', $tenant->country_code) == '+1'  ? 'selected' : '' }}>+1</option>
                                                    <option value="+44" {{ old('country_code', $tenant->country_code) == '+44' ? 'selected' : '' }}>+44</option>
                                                    <option value="+86" {{ old('country_code', $tenant->country_code) == '+86' ? 'selected' : '' }}>+86</option>
                                                    <option value="+81" {{ old('country_code', $tenant->country_code) == '+81' ? 'selected' : '' }}>+81</option>
                                                    <option value="+49" {{ old('country_code', $tenant->country_code) == '+49' ? 'selected' : '' }}>+49</option>
                                                    <option value="+33" {{ old('country_code', $tenant->country_code) == '+33' ? 'selected' : '' }}>+33</option>
                                                    <option value="+39" {{ old('country_code', $tenant->country_code) == '+39' ? 'selected' : '' }}>+39</option>
                                                    <option value="+34" {{ old('country_code', $tenant->country_code) == '+34' ? 'selected' : '' }}>+34</option>
                                                </select>
                                                <input type="text" 
                                                       class="form-control @error('phone_number') is-invalid @enderror" 
                                                       id="phone_number" name="phone_number" 
                                                       value="{{ old('phone_number', $tenant->phone_number) }}" 
                                                       placeholder="Phone">
                                            </div>
                                            @error('country_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            @error('phone_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="profile_image">Profile Image</label>
                                            @if($tenant->profile_image)
                                                <div class="mb-2">
                                                    <img src="{{ asset($tenant->profile_image) }}" alt="Current Profile" style="max-width: 100px; height: auto;">
                                                    <small class="d-block text-muted">Current image</small>
                                                </div>
                                            @endif
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input @error('profile_image') is-invalid @enderror" id="profile_image" name="profile_image" accept="image/*">
                                                <label class="custom-file-label" for="profile_image">Choose new file</label>
                                            </div>
                                            @error('profile_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="form-group d-flex justify-content-end">
                                    <a href="{{ route('tenants.index') }}" class="btn btn-secondary mr-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- End main section --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        // Update file input label when file is selected
        document.getElementById('profile_image').addEventListener('change', function(e) {
            var fileName = e.target.files[0] ? e.target.files[0].name : 'Choose new file';
            e.target.nextElementSibling.textContent = fileName;
        });
    </script>


@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Initialize Flatpickr on date fields
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize start date picker
        const startDatePicker = flatpickr('#contract_start_date', {
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: 'F j, Y',
            onChange: function(selectedDates, dateStr, instance) {
                // Update end date min date when start date changes
                if (selectedDates[0]) {
                    endDatePicker.set('minDate', selectedDates[0]);
                }
            }
        });
        
        // Initialize end date picker
        const endDatePicker = flatpickr('#contract_end_date', {
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: 'F j, Y',
            minDate: document.getElementById('contract_start_date').value || 'today'
        });
    });
</script>
@endpush
