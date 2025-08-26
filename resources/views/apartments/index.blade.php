@extends('layouts.app')
@section('pagetitle', 'Apartment')
@section('main-content')
    {{-- Main section --}}
    <section class="section">
        <div class="section-header">
            <h1>Apartments </h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Apartments</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-md-flex justify-content-between">
                            <h4>Apartments List</h4>
                            <div>
                                <a href="{{ route('apartments.create') }}" class="btn btn-primary rounded">
                                    <i class="fas fa-plus"></i> Add Apartment
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
                                            <th>Apartment Number</th>
                                            <th>Apartment Area</th>
                                            <th>Aparmtent Type</th>
                                            <th>Status</th>
                                            <th>Towaer Name</th>
                                            <th>Floors</th>
                                            <th style="width: 200px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($apartments as $key => $aparmtnet)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                
                                                <td>{{ $aparmtnet->apartment_no  }}</td>
                                                <td>{{ $aparmtnet->apartment_area }}</td>
                                                <td>{{ $aparmtnet->apartment_type }}</td>

                                                <td>
                                                    @if ($aparmtnet->apartment_status)
                                                        <span class="badge badge-success">Active</span>
                                                    @else
                                                        <span class="badge badge-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>{{ $aparmtnet->tower_name }}</td>

                                                <td>{{ $aparmtnet->floor }}</td>

                                                <td>
                                                    <div class="btn-group" role="group">

                                                        <a href="{{ route('apartments.edit', $user->id) }}" class="btn btn-primary btn-sm mr-2" data-toggle="tooltip" title="Edit">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>

                                                        <form action="{{ route('apartments.destroy', $user->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this user?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach --}}
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
