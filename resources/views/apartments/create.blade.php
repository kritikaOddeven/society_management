@extends('layouts.app')
@section('pagetitle', 'Add Apartment')
@section('main-content')
    {{-- Main section --}}
    <section class="section">
        <div class="section-header">
            <h1>Add Apartment</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('apartments.index') }}">Apartment</a></div>
                <div class="breadcrumb-item">Add Apartment</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Add Apartment</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('apartments.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tower_id">Select Tower <span class="text-danger">*</span></label>
                                            <select class="form-control @error('tower_id') is-invalid @enderror" id="tower_id" name="tower_id" required>
                                                <option value="">Select Tower</option>
                                                @foreach ($towers as $tower)
                                                    <option value="{{ $tower->id }}" {{ old('tower_id') == $tower->id ? 'selected' : '' }}>
                                                        {{ ucfirst(str_replace('-', ' ', $tower->tower_name)) }}
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
                                            <label for="aparmtent_number">Apartment Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('aparmtent_number') is-invalid @enderror" id="aparmtent_number" name="aparmtent_number" value="{{ old('aparmtent_number') }}" placeholder="aparmtent">
                                            @error('aparmtent_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="parking">Select Parking Code</label>
                                            <select class="form-control @error('parking') is-invalid @enderror" id="parking" name="parking_code" required>
                                                <option value="">Select Parking Code</option>
                                                {{-- @foreach ($parkings as $parking)
                                                    <option value="{{ $parking->parking_code }}" {{ old('parking_code') == $parking->parking_code ? 'selected' : '' }}>
                                                        {{ ucfirst(str_replace('-', ' ', $parking->parking_code)) }}
                                                    </option>
                                                @endforeach --}}
                                            </select>
                                            @error('parking_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-1 mt-4 p-2">
                                        <div class="form-group">
                                            <button class="btn btn-primary rounded" data-toggle="modal" data-target="#addParkingModal"><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="aparmtent_area">Apartment Area(sqft) <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('aparmtent_area') is-invalid @enderror" id="aparmtent_area" name="aparmtent_area" value="{{ old('aparmtent_area') }}" placeholder="aparmtent">
                                            @error('aparmtent_area')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="apartment_type">Apartment Type <span class="text-danger">*</span></label>
                                            <select class="form-control @error('apartment_type') is-invalid @enderror" id="apartment_type" name="apartment_type" required>
                                                <option value="">Select Apartment type</option>
                                                @foreach ($types as $type)
                                                    <option value="{{ $type->apartment_type }}" {{ old('apartment_type') == $type->apartment_type ? 'selected' : '' }}>
                                                        {{ ucfirst(str_replace('-', ' ', $type->apartment_type)) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('apartment_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="apartment_status">Status</label>
                                            <select class="form-control @error('apartment_status') is-invalid @enderror" id="apartment_status" name="apartment_status">
                                                <option value=""> Select Apartment Status</option>
                                                <option value="unsold" {{ old('apartment_status') == 'unsold' ? 'selected' : '' }}>Unsold</option>
                                                <option value="occupied" {{ old('apartment_status') == 'occupied' ? 'selected' : '' }}>Occupied</option>
                                                <option value="rent" {{ old('apartment_status') == 'rent' ? 'selected' : '' }}>Avaiable For Rent</option>
                                            </select>
                                            @error('apartment_status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6" id="owner_div" style="display: none;">
                                        <div class="form-group">
                                            <label for="owner_name">Select Owner <span class="text-danger">*</span></label>
                                            <select class="form-control @error('owner_name') is-invalid @enderror" id="owner_name" name="owner_name" required>
                                                <option value=""> Select Owner</option>
                                                {{-- @foreach ($owners as $owner)
                                                    <option value="{{ $owner->owner_name }}" {{ old('owner_name') == $owner->owner_name ? 'selected' : '' }}>
                                                        {{ ucfirst(str_replace('-', ' ', $owner->owner_name)) }}
                                                    </option>
                                                @endforeach --}}
                                            </select>
                                            @error('owner_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group d-flex justify-content-end">
                                    <a href="{{ route('users.index') }}" class="btn btn-secondary mr-2">Cancel</a>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function toggleOwnerDiv() {
            let status = $('#apartment_status').val();
            if (status === 'occupied' || status === 'rent') {
                $('#owner_div').show();
                $('#owner_name').attr('required', true); // make owner required
            } else {
                $('#owner_div').hide();
                $('#owner_name').attr('required', false); // remove required
            }
        }

        // Run on load (in case of old values)
        toggleOwnerDiv();

        // Run on change
        $('#apartment_status').on('change', function() {
            toggleOwnerDiv();
        });
    });


    let towers = @json($towers);

    function populateFloors(towerId) {
        $('#floor_id').empty().append('<option value="">Select Floor</option>');

        if (!towerId) return;

        let tower = towers.find(t => t.id == towerId);
        if (tower && tower.floors) {
            tower.floors.forEach(floor => {
                $('#floor_id').append('<option value="' + floor.id + '">' + floor.floor_name + '</option>');
            });
        }
    }

    $(document).ready(function() {
        // On change of tower dropdown
        $('#tower_id').on('change', function() {
            populateFloors($(this).val());
        });

        // Pre-populate if old values exist (validation error case)
        let oldTower = "{{ old('tower_id') }}";
        let oldFloor = "{{ old('floor_id') }}";

        if (oldTower) {
            populateFloors(oldTower);
            $('#floor_id').val(oldFloor);
        }
    });
</script>
