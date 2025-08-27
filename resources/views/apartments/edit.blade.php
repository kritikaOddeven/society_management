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
                            <form action="{{ url('apartments/' . $apartment->id) }}" method="POST" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tower_id">Select Tower <span class="text-danger">*</span></label>
                                            <select class="form-control @error('tower_id') is-invalid @enderror" id="tower_id" name="tower_id" required>
                                                <option value="">Select Tower Name</option>
                                                @foreach ($towers as $tower)
                                                    <option value="{{ $tower->id }}" {{ old('tower_id', $apartment->tower_id) == $tower->id ? 'selected' : '' }}>
                                                        {{ $tower->tower_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="floor">Select Floor <span class="text-danger">*</span></label>
                                            <select class="form-control @error('floor_id') is-invalid @enderror" id="floor_id" name="floor_id" required>
                                                <option value="">Select Floor</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="apartment_number">Apartment Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('apartment_number') is-invalid @enderror" id="apartment_number" name="apartment_number" value="{{ old('apartment_number', $apartment->apartment_number) }}" placeholder="aparmtent">
                                            @error('apartment_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
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
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="apartment_type">Apartment Type <span class="text-danger">*</span></label>
                                            <select class="form-control @error('apartment_type') is-invalid @enderror" id="apartment_type" name="apartment_type" required>
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
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">Apartmeent Status</label>
                                            <select class="form-control @error('status') is-invalid @enderror" id="apartment_status" name="status">
                                                <option value="Unsold" {{ old('status', $apartment->status) == 'Unsold' ? 'selected' : '' }}>Unsold</option>
                                                <option value="Occupied" {{ old('status', $apartment->status) == 'Occupied' ? 'selected' : '' }}>Occupied</option>
                                                <option value="Rent" {{ old('status', $apartment->status) == 'Rent' ? 'selected' : '' }}>Avaiable For Rent</option>
                                                <option value="Rent" {{ old('status', $apartment->status) == 'Rented' ? 'selected' : '' }}>Rented</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6" id="owner_div" style="display: none;">
                                        <div class="form-group">
                                            <label for="owner_id">Select Owner <span class="text-danger">*</span></label>
                                            <select class="form-control @error('owner_id') is-invalid @enderror" id="owner_id" name="owner_id" required>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function toggleOwnerDiv() {
            let status = $('#apartment_status').val(); // get current apartment status
            if (status === 'Occupied' || status === 'Rent') {
                $('#owner_div').show(); // show owner div
                $('#owner_name').attr('required', true); // make owner required
            } else {
                $('#owner_div').hide(); // hide owner div
                $('#owner_name').attr('required', false); // remove required
            }
        }

        // Run on load (important for edit page)
        toggleOwnerDiv();

        // Run on change
        $('#apartment_status').on('change', function() {
            toggleOwnerDiv();
        });
    });



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

    $(document).ready(function() {
        // On change of tower dropdown
        $('#tower_id').on('change', function() {
            populateFloors($(this).val());
        });

        // Pre-populate for edit or validation error
        let oldTower = "{{ old('tower_id', $apartment->tower_id) }}";
        let oldFloor = "{{ old('floor_id', $apartment->floor_id) }}";

        if (oldTower) {
            populateFloors(oldTower, oldFloor);
            $('#tower_id').val(oldTower); // ensure tower is selected
        }
    });
</script>
