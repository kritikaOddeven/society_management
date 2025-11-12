@extends('layouts.app')
@section('pagetitle', 'Utility Bill Details')
@section('main-content')
    {{-- Main section --}}
    <section class="section">
        <div class="section-header">
            <h1>Utility Bill Details</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('bills.utility.index') }}">Utility Bills</a></div>
                <div class="breadcrumb-item">View</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Utility Bill Information</h4>
                            <div>
                                <a href="{{ route('bills.utility.edit', $utility) }}" class="btn btn-primary mr-2">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="{{ route('bills.utility.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back to List
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <h6>Apartment</h6>
                                        <p class="mb-1 font-weight-bold">
                                            {{ optional($utility->apartment)->apartment_number ?? 'N/A' }}
                                        </p>
                                        @if ($utility->apartment && ($utility->apartment->tower || $utility->apartment->floor))
                                            <p class="text-muted mb-0">
                                                {{ optional($utility->apartment->floor)->floor_name }}
                                                {{ $utility->apartment->floor && $utility->apartment->tower ? ' - ' : '' }}
                                                {{ optional($utility->apartment->tower)->tower_name }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <h6>Bill Type</h6>
                                        <p class="mb-0 font-weight-bold">{{ optional($utility->billType)->bill_type ?? 'N/A' }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <h6>Bill Amount</h6>
                                        <p class="mb-0 font-weight-bold">Rs. {{ number_format($utility->bill_amount, 2) }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <h6>Payment Mode</h6>
                                        <p class="mb-0 font-weight-bold text-uppercase">{{ $utility->payment_mode }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <h6>Bill Date</h6>
                                        <p class="mb-0 font-weight-bold">{{ optional($utility->bill_date)->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <h6>Bill Due Date</h6>
                                        <p class="mb-0 font-weight-bold">{{ optional($utility->bill_due_date)->format('d M Y') }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <h6>Status</h6>
                                        <span class="badge badge-{{ $utility->status === 'Paid' ? 'success' : 'warning' }}">
                                            {{ $utility->status }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <h6>Bill Proof</h6>
                                        @if ($utility->bill_image)
                                            <a href="{{ asset($utility->bill_image) }}" target="_blank" class="btn btn-info btn-sm">
                                                <i class="fas fa-file-download"></i> View File
                                            </a>
                                        @else
                                            <p class="mb-0">No file uploaded.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <small class="text-muted">
                                Created on {{ optional($utility->created_at)->format('d M Y, h:i A') ?? 'N/A' }}
                            </small>
                            <br>
                            <small class="text-muted">
                                Last updated {{ optional($utility->updated_at)->diffForHumans() ?? 'N/A' }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- End main section --}}
@endsection
