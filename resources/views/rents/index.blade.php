@extends('layouts.app')
@section('pagetitle', 'Rent')
@section('main-content')
    {{-- Main section --}}
    <section class="section">
        <div class="section-header">
            <h1>Rents</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Rents</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-md-flex justify-content-between">
                            <h4>Rent Lists</h4>
                            <div>
                                <a href="{{ route('rents.create') }}" class="btn btn-primary rounded">
                                    <i class="fas fa-plus"></i> Add Rent
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
                                            <th>Tenant Name</th>
                                            <th>Rent For</th>
                                            <th>Rent Amount</th>
                                            <th>Payment Date</th>
                                            <th>Status</th>
                                            <th style="width: 200px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($rents as $key => $rent)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>
                                                    @if ($rent->profile_image)
                                                        <img src="{{ asset($rent->profile_image) }}" alt="Profile" class="rounded-circle" width="40" height="40">
                                                    @else
                                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                            {{ strtoupper(substr($rent->name ?? $user->name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>{{ $rent->name }}</td>
                                                <td>{{ $rent->email }}</td>
                                                <td>
                                                    @if ($rent->phone_number)
                                                        {{ $rent->country_code }} {{ $rent->phone_number }}
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($rent->status)
                                                        <span class="badge badge-success">Active</span>
                                                    @else
                                                        <span class="badge badge-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>{{ $rent->apartment->apartment_number ?? '-'}}</td>

                                                <td>
                                                    <div class="btn-group" role="group">

                                                        <a href="{{ route('rents.edit', $rent->id) }}" class="btn btn-primary btn-sm mr-2" data-toggle="tooltip" title="Edit">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>

                                                        <form action="{{ route('rents.destroy', $rent->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this tenant?')">
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
