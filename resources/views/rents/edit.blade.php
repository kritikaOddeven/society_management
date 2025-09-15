@extends('layouts.app')
@section('pagetitle', 'Edit Rent')
@section('main-content')
    {{-- Main section --}}
    <section class="section">
        <div class="section-header">
            <h1>Edit Rent</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('rents.index') }}">Rents</a></div>
                <div class="breadcrumb-item">Edit Rent</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Rent Entry</h4>
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

                            <form action="{{ route('rents.update', $rent->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tower_id">Select Tower <span class="text-danger">*</span></label>
                                            <select class="form-control @error('tower_id') is-invalid @enderror" id="tower_id" name="tower_id" required>
                                                <option value="">Select Tower</option>
                                                @foreach ($towers as $tower)
                                                    <option value="{{ $tower->id }}" 
                                                        {{ old('tower_id', $rent->tower_id) == $tower->id ? 'selected' : '' }}>
                                                        {{ $tower->tower_name }}
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
                                                id="tenant_name" name="tenant_name" value="{{ old('tenant_name', $rent->tenant_name) }}" required readonly>
                                            @error('tenant_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rent_year">Rent For Year <span class="text-danger">*</span></label>
                                            <select class="form-control @error('rent_year') is-invalid @enderror" id="rent_year" name="rent_year" required>
                                                @foreach ($years as $year)
                                                    <option value="{{ $year }}" {{ old('rent_year', $rent->rent_year) == $year ? 'selected' : '' }}>
                                                        {{ $year }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('rent_year')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rent_month">Rent For Month <span class="text-danger">*</span></label>
                                            <select class="form-control @error('rent_month') is-invalid @enderror" id="rent_month" name="rent_month" required>
                                                @foreach ($months as $month)
                                                    <option value="{{ $month }}" {{ old('rent_month', $rent->rent_month) == $month ? 'selected' : '' }}>
                                                        {{ $month }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('rent_month')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rent_amount">Rent Amount <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" class="form-control @error('rent_amount') is-invalid @enderror" 
                                                id="rent_amount" name="rent_amount" value="{{ old('rent_amount', $rent->rent_amount) }}" required>
                                            @error('rent_amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">Status <span class="text-danger">*</span></label>
                                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                                <option value="Unpaid" {{ old('status', $rent->status) == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                                                <option value="Paid" {{ old('status', $rent->status) == 'Paid' ? 'selected' : '' }}>Paid</option>
                                                <option value="Partial" {{ old('status', $rent->status) == 'Partial' ? 'selected' : '' }}>Partial</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6" id="payment_date_field" style="display: {{ old('status', $rent->status) == 'Paid' ? 'block' : 'none' }};">
                                        <div class="form-group">
                                            <label for="payment_date">Payment Date</label>
                                            <input type="text" class="form-control flatpickr @error('payment_date') is-invalid @enderror" 
                                                id="payment_date" name="payment_date" 
                                                value="{{ old('payment_date', $rent->payment_date) }}" 
                                                placeholder="Select payment date">
                                            @error('payment_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6" id="payment_image_field" style="display: {{ old('status', $rent->status) == 'Paid' ? 'block' : 'none' }};">
                                        <div class="form-group">
                                            <label for="payment_image">Payment Proof (Optional)</label>
                                            <input type="file" class="form-control @error('payment_image') is-invalid @enderror" 
                                                id="payment_image" name="payment_image" accept="image/*">
                                            <small class="form-text text-muted">Upload payment receipt or proof (JPG, PNG, PDF)</small>
                                            @if($rent->payment_image)
                                                <div class="mt-2">
                                                    <small class="text-success">Current file: {{ basename($rent->payment_image) }}</small>
                                                </div>
                                            @endif
                                            @error('payment_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group d-flex justify-content-end">
                                    <a href="{{ route('rents.index') }}" class="btn btn-secondary mr-2">Cancel</a>
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
    const currentRent = @json($rent);

    // Ensure the page is fully loaded
    $(window).on('load', function() {
        // Initialize with current values if tower is already selected
        if (currentRent.tower_id) {
            // Load floors for the selected tower
            const tower = towers.find(t => t.id == currentRent.tower_id);
            if (tower && tower.floors) {
                const floorSelect = $('#floor_id');
                floorSelect.empty().append('<option value="">Select Floor</option>');
                
                tower.floors.forEach(floor => {
                    floorSelect.append(
                        `<option value="${floor.id}">${floor.floor_name}</option>`
                    );
                });
                
                // Set the selected floor
                floorSelect.val(currentRent.floor_id);
                
                // Load apartments for the selected floor
                const floor = tower.floors.find(f => f.id == currentRent.floor_id);
                if (floor && floor.apartments) {
                    const apartmentSelect = $('#apartment_id');
                    apartmentSelect.empty().append('<option value="">Select Apartment</option>');
                    
                    floor.apartments.forEach(apartment => {
                        apartmentSelect.append(`<option value="${apartment.id}" 
                            data-tenant-name="${apartment.tenant ? apartment.tenant.name : ''}"
                            data-rent-amount="${apartment.tenant ? apartment.tenant.rent_amount : ''}">
                            ${apartment.apartment_number}
                        </option>`);
                    });
                    
                    // Set the selected apartment
                    apartmentSelect.val(currentRent.apartment_id);
                }
            }
        }
    });

    $(document).ready(function() {
        
        // Handle tower selection
        $('#tower_id').on('change', function() {
            const towerId = $(this).val();
            loadFloors(towerId);
        });

        // Handle floor selection
        $('#floor_id').on('change', function() {
            const towerId = $('#tower_id').val();
            const floorId = $(this).val();
            loadApartments(towerId, floorId);
        });

        // Handle apartment selection
        $('#apartment_id').on('change', function() {
            const selectedOption = $(this).find(':selected');
            
            if (selectedOption.val()) {
                $('#tenant_name').val(selectedOption.data('tenant-name') || '');
                $('#rent_amount').val(selectedOption.data('rent-amount') || $('#rent_amount').val());
            }
        });

        // Handle status change to show/hide payment fields
        $('#status').on('change', function() {
            const status = $(this).val();
            if (status === 'Paid') {
                $('#payment_date_field').show();
                $('#payment_image_field').show();
            } else {
                $('#payment_date_field').hide();
                $('#payment_image_field').hide();
                $('#payment_date').val('');
                $('#payment_image').val('');
            }
        });
    });

    function loadFloorsAndApartments(towerId, selectedFloorId, selectedApartmentId) {
        const floorSelect = $('#floor_id');
        const apartmentSelect = $('#apartment_id');
        
        // Reset dropdowns
        floorSelect.empty().append('<option value="">Select Floor</option>');
        apartmentSelect.empty().append('<option value="">Select Apartment</option>');
        
        if (towerId) {
            const tower = towers.find(t => t.id == towerId);
            if (tower && tower.floors) {
                // Load floors
                tower.floors.forEach(floor => {
                    // Use == for comparison to handle string/number type differences
                    const selected = selectedFloorId && floor.id == selectedFloorId ? 'selected' : '';
                    floorSelect.append(
                        `<option value="${floor.id}" ${selected}>${floor.floor_name}</option>`
                    );
                });
                
                // Load apartments for selected floor
                if (selectedFloorId) {
                    const floor = tower.floors.find(f => f.id == selectedFloorId);
                    if (floor && floor.apartments) {
                        floor.apartments.forEach(apartment => {
                            // Use == for comparison to handle string/number type differences
                            const selected = selectedApartmentId && apartment.id == selectedApartmentId ? 'selected' : '';
                            const option = `<option value="${apartment.id}" 
                                data-tenant-name="${apartment.tenant ? apartment.tenant.name : ''}"
                                data-rent-amount="${apartment.tenant ? apartment.tenant.rent_amount : ''}"
                                ${selected}>
                                ${apartment.apartment_number}
                            </option>`;
                            apartmentSelect.append(option);
                        });
                    }
                }
            }
        }
    }

    function loadFloors(towerId, selectedFloorId = null) {
        const floorSelect = $('#floor_id');
        const apartmentSelect = $('#apartment_id');
        
        // Reset dropdowns
        floorSelect.empty().append('<option value="">Select Floor</option>');
        apartmentSelect.empty().append('<option value="">Select Apartment</option>');
        
        if (towerId) {
            const tower = towers.find(t => t.id == towerId);
            if (tower && tower.floors) {
                tower.floors.forEach(floor => {
                    const selected = selectedFloorId && floor.id == selectedFloorId ? 'selected' : '';
                    floorSelect.append(
                        `<option value="${floor.id}" ${selected}>${floor.floor_name}</option>`
                    );
                });
                
                // If floor was selected, load apartments
                if (selectedFloorId) {
                    loadApartments(towerId, selectedFloorId, currentRent.apartment_id);
                }
            }
        }
    }

    function loadApartments(towerId, floorId, selectedApartmentId = null) {
        const apartmentSelect = $('#apartment_id');
        
        // Reset apartment dropdown
        apartmentSelect.empty().append('<option value="">Select Apartment</option>');
        
        if (towerId && floorId) {
            const tower = towers.find(t => t.id == towerId);
            if (tower && tower.floors) {
                const floor = tower.floors.find(f => f.id == floorId);
                if (floor && floor.apartments) {
                    floor.apartments.forEach(apartment => {
                        const selected = selectedApartmentId && apartment.id == selectedApartmentId ? 'selected' : '';
                        const option = `<option value="${apartment.id}" 
                            data-tenant-name="${apartment.tenant ? apartment.tenant.name : ''}"
                            data-rent-amount="${apartment.tenant ? apartment.tenant.rent_amount : ''}"
                            ${selected}>
                            ${apartment.apartment_number}
                        </option>`;
                        apartmentSelect.append(option);
                    });
                }
            }
        }
    }
</script>
@endsection
