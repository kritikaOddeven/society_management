@extends('layouts.app')
@section('pagetitle', 'Edit Utility Bill')
@section('main-content')
    {{-- Main section --}}
    <section class="section">
        <div class="section-header">
            <h1>Edit Utility Bill</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('bills.utility.index') }}">Utility Bill</a></div>
                <div class="breadcrumb-item">Edit Utility Bill</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Utility Bill</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('bills.utility.update', $utility) }}" method="POST" enctype="multipart/form-data" id="editUtilityForm">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="apartment_id">Apartment Number <span class="text-danger">*</span></label>
                                            <select class="form-control @error('apartment_id') is-invalid @enderror" id="apartment_id" name="apartment_id">
                                                <option selected disabled>Select Apartment Number</option>
                                                @foreach ($apartments as $apartment)
                                                    <option value="{{ $apartment->id }}" {{ old('apartment_id', $utility->apartment_id) == $apartment->id ? 'selected' : '' }}>
                                                        {{ $apartment->apartment_number }} ({{ $apartment->floor->floor_name }} - {{ $apartment->tower->tower_name }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('apartment_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <span class="text-danger apartment_id-error"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="bill_type">Bill Type <span class="text-danger">*</span></label>
                                            <select class="form-control @error('bill_type') is-invalid @enderror" id="bill_type" name="bill_type">
                                                <option value="">Select Bill Type</option>
                                                @foreach ($billTypes as $billType)
                                                    <option value="{{ $billType->id }}" {{ old('bill_type', $utility->bill_type) == $billType->id ? 'selected' : '' }}>
                                                        {{ $billType->bill_type }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('bill_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <span class="text-danger bill_type-error"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="bill_amount">Bill Amount <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('bill_amount') is-invalid @enderror" id="bill_amount" name="bill_amount" value="{{ old('bill_amount', $utility->bill_amount) }}" placeholder="aparmtent">
                                            @error('bill_amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <span class="text-danger bill_amount-error"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="payment_mode">Bill Payment Type <span class="text-danger">*</span></label>
                                            <select class="form-control @error('payment_mode') is-invalid @enderror" id="payment_mode" required name="payment_mode">
                                                <option selected disabled>Select Mode</option>
                                                @php
                                                    $paymentModes = ['neft' => 'NEFT', 'dbf' => 'Direct Bank Transfer', 'cheque' => 'Cheque', 'upi' => 'UPI', 'credit' => 'Credit Card', 'debit' => 'Debit Card', 'cash' => 'Cash'];
                                                @endphp
                                                @foreach ($paymentModes as $value => $label)
                                                    <option value="{{ $value }}" {{ old('payment_mode', $utility->payment_mode) == $value ? 'selected' : '' }}>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                            @error('payment_mode')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <span class="text-danger payment_mode-error"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="bill_date">Bill Date <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control flatpickr @error('bill_date') is-invalid @enderror" id="datepicker" name="bill_date" value="{{ old('bill_date', optional($utility->bill_date)->format('Y-m-d')) }}" placeholder="Bill date">
                                            @error('bill_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <span class="text-danger bill_date-error"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="bill_due_date">Bill Due Date <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control flatpickr @error('bill_due_date') is-invalid @enderror" id="datepicker" name="bill_due_date" value="{{ old('bill_due_date', optional($utility->bill_due_date)->format('Y-m-d')) }}" placeholder="Bill due date">
                                            @error('bill_due_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <span class="text-danger bill_due_date-error"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-6" id="bill_image_field">
                                        <div class="form-group">
                                            <label for="bill_image">Bill Proof (Optional)</label>
                                            <input type="file" class="form-control @error('bill_image') is-invalid @enderror" id="bill_image" name="bill_image" accept="image/*,application/pdf">
                                            <small class="form-text text-muted">Upload bill receipt or proof (JPG, PNG, PDF)</small>
                                            @if ($utility->bill_image)
                                                <div class="mt-2">
                                                    <a href="{{ asset($utility->bill_image) }}" target="_blank" class="btn btn-sm btn-info">
                                                        <i class="fas fa-file-download"></i> View Existing File
                                                    </a>
                                                </div>
                                            @endif
                                            @error('bill_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="bill_status">Status</label>
                                            <select class="form-control @error('status') is-invalid @enderror" id="bill_status" name="status">
                                                <option value="Unpaid" {{ old('status', $utility->status) == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                                                <option value="Paid" {{ old('status', $utility->status) == 'Paid' ? 'selected' : '' }}>Paid</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <span class="text-danger status-error"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group d-flex justify-content-end">
                                    <a href="{{ route('bills.utility.index') }}" class="btn btn-secondary mr-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- End main section --}}

@endsection
