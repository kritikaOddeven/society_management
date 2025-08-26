@extends('layouts.app')
@section('pagetitle', 'Add Owner')
@section('main-content')
    {{-- Main section --}}
    <section class="section">
        <div class="section-header">
            <h1>Add Owner</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('owners.index') }}">Owners</a></div>
                <div class="breadcrumb-item">Add Owner</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Add Owner</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('owners.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="full_name">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                                            @error('full_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email Address <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                         <div class="form-group">
                                            <label for="country_code">Country Code</label>
                                            <select class="form-control @error('country_code') is-invalid @enderror" id="country_code" name="country_code">
                                                <option value="+91" {{ old('country_code') == '+91' ? 'selected' : '' }}>+91 </option>
                                                <option value="+93" {{ old('country_code') == '+93' ? 'selected' : '' }}>+93</option>
                                                <option value="+1" {{ old('country_code') == '+1' ? 'selected' : '' }}>+1</option>
                                                <option value="+44" {{ old('country_code') == '+44' ? 'selected' : '' }}>+44</option>
                                                <option value="+86" {{ old('country_code') == '+86' ? 'selected' : '' }}>+86 </option>
                                                <option value="+81" {{ old('country_code') == '+81' ? 'selected' : '' }}>+81</option>
                                                <option value="+49" {{ old('country_code') == '+49' ? 'selected' : '' }}>+49 </option>
                                                <option value="+33" {{ old('country_code') == '+33' ? 'selected' : '' }}>+33 </option>
                                                <option value="+39" {{ old('country_code') == '+39' ? 'selected' : '' }}>+39 </option>
                                                <option value="+34" {{ old('country_code') == '+34' ? 'selected' : '' }}>+34    </option>
                                            </select>
                                            @error('country_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="phone_number">Phone Number</label>
                                            <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" placeholder="Phone">
                                            @error('phone_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="profile_image">Profile Image</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input @error('profile_image') is-invalid @enderror" id="profile_image" name="profile_image" accept="image/*">
                                                <label class="custom-file-label" for="profile_image">Choose file</label>
                                            </div>
                                            @error('profile_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tower_name">Select Tower <span class="text-danger">*</span></label>
                                            <select class="form-control @error('tower_name') is-invalid @enderror" id="tower_name" name="tower_name" required>
                                                <option value="">Select Tower Name</option>
                                                {{-- @foreach ($towers as $tower)
                                                    <option value="{{ $tower->tower_name }}" {{ old('tower') == $tower->tower_name ? 'selected' : '' }}>
                                                        {{ ucfirst(str_replace('-', ' ', $tower->tower_name)) }}
                                                    </option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="floor">Select Floor <span class="text-danger">*</span></label>
                                            <select class="form-control @error('floor') is-invalid @enderror" id="floor" name="floor" required>
                                                <option value="">Select Floor</option>
                                                {{-- @foreach ($floors as $floor)
                                                    <option value="{{ $floor->floor }}" {{ old('floor') == $floor->floor ? 'selected' : '' }}>
                                                        {{ ucfirst(str_replace('-', ' ', $floor->floor)) }}
                                                    </option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="apartment">Select Apartment <span class="text-danger">*</span></label>
                                            <select class="form-control @error('apartment') is-invalid @enderror" id="apartment" name="apartment" required>
                                                <option value="">Select Apartment</option>
                                                {{-- @foreach ($apartments as $apartment)
                                                    <option value="{{ $apartment->aparmtent_number }}" {{ old('aparmtent_number') == $apartment->aparmtent_number ? 'selected' : '' }}>
                                                        {{ ucfirst(str_replace('-', ' ', $apartment->aparmtent_number)) }}
                                                    </option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group d-flex justify-content-end">
                                    <a href="{{ route('owners.index') }}" class="btn btn-secondary mr-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- End main section --}}
@endsection

@push('scripts')
    <script>
        // Update file input label when file is selected
        document.getElementById('profile_image').addEventListener('change', function(e) {
            var fileName = e.target.files[0] ? e.target.files[0].name : 'Choose file';
            e.target.nextElementSibling.textContent = fileName;
        });
    </script>
@endpush
