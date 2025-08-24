@extends('layouts.app')
@section('pagetitle', 'Users Management')
@section('main-content')
    {{-- Main section --}}
    <section class="section">
        <div class="section-header">
            <h1>Users Management</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Users</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-md-flex justify-content-between">
                            <h4>Users List</h4>
                            <div>
                                <a href="{{ route('users.create') }}" class="btn btn-primary rounded">
                                    <i class="fas fa-plus"></i> Add User
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible show fade">
                                    <div class="alert-body">
                                        <button class="close" data-dismiss="alert">
                                            <span>&times;</span>
                                        </button>
                                        {{ session('success') }}
                                    </div>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible show fade">
                                    <div class="alert-body">
                                        <button class="close" data-dismiss="alert">
                                            <span>&times;</span>
                                        </button>
                                        {{ session('error') }}
                                    </div>
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Profile</th>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th style="width: 200px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $key => $user)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>
                                                @if($user->profile_image)
                                                    <img src="{{ asset($user->profile_image) }}" 
                                                         alt="Profile" 
                                                         class="rounded-circle" 
                                                         width="40" 
                                                         height="40">
                                                @else
                                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" 
                                                         style="width: 40px; height: 40px;">
                                                        {{ strtoupper(substr($user->full_name ?? $user->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ $user->full_name ?? $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if($user->phone_number)
                                                    {{ $user->country_code }} {{ $user->phone_number }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @foreach($user->roles as $role)
                                                    <span class="badge badge-{{ $role->name === 'super-admin' ? 'danger' : ($role->name === 'admin' ? 'warning' : 'info') }}">
                                                        {{ ucfirst(str_replace('-', ' ', $role->name)) }}
                                                    </span>
                                                @endforeach
                                            </td>
                                            <td>
                                                @if($user->status)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('users.show', $user->id) }}" 
                                                       class="btn btn-info btn-sm" 
                                                       data-toggle="tooltip" 
                                                       title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    
                                                    <a href="{{ route('users.edit', $user->id) }}" 
                                                       class="btn btn-primary btn-sm" 
                                                       data-toggle="tooltip" 
                                                       title="Edit">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    
                                                    @if(!$user->hasRole('super-admin'))
                                                        <form action="{{ route('users.toggle-status', $user->id) }}" 
                                                              method="POST" 
                                                              style="display: inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" 
                                                                    class="btn btn-{{ $user->status ? 'warning' : 'success' }} btn-sm" 
                                                                    data-toggle="tooltip" 
                                                                    title="{{ $user->status ? 'Deactivate' : 'Activate' }}"
                                                                    onclick="return confirm('Are you sure you want to {{ $user->status ? 'deactivate' : 'activate' }} this user?')">
                                                                <i class="fas fa-{{ $user->status ? 'ban' : 'check' }}"></i>
                                                            </button>
                                                        </form>
                                                        
                                                        <form action="{{ route('users.destroy', $user->id) }}" 
                                                              method="POST" 
                                                              style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="btn btn-danger btn-sm" 
                                                                    data-toggle="tooltip" 
                                                                    title="Delete"
                                                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- End main section --}}
@endsection