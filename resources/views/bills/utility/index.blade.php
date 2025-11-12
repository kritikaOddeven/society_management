@extends('layouts.app')
@section('pagetitle', 'Utility Bills')
@section('main-content')
    {{-- Main section --}}
    <section class="section">
        <div class="section-header">
            <h1>Utility Bills</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Utility Bills</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-md-flex justify-content-between">
                            <h4>Utility Bill Lists</h4>
                            <a href="{{ route('bills.utility.create') }}" class="btn btn-primary rounded">
                                <i class="fas fa-plus"></i> Add Utility Bill
                            </a>
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
                                            <th>Bill Type</th>
                                            <th>Bill Date</th>
                                            <th>Bill Amount</th>
                                            <th>Status</th>
                                            <th>Bill Payment Date</th>
                                            <th style="width: 200px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($utilityBills as $utilityBill)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    {{ optional($utilityBill->apartment)->apartment_number }}
                                                    @if ($utilityBill->apartment && ($utilityBill->apartment->floor || $utilityBill->apartment->tower))
                                                        <br>
                                                        <small class="text-muted">
                                                            {{ optional($utilityBill->apartment->floor)->floor_name }}
                                                            {{ $utilityBill->apartment->floor && $utilityBill->apartment->tower ? ' - ' : '' }}
                                                            {{ optional($utilityBill->apartment->tower)->tower_name }}
                                                        </small>
                                                    @endif
                                                </td>
                                                <td>{{ optional($utilityBill->billType)->bill_type }}</td>
                                                <td>{{ optional($utilityBill->bill_date)->format('d M Y') }}</td>
                                                <td>{{ number_format($utilityBill->bill_amount, 2) }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $utilityBill->status === 'Paid' ? 'success' : 'warning' }}">
                                                        {{ $utilityBill->status }}
                                                    </span>
                                                </td>
                                                <td>{{ optional($utilityBill->bill_due_date)->format('d M Y') }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('bills.utility.show', $utilityBill) }}" class="btn btn-sm btn-info mr-2">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('bills.utility.edit', $utilityBill) }}" class="btn btn-sm btn-primary mr-2">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        @if ($utilityBill->bill_image)
                                                            <a href="{{ asset($utilityBill->bill_image) }}" target="_blank" class="btn btn-sm btn-secondary">
                                                                <i class="fas fa-file-download"></i>
                                                            </a>
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

@endsection
