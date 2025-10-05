@extends('layouts.app')
@section('pagetitle', 'Edit Apartment')
@section('main-content')
    {{-- Main section --}}
    <section class="section">
        <div class="section-header">
            <h1>Edit Apartment</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('apartments.index') }}">Apartment</a></div>
                <div class="breadcrumb-item">Edit Apartment</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Apartment</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('apartments/' . $apartment->id) }}" method="POST" enctype="multipart/form-data" id="editApartmentForm">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tower_id">Select Tower <span class="text-danger">*</span></label>
                                            <select class="form-control @error('tower_id') is-invalid @enderror" id="tower_id" name="tower_id">
                                                <option value="">Select Tower Name</option>
                                                @foreach ($towers as $tower)
                                                    <option value="{{ $tower->id }}" {{ old('tower_id', $apartment->tower_id) == $tower->id ? 'selected' : '' }}>
                                                        {{ $tower->tower_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger tower_id-error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="floor">Select Floor <span class="text-danger">*</span></label>
                                            <select class="form-control @error('floor_id') is-invalid @enderror" id="floor_id" name="floor_id">
                                                <option value="">Select Floor</option>

                                            </select>
                                            <span class="text-danger floor_id-error"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="apartment_number">Apartment Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('apartment_number') is-invalid @enderror" id="apartment_number" name="apartment_number" value="{{ old('apartment_number', $apartment->apartment_number) }}" placeholder="aparmtent">
                                            @error('apartment_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <span class="text-danger apartment_number-error"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="parking">Select Parking Code</label>
                                            <select class="form-control select2 @error('parking_id') is-invalid @enderror" id="parking" name="parking_id[]" multiple>
                                                <option value="">Select Parking Code</option>
                                                @foreach ($parkings as $parking)
                                                    <option value="{{ $parking->id }}" {{ in_array($parking->id, old('id', $selectedParkings ?? [])) ? 'selected' : '' }}>
                                                        {{ ucfirst(str_replace('-', ' ', $parking->parking_code)) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('parking_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <span class="text-danger parking_id-error"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-1 mt-4 p-2">
                                        <div class="form-group">
                                            <button class="btn btn-primary rounded" data-toggle="modal" data-target="#addParkingModal"><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="apartment_area">Apartment Area(sqft) <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('apartment_area') is-invalid @enderror" id="apartment_area" name="apartment_area" value="{{ old('apartment_area', $apartment->apartment_area) }}" placeholder="aparmtent">
                                            @error('apartment_area')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <span class="text-danger apartment_area-error"></span>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="apartment_type">Apartment Type <span class="text-danger">*</span></label>
                                            <select class="form-control @error('apartment_type') is-invalid @enderror" id="apartment_type" name="apartment_type">
                                                <option value="">Select Apartment type</option>
                                                @foreach ($types as $type)
                                                    <option value="{{ $type->id }}" {{ old('apartment_type', $apartment->apartment_type) == $type->id ? 'selected' : '' }}>
                                                        {{ ucfirst(str_replace('-', ' ', $type->apartment_type)) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('apartment_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <span class="text-danger apartment_type-error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">Apartmeent Status</label>
                                            <select class="form-control @error('status') is-invalid @enderror" id="apartment_status" name="status">
                                                <option value="Unsold" {{ old('status', $apartment->status) == 'Unsold' ? 'selected' : '' }}>Unsold</option>
                                                <option value="Occupied" {{ old('status', $apartment->status) == 'Occupied' ? 'selected' : '' }}>Occupied</option>
                                                <option value="Rent" {{ old('status', $apartment->status) == 'Rent' ? 'selected' : '' }}>Avaiable For Rent</option>
                                                <option value="Rent" {{ old('status', $apartment->status) == 'Rented' ? 'selected' : '' }}>On Rent</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <span class="text-danger status-error"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-6" id="owner_div" style="display: none;">
                                        <div class="form-group">
                                            <label for="owner_id">Select Owner <span class="text-danger">*</span></label>
                                            <select class="form-control @error('owner_id') is-invalid @enderror" id="owner_id" name="owner_id">
                                                <option value=""> Select Owner</option>
                                                @foreach ($owners as $owner)
                                                    <option value="{{ $owner->id }}" {{ isset($apartment) && $apartment->owner_id == $owner->id ? 'selected' : '' }}>
                                                        {{ ucfirst(str_replace('-', ' ', $owner->name)) }}
                                                    </option>
                                                @endforeach

                                            </select>
                                            @error('owner_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <span class="text-danger owner_id-error"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group d-flex justify-content-end">
                                    <a href="{{ route('apartments.index') }}" class="btn btn-secondary mr-2">Cancel</a>
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

@section('scripts')
<script>
    $(document).ready(function() {
        // ✅ EDIT APARTMENT AJAX SUBMISSION
        $('#editApartmentForm').on('submit', function(e) {
            e.preventDefault();

            let $form = $(this);
            let $submitBtn = $form.find('button[type="submit"]');
            $submitBtn.prop('disabled', true).text('Updating...');

            $.ajax({
                url: "{{ url('apartments/' . $apartment->id) }}",
                type: 'POST',
                data: $form.serialize() + '&_method=PUT',
                success: function(res) {
                    $form.find('.text-danger').not('.req-star').text('');

                    showSuccessAlert(res.message || 'Apartment updated successfully!', () => {
                        window.location.href = res.redirect || "{{ route('apartments.index') }}";
                    });
                },
                error: function(xhr) {
                    if(xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $form.find('.text-danger').not('.req-star').text('');
                        
                        $.each(errors, function(field, messages) {
                            $form.find('.' + field + '-error').text(messages[0]);
                        });
                    } else {
                        showErrorAlert('Something went wrong. Please try again.');
                    }
                    $submitBtn.prop('disabled', false).text('Save');
                }
            });
        });

        // Owner field visibility toggle
        function toggleOwnerDiv() {
            let status = $('#apartment_status').val();
            if (status === 'Occupied' || status === 'Rent') {
                $('#owner_div').show();
                $('#owner_id').attr('required', true);
            } else {
                $('#owner_div').hide();
                $('#owner_id').attr('required', false);
            }
        }

        // Run on load (important for edit page)
        toggleOwnerDiv();

        // Run on change
        $('#apartment_status').on('change', function() {
            toggleOwnerDiv();
        });

        // Tower and Floor population
        let towers = @json($towers);

        function populateFloors(towerId, selectedFloor = null) {
            $('#floor_id').empty().append('<option value="">Select Floor</option>');

            if (!towerId) return;

            let tower = towers.find(t => t.id == towerId);
            if (tower && tower.floors) {
                tower.floors.forEach(floor => {
                    let selected = (floor.id == selectedFloor) ? 'selected' : '';
                    $('#floor_id').append('<option value="' + floor.id + '" ' + selected + '>' + floor.floor_name + '</option>');
                });
            }
        }

        // On change of tower dropdown
        $('#tower_id').on('change', function() {
            populateFloors($(this).val());
        });

        // Pre-populate for edit or validation error
        let oldTower = "{{ old('tower_id', $apartment->tower_id) }}";
        let oldFloor = "{{ old('floor_id', $apartment->floor_id) }}";

        if (oldTower) {
            populateFloors(oldTower, oldFloor);
            $('#tower_id').val(oldTower);
        }

        // Real-time validation
        $('#editApartmentForm input[name="apartment_number"]').on('blur', function() {
            let $errorSpan = $(this).siblings('.apartment_number-error');
            if($(this).val().trim() === '') {
                $errorSpan.text('Apartment number is required');
            } else if($(this).val().length > 50) {
                $errorSpan.text('Apartment number must not exceed 50 characters');
            } else {
                $errorSpan.text('');
            }
        });

        $('#editApartmentForm input[name="apartment_area"]').on('blur', function() {
            let $errorSpan = $(this).siblings('.apartment_area-error');
            let value = parseFloat($(this).val());
            if($(this).val().trim() === '') {
                $errorSpan.text('Apartment area is required');
            } else if(isNaN(value) || value < 1) {
                $errorSpan.text('Apartment area must be at least 1 sq ft');
            } else if(value > 10000) {
                $errorSpan.text('Apartment area must not exceed 10,000 sq ft');
            } else {
                $errorSpan.text('');
            }
        });

        $('#editApartmentForm select[name="tower_id"]').on('change', function() {
            let $errorSpan = $(this).siblings('.tower_id-error');
            if($(this).val() === '') {
                $errorSpan.text('Tower selection is required');
            } else {
                $errorSpan.text('');
            }
        });

        $('#editApartmentForm select[name="floor_id"]').on('change', function() {
            let $errorSpan = $(this).siblings('.floor_id-error');
            if($(this).val() === '') {
                $errorSpan.text('Floor selection is required');
            } else {
                $errorSpan.text('');
            }
        });

        $('#editApartmentForm select[name="apartment_type"]').on('change', function() {
            let $errorSpan = $(this).siblings('.apartment_type-error');
            if($(this).val() === '') {
                $errorSpan.text('Apartment type selection is required');
            } else {
                $errorSpan.text('');
            }
        });

        // Clear errors on input
        $('#editApartmentForm input').on('input', function() {
            if($(this).val().trim() !== '') {
                $(this).siblings('.text-danger').not('.req-star').text('');
            }
        });

        $('#editApartmentForm select').on('change', function() {
            if($(this).val() !== '') {
                $(this).siblings('.text-danger').not('.req-star').text('');
            }
        });
    });
</script>
@endsection
