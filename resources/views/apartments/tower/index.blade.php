@extends('layouts.app')
@section('pagetitle', 'Tower')
@section('main-content')
    {{-- Main section --}}
    <section class="section">
        <div class="section-header">
            <h1>Tower</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Tower</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-md-flex justify-content-between">
                            <h4>Tower List</h4>
                            <div>
                                <button class="btn btn-primary rounded" data-toggle="modal" data-target="#addTowerModal"><i class="fas fa-plus"></i> Add Tower</button>
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
                                            <th>Tower Name</th>
                                            <th>No. of Aparment</th>
                                            <th style="width: 200px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($towers as $key => $tower)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $tower->tower_name }}</td>
                                                <td>{{ $tower->apartment_no ?? '' }}</td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <button class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#editTowerModal{{ $tower->id }}"><i class="fas fa-pencil-alt"></i></button>
                                                        <form action="{{ route('towers.destroy', $tower->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this tower?')">
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
    @include('apartments.tower.create')
    
    @foreach ($towers as $key => $t)
        @include('apartments.tower.edit', ['tower' => $t])
    @endforeach

@endsection
