@extends('layouts.app')
@section('pagetitle', 'Add Owner')
@section('main-content')
    {{-- Main section --}}
    <section class="section">
        <div class="section-header">
            <h1>Add Owner</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('owners.index') }}">Owners</a></div>
                <div class="breadcrumb-item">Add Owner</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Add Owner</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('owners.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email Address </label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" >
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="country_code">Country Code</label>
                                            <select class="form-control @error('country_code') is-invalid @enderror" id="country_code" name="country_code">
                                                <option value="+91" {{ old('country_code') == '+91' ? 'selected' : '' }}>+91 </option>
                                                <option value="+93" {{ old('country_code') == '+93' ? 'selected' : '' }}>+93</option>
                                                <option value="+1" {{ old('country_code') == '+1' ? 'selected' : '' }}>+1</option>
                                                <option value="+44" {{ old('country_code') == '+44' ? 'selected' : '' }}>+44</option>
                                                <option value="+86" {{ old('country_code') == '+86' ? 'selected' : '' }}>+86 </option>
                                                <option value="+81" {{ old('country_code') == '+81' ? 'selected' : '' }}>+81</option>
                                                <option value="+49" {{ old('country_code') == '+49' ? 'selected' : '' }}>+49 </option>
                                                <option value="+33" {{ old('country_code') == '+33' ? 'selected' : '' }}>+33 </option>
                                                <option value="+39" {{ old('country_code') == '+39' ? 'selected' : '' }}>+39 </option>
                                                <option value="+34" {{ old('country_code') == '+34' ? 'selected' : '' }}>+34 </option>
                                            </select>
                                            @error('country_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="phone_number">Phone Number<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" placeholder="Phone">
                                            @error('phone_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="profile_image">Profile Image</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input @error('profile_image') is-invalid @enderror" id="profile_image" name="profile_image" accept="image/*">
                                                <label class="custom-file-label" for="profile_image">Choose file</label>
                                            </div>
                                            @error('profile_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tower_id">Select Tower</label>
                                            <select class="form-control @error('tower_id') is-invalid @enderror" id="tower_id" name="tower_id">
                                                <option value="">Select Tower Name</option>
                                                @foreach ($towers as $tower)
                                                    <option value="{{ $tower->id }}" {{ old('tower_id') == $tower->id ? 'selected' : '' }}>
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
    let towers = @json($towers);

    // console.log(towers);
    // Populate Floors based on Tower
    $(document).ready(function() {
        $('#tower_id').on('change', function() {
            let towerId = $(this).val();
            console.log("Selected Tower ID:", towerId);

            $('#floor_id').empty().append('<option value="">Select Floor</option>');
            $('#apartment_id').empty().append('<option value="">Select Apartment</option>');

            if (towerId) {
                let selectedTower = towers.find(t => t.id == towerId);
                // console.log("Selected Tower:", selectedTower);

                if (selectedTower && selectedTower.floors) {
                    selectedTower.floors.forEach(floor => {
                        $('#floor_id').append(
                            `<option value="${floor.id}">${floor.floor_name}</option>`
                        );
                    });
                }
            }
        });
    });

    // Populate Apartments based on Floor
    $(document).ready(function() {
        $('#floor_id').on('change', function() {
            let towerId = $('#tower_id').val();
            let floorId = $(this).val();

            console.log("Floor ID:", floorId);

            $('#apartment_id').empty().append('<option value="">Select Apartment</option>');

            if (towerId && floorId) {
                let selectedTower = towers.find(t => t.id == towerId);
                if (selectedTower && selectedTower.floors) {
                    let selectedFloor = selectedTower.floors.find(f => f.id == floorId);
                    if (selectedFloor && selectedFloor.apartments) {
                        selectedFloor.apartments.forEach(apartment => {
                            $('#apartment_id').append(
                                `<option value="${apartment.id}">${apartment.apartment_number}</option>`
                            );
                        });
                    }
                }
            }
        });
    });
</script>


@push('scripts')
    <script>
        // Update file input label when file is selected
        document.getElementById('profile_image').addEventListener('change', function(e) {
            var fileName = e.target.files[0] ? e.target.files[0].name : 'Choose file';
            e.target.nextElementSibling.textContent = fileName;
        });
    </script>
@endpush
