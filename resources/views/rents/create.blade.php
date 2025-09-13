@extends('layouts.app')
@section('pagetitle', 'Add Rent')
@section('main-content')
    {{-- Main section --}}
    <section class="section">
        <div class="section-header">
            <h1>Add Rent</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('rents.index') }}">Rents</a></div>
                <div class="breadcrumb-item">Add Rent</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Add Rent Entry for {{ $currentMonth }} {{ $currentYear }}</h4>
                        </div>
                        <div class="card-body">
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

                            <form action="{{ route('rents.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tower_id">Select Tower <span class="text-danger">*</span></label>
                                            <select class="form-control @error('tower_id') is-invalid @enderror" id="tower_id" name="tower_id" required>
                                                <option value="">Select Tower</option>
                                                @foreach ($towers as $tower)
                                                    <option value="{{ $tower->id }}" {{ old('tower_id') == $tower->id ? 'selected' : '' }}>
                                                        {{ $tower->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('tower_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="floor_id">Select Floor <span class="text-danger">*</span></label>
                                            <select class="form-control @error('floor_id') is-invalid @enderror" id="floor_id" name="floor_id" required>
                                                <option value="">Select Floor</option>
                                            </select>
                                            @error('floor_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="apartment_id">Apartment Number <span class="text-danger">*</span></label>
                                            <select class="form-control @error('apartment_id') is-invalid @enderror" id="apartment_id" name="apartment_id" required>
                                                <option value="">Select Apartment</option>
                                            </select>
                                            @error('apartment_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tenant_name">Tenant Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('tenant_name') is-invalid @enderror" 
                                                id="tenant_name" name="tenant_name" value="{{ old('tenant_name') }}" required readonly>
                                            @error('tenant_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rent_amount">Rent Amount <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" class="form-control @error('rent_amount') is-invalid @enderror" 
                                                id="rent_amount" name="rent_amount" value="{{ old('rent_amount') }}" required>
                                            @error('rent_amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">Status <span class="text-danger">*</span></label>
                                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                                <option value="Unpaid" {{ old('status') == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                                                <option value="Paid" {{ old('status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                                                <option value="Partial" {{ old('status') == 'Partial' ? 'selected' : '' }}>Partial</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="payment_date">Payment Date</label>
                                            <input type="text" class="form-control flatpickr @error('payment_date') is-invalid @enderror" 
                                                id="payment_date" name="payment_date" value="{{ old('payment_date') }}" placeholder="Select payment date">
                                            @error('payment_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="notes">Notes</label>
                                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                                id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                                            @error('notes')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group d-flex justify-content-end">
                                    <a href="{{ route('rents.index') }}" class="btn btn-secondary mr-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Save</button>
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

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Initialize Flatpickr for payment date
    flatpickr('#payment_date', {
        dateFormat: 'Y-m-d',
        altInput: true,
        altFormat: 'F j, Y',
        maxDate: 'today'
    });

    // Tower data with floors and apartments
    const towers = @json($towers);

    $(document).ready(function() {
        // Handle tower selection
        $('#tower_id').on('change', function() {
            const towerId = $(this).val();
            
            // Reset floor and apartment dropdowns
            $('#floor_id').empty().append('<option value="">Select Floor</option>');
            $('#apartment_id').empty().append('<option value="">Select Apartment</option>');
            $('#tenant_name').val('');
            $('#rent_amount').val('');
            
            if (towerId) {
                const tower = towers.find(t => t.id == towerId);
                if (tower && tower.floors) {
                    tower.floors.forEach(floor => {
                        $('#floor_id').append(
                            `<option value="${floor.id}">${floor.name}</option>`
                        );
                    });
                }
            }
        });

        // Handle floor selection
        $('#floor_id').on('change', function() {
            const towerId = $('#tower_id').val();
            const floorId = $(this).val();
            
            // Reset apartment dropdown
            $('#apartment_id').empty().append('<option value="">Select Apartment</option>');
            $('#tenant_name').val('');
            $('#rent_amount').val('');
            
            if (towerId && floorId) {
                const tower = towers.find(t => t.id == towerId);
                if (tower && tower.floors) {
                    const floor = tower.floors.find(f => f.id == floorId);
                    if (floor && floor.apartments) {
                        floor.apartments.forEach(apartment => {
                            const option = `<option value="${apartment.id}" 
                                data-tenant-name="${apartment.tenant ? apartment.tenant.name : ''}"
                                data-rent-amount="${apartment.tenant ? apartment.tenant.rent_amount : ''}">
                                ${apartment.apartment_number}
                            </option>`;
                            $('#apartment_id').append(option);
                        });
                    }
                }
            }
        });

        // Handle apartment selection
        $('#apartment_id').on('change', function() {
            const selectedOption = $(this).find(':selected');
            
            if (selectedOption.val()) {
                $('#tenant_name').val(selectedOption.data('tenant-name') || '');
                $('#rent_amount').val(selectedOption.data('rent-amount') || '');
            } else {
                $('#tenant_name').val('');
                $('#rent_amount').val('');
            }
        });
    });
</script>
@endpush