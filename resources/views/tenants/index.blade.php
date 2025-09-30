@extends('layouts.app')
@section('pagetitle', 'Tenant')
@section('main-content')
    {{-- Main section --}}
    <section class="section">
        <div class="section-header">
            <h1>Tenants</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ url('/') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Tenants</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-md-flex justify-content-between">
                            <h4>Tenant Lists</h4>
                            <div>
                                <a href="{{ route('tenants.all-history') }}" class="btn btn-info rounded mr-2">
                                    <i class="fas fa-history"></i> All History
                                </a>
                                <a href="{{ route('tenants.create') }}" class="btn btn-primary rounded">
                                    <i class="fas fa-plus"></i> Add Tenant
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible show fade">
                                    <div class="alert-body">
                                        <button class="close" data-dismiss="alert">
                                            <span>&times;</span>
                                        </button>
                                        {{ session('success') }}
                                    </div>
                                </div>
                            @endif

                            @if (session('error'))
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
                                            <th>Status</th>
                                            <th>Apartment number</th>
                                            <th style="width: 200px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tenants as $key => $tenant)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>
                                                    @if ($tenant->profile_image)
                                                        <img src="{{ asset($tenant->profile_image) }}" alt="Profile" class="rounded-circle" width="40" height="40">
                                                    @else
                                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                            {{ strtoupper(substr($tenant->name ?? $user->name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>{{ $tenant->name }}</td>
                                                <td>{{ $tenant->email }}</td>
                                                <td>
                                                    @if ($tenant->phone_number)
                                                        {{ $tenant->country_code }} {{ $tenant->phone_number }}
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($tenant->status)
                                                        <span class="badge badge-success">Active</span>
                                                    @else
                                                        <span class="badge badge-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>{{ $tenant->apartment->apartment_number ?? '-'}}</td>

                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('tenants.history', $tenant->id) }}" class="btn btn-info btn-sm mr-2" data-toggle="tooltip" title="History">
                                                            <i class="fas fa-history"></i>
                                                        </a>
                                                        
                                                        <a href="{{ route('tenants.edit', $tenant->id) }}" class="btn btn-primary btn-sm mr-2" data-toggle="tooltip" title="Edit">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>

                                                        <form action="{{ route('tenants.destroy', $tenant->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this tenant?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
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
