@extends('layouts.app')
@section('pagetitle', 'Edit Owner')
@section('main-content')
    <section class="section">
        <div class="section-header">
            <h1>Edit Owner</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('owners.index') }}">Owners</a></div>
                <div class="breadcrumb-item">Edit Owner</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Owner</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('owners/'. $owner->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $owner->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email Address</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $owner->email) }}">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="country_code"></label>
                                            <select class="form-control @error('country_code') is-invalid @enderror" id="country_code" name="country_code">
                                                @foreach (['+91', '+93', '+1', '+44', '+86', '+81', '+49', '+33', '+39', '+34'] as $code)
                                                    <option value="{{ $code }}" {{ old('country_code', $owner->country_code) == $code ? 'selected' : '' }}>{{ $code }}</option>
                                                @endforeach
                                            </select>
                                            @error('country_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="phone_number">Phone Number<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number', $owner->phone_number) }}" placeholder="Phone">
                                            @error('phone_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="profile_image">Profile Image</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input @error('profile_image') is-invalid @enderror" id="profile_image" name="profile_image" accept="image/*">
                                                <label class="custom-file-label" for="profile_image">
                                                    {{ $owner->profile_image ? $owner->profile_image : 'Choose file' }}
                                                </label>
                                            </div>
                                            @error('profile_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        @if ($owner->profile_image)
                                                <img src="{{ asset($owner->profile_image) }}" alt="Profile Image" class="img-thumbnail mt-2" width="100">
                                            @endif
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tower_id">Select Tower</label>
                                            <select class="form-control @error('tower_id') is-invalid @enderror" id="tower_id" name="tower_id">
                                                <option value="">Select Tower Name</option>
                                                @foreach ($towers as $tower)
                                                    <option value="{{ $tower->id }}" {{ old('tower_id', $owner->tower_id) == $tower->id ? 'selected' : '' }}>
                                                        {{ ucfirst(str_replace('-', ' ', $tower->tower_name)) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="floor_id">Select Floor</label>
                                            <select class="form-control @error('floor_id') is-invalid @enderror" id="floor_id" name="floor_id">
                                                <option value="">Select Floor</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="apartment_id">Select Apartment</label>
                                            <select class="form-control @error('apartment_id') is-invalid @enderror" id="apartment_id" name="apartment_id">
                                                <option value="">Select Apartment</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group d-flex justify-content-end">
                                    <a href="{{ route('owners.index') }}" class="btn btn-secondary mr-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        let towers = @json($towers);
        let selectedFloorId = {{ old('floor_id', $owner->floor_id ?? 'null') }};
        let selectedApartmentId = {{ old('apartment_id', $owner->apartment_id ?? 'null') }};

        $(document).ready(function() {
            function populateFloors(towerId, floorId = null) {
                $('#floor_id').empty().append('<option value="">Select Floor</option>');
                $('#apartment_id').empty().append('<option value="">Select Apartment</option>');

                if (towerId) {
                    let selectedTower = towers.find(t => t.id == towerId);
                    if (selectedTower && selectedTower.floors) {
                        selectedTower.floors.forEach(floor => {
                            let selected = floorId == floor.id ? 'selected' : '';
                            $('#floor_id').append(`<option value="${floor.id}" ${selected}>${floor.floor_name}</option>`);
                        });
                    }
                }
            }

            function populateApartments(towerId, floorId, apartmentId = null) {
                $('#apartment_id').empty().append('<option value="">Select Apartment</option>');
                if (towerId && floorId) {
                    let selectedTower = towers.find(t => t.id == towerId);
                    if (selectedTower && selectedTower.floors) {
                        let selectedFloor = selectedTower.floors.find(f => f.id == floorId);
                        if (selectedFloor && selectedFloor.apartments) {
                            selectedFloor.apartments.forEach(apartment => {
                                let selected = apartmentId == apartment.id ? 'selected' : '';
                                $('#apartment_id').append(`<option value="${apartment.id}" ${selected}>${apartment.apartment_number}</option>`);
                            });
                        }
                    }
                }
            }

            // Populate on tower change
            $('#tower_id').on('change', function() {
                populateFloors($(this).val());
            });

            // Populate on floor change
            $('#floor_id').on('change', function() {
                populateApartments($('#tower_id').val(), $(this).val());
            });

            // Prepopulate on page load for edit
            if ($('#tower_id').val()) {
                populateFloors($('#tower_id').val(), selectedFloorId);
                if (selectedFloorId) {
                    populateApartments($('#tower_id').val(), selectedFloorId, selectedApartmentId);
                }
            }
        });

        // File input label
        document.getElementById('profile_image').addEventListener('change', function(e) {
            var fileName = e.target.files[0] ? e.target.files[0].name : 'Choose file';
            e.target.nextElementSibling.textContent = fileName;
        });
    </script>
@endsection
