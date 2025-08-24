@extends('layouts.app')
@section('pagetitle', 'Add User')
@section('main-content')
    {{-- Main section --}}
    <section class="section">
        <div class="section-header">
            <h1>Add User</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></div>
                <div class="breadcrumb-item">Add User</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Add User</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="full_name">Full Name *</label>
                                            <input type="text" 
                                                   class="form-control @error('full_name') is-invalid @enderror" 
                                                   id="full_name" 
                                                   name="full_name" 
                                                   value="{{ old('full_name') }}" 
                                                   required>
                                            @error('full_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email Address *</label>
                                            <input type="email" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" 
                                                   name="email" 
                                                   value="{{ old('email') }}" 
                                                   required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="country_code">Country Code</label>
                                            <select class="form-control @error('country_code') is-invalid @enderror" 
                                                    id="country_code" 
                                                    name="country_code">
                                                <option value="+93" {{ old('country_code') == '+93' ? 'selected' : '' }}>+93 (Afghanistan)</option>
                                                <option value="+1" {{ old('country_code') == '+1' ? 'selected' : '' }}>+1 (USA/Canada)</option>
                                                <option value="+44" {{ old('country_code') == '+44' ? 'selected' : '' }}>+44 (UK)</option>
                                                <option value="+91" {{ old('country_code') == '+91' ? 'selected' : '' }}>+91 (India)</option>
                                                <option value="+86" {{ old('country_code') == '+86' ? 'selected' : '' }}>+86 (China)</option>
                                                <option value="+81" {{ old('country_code') == '+81' ? 'selected' : '' }}>+81 (Japan)</option>
                                                <option value="+49" {{ old('country_code') == '+49' ? 'selected' : '' }}>+49 (Germany)</option>
                                                <option value="+33" {{ old('country_code') == '+33' ? 'selected' : '' }}>+33 (France)</option>
                                                <option value="+39" {{ old('country_code') == '+39' ? 'selected' : '' }}>+39 (Italy)</option>
                                                <option value="+34" {{ old('country_code') == '+34' ? 'selected' : '' }}>+34 (Spain)</option>
                                            </select>
                                            @error('country_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone_number">Phone Number</label>
                                            <input type="text" 
                                                   class="form-control @error('phone_number') is-invalid @enderror" 
                                                   id="phone_number" 
                                                   name="phone_number" 
                                                   value="{{ old('phone_number') }}" 
                                                   placeholder="Phone">
                                            @error('phone_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="role">Role *</label>
                                            <select class="form-control @error('role') is-invalid @enderror" 
                                                    id="role" 
                                                    name="role" 
                                                    required>
                                                <option value="">Select Role</option>
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                                        {{ ucfirst(str_replace('-', ' ', $role->name)) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('role')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Password *</label>
                                            <input type="password" 
                                                   class="form-control @error('password') is-invalid @enderror" 
                                                   id="password" 
                                                   name="password" 
                                                   required>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password_confirmation">Confirm Password *</label>
                                            <input type="password" 
                                                   class="form-control @error('password_confirmation') is-invalid @enderror" 
                                                   id="password_confirmation" 
                                                   name="password_confirmation" 
                                                   required>
                                            @error('password_confirmation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="profile_image">Profile Image</label>
                                            <div class="custom-file">
                                                <input type="file" 
                                                       class="custom-file-input @error('profile_image') is-invalid @enderror" 
                                                       id="profile_image" 
                                                       name="profile_image" 
                                                       accept="image/*">
                                                <label class="custom-file-label" for="profile_image">Choose file</label>
                                            </div>
                                            @error('profile_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
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
