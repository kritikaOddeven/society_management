@extends('layouts.app')
@section('pagetitle', 'User Details')
@section('main-content')
    {{-- Main section --}}
    <section class="section">
        <div class="section-header">
            <h1>User Details</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></div>
                <div class="breadcrumb-item">User Details</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-md-flex justify-content-between">
                            <h4>User Information</h4>
                            <div>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">
                                    <i class="fas fa-pencil-alt"></i> Edit User
                                </a>
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back to List
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 text-center">
                                    @if($user->profile_image)
                                        <img src="{{ asset($user->profile_image) }}" 
                                             alt="Profile Image" 
                                             class="img-fluid rounded-circle mb-3" 
                                             style="max-width: 150px;">
                                    @else
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" 
                                             style="width: 150px; height: 150px; font-size: 3rem;">
                                            {{ strtoupper(substr($user->full_name ?? $user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    
                                    <div class="mt-3">
                                        @if($user->status)
                                            <span class="badge badge-success badge-lg">Active</span>
                                        @else
                                            <span class="badge badge-danger badge-lg">Inactive</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Full Name</label>
                                                <p class="form-control-plaintext">{{ $user->full_name ?? $user->name }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Email Address</label>
                                                <p class="form-control-plaintext">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Phone Number</label>
                                                <p class="form-control-plaintext">
                                                    @if($user->phone_number)
                                                        {{ $user->country_code }} {{ $user->phone_number }}
                                                    @else
                                                        <span class="text-muted">Not provided</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Country Code</label>
                                                <p class="form-control-plaintext">{{ $user->country_code }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Role</label>
                                                <p class="form-control-plaintext">
                                                    @foreach($user->roles as $role)
                                                        <span class="badge badge-{{ $role->name === 'super-admin' ? 'danger' : ($role->name === 'admin' ? 'warning' : 'info') }} badge-lg">
                                                            {{ ucfirst(str_replace('-', ' ', $role->name)) }}
                                                        </span>
                                                    @endforeach
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Member Since</label>
                                                <p class="form-control-plaintext">{{ $user->created_at->format('F j, Y') }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Last Updated</label>
                                                <p class="form-control-plaintext">{{ $user->updated_at->format('F j, Y \a\t g:i A') }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Email Verified</label>
                                                <p class="form-control-plaintext">
                                                    @if($user->email_verified_at)
                                                        <span class="badge badge-success">Verified</span>
                                                        <br><small class="text-muted">{{ $user->email_verified_at->format('F j, Y') }}</small>
                                                    @else
                                                        <span class="badge badge-warning">Not Verified</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    @if($user->hasRole('super-admin'))
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle"></i>
                                            <strong>Super Admin User:</strong> This user has full system access and cannot be deleted or deactivated.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- End main section --}}
@endsection
