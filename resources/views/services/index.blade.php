@extends('layouts.app')
@section('pagetitle', 'Service')
@section('main-content')
    {{-- Main section --}}
    <section class="section">
        <div class="section-header">
            <h1>Services </h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ url('/') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Services</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-md-flex justify-content-between">
                            <h4>Service Lists</h4>
                            <div>
                                <a href="{{ route('services.create') }}" class="btn btn-primary rounded">
                                    <i class="fas fa-plus"></i> Add Services
                                </a>
                            </div>
                        </div>

                    </div>
                    {{-- <style>
                        .card-md-icons {
                            background-color: blue;
                            padding: 5px 10px;
                            color: white;
                        }

                        .card-icon {
                            background-color: white;
                            color: black;
                            width: 25px;
                            height: 25px;
                            text-align: center;
                            vertical-align: middle;
                            margin-bottom: 10px
                        }
                    </style> --}}
                    <style>
                        .service-card {
                            border: none;
                            background: #fff;
                            text-align: center;
                            padding: 10px 15px;
                            border-radius: 15px;
                            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
                            cursor: pointer;
                        }

                        .service-card:hover {
                            background-color: #f8f9fa;
                            transform: translateY(-5px);
                            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
                        }

                        .service-card.active {
                            background-color: #359cdc;
                            color: #fff;
                        }

                        .service-card.active i {
                            color: #fff;
                        }

                        .service-icon {
                            font-size: 20px;
                            margin-bottom: 10px;
                            color: #6c757d;
                        }

                        .service-card h6 {
                            margin: 0;
                            font-size: 14px;
                            font-weight: 600;
                        }

                        .services-container {
                            display: flex;
                            flex-wrap: wrap;
                            gap: 15px;
                        }

                        .services-container .service-card {
                            flex: 0 0 calc(30px - 35px);
                        }
                    </style>

                    <div class="services-container pb-4">
                        @foreach ($types as $type)
                            <div class="service-card active">
                                <i class="{{ $type->service_icon }} service-icon"></i>
                                <h6>{{ $type->service_type }}</h6>
                            </div>
                        @endforeach

                    </div>

                    <div class="card">
                        <div class="card-body">
                            <x-alert />
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Profile</th>
                                            <th>Contact Person</th>
                                            <th>Service</th>
                                            <th>Contact Number</th>
                                            <th>Status</th>
                                            <th>Daily Help Availability</th>
                                            <th style="width: 200px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

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
