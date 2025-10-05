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

                    <style>
                        .services-container {
                            display: flex;
                            gap: 15px;
                            padding: 20px;
                            overflow-x: auto;
                            overflow-y: hidden;
                            white-space: nowrap;
                            background: #fff;
                            border-radius: 8px;
                            margin-bottom: 20px;
                            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                        }

                        .services-container::-webkit-scrollbar {
                            height: 8px;
                        }

                        .services-container::-webkit-scrollbar-track {
                            background: #f1f1f1;
                            border-radius: 10px;
                        }

                        .services-container::-webkit-scrollbar-thumb {
                            background: #888;
                            border-radius: 10px;
                        }

                        .services-container::-webkit-scrollbar-thumb:hover {
                            background: #555;
                        }

                        .service-card {
                            min-width: 100px;
                            padding: 15px 10px;
                            display: flex;
                            flex-direction: column;
                            align-items: center;
                            gap: 8px;
                            cursor: pointer;
                            transition: all 0.3s ease;
                            border-radius: 12px;
                            background: #f8f9fa;
                            border: 2px solid transparent;
                            text-align: center;
                            border: 1px solid #b5b5b5;
                        }

                        .service-card:hover {
                            transform: translateY(-3px);
                            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                        }

                        .service-card.active {
                            background: #6777ef;
                            color: white;
                            border-color: #6777ef;
                        }

                        .service-card.active .service-icon {
                            color: #6777ef !important;
                            background: #fff;
                        }

                        .service-card.active h6 {
                            color: white !important;
                        }

                        .service-icon {
                            font-size: 32px;
                            color: #6c757d;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            width: 50px;
                            height: 50px;
                            background: #e6e6e7;
                            border-radius: 4px;
                        }

                        .service-card h6 {
                            margin: 0;
                            font-size: 12px;
                            font-weight: 500;
                            color: #333;
                            word-wrap: break-word;
                            white-space: normal;
                            max-width: 100px;
                            line-height: 1.2;
                        }

                        @media (max-width: 768px) {
                            .service-card {
                                min-width: 85px;
                                padding: 12px 8px;
                            }

                            .service-icon {
                                font-size: 28px;
                                width: 40px;
                                height: 40px;
                            }

                            .service-card h6 {
                                font-size: 11px;
                            }
                        }
                    </style>

                    <div class="services-container">
                        @foreach ($types as $key => $type)
                            <a style="text-decoration: none;" href="{{ url('services?type=' . $type->id) }}">
                                <div class="service-card {{ Request()->get('type') == $type->id || ($types && $key == 0 && !Request()->get('type')) ? 'active' : '' }}">
                                    <i class="{{ $type->service_icon }} service-icon"></i>
                                    <h6>{{ $type->service_type }}</h6>
                                </div>
                            </a>
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
                                        @forelse($services as $key => $service)
                                            <tr>
                                                <td>{{ ++ $key }}</td>
                                                <td>
                                                    @if($service->photo)
                                                        <img src="{{ $service->photo_url }}" alt="Profile" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                                                    @else
                                                        <div style="width: 30px; height: 30px; border-radius: 50%; background: #6777ef; color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 15px;">
                                                            {{ strtoupper(substr($service->contact_person_name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>{{ $service->contact_person_name }}</td>
                                                <td>
                                                    <span class="badge badge-primary">
                                                        <i class="{{ $service->serviceType->service_icon ?? 'fas fa-wrench' }}"></i>
                                                        {{ $service->serviceType->service_type ?? 'N/A' }}
                                                    </span>
                                                </td>
                                                <td>{{ $service->full_contact_number }}</td>
                                                <td>
                                                    @if($service->status == 'available')
                                                        <span class="badge badge-success">Available</span>
                                                    @else
                                                        <span class="badge badge-danger">Unavailable</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($service->is_daily_help)
                                                        <span class="badge badge-info">Yes</span>
                                                    @else
                                                        <span class="badge badge-secondary">No</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('services.edit', $service->id) }}" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-edit"></i> 
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $service->id }}', '{{ $service->contact_person_name }}')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <form id="delete-form-{{ $service->id }}" action="{{ route('services.destroy', $service->id) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">No services found</td>
                                            </tr>
                                        @endforelse
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

@section('scripts')
<script>
    function confirmDelete(serviceId, serviceName) {
        Swal.fire({
            title: 'Are you sure?',
            text: `You are about to delete the service for ${serviceName}. This action cannot be undone!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Deleting...',
                    text: 'Please wait while we delete the service.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Submit the form
                document.getElementById('delete-form-' + serviceId).submit();
            }
        });
    }
</script>
@endsection
