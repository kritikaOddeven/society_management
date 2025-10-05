@extends('layouts.app')
@section('pagetitle', 'Edit Service')
@section('main-content')
    <section class="section">
        <div class="section-header">
            <h1>Edit Service</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ url('/') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('services.index') }}">Services</a></div>
                <div class="breadcrumb-item">Edit Service</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <form method="POST" action="{{ route('services.update', $service->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Service Type <span class="text-danger">*</span></label>
                                    <select name="service_type_id" class="form-control @error('service_type_id') is-invalid @enderror" required>
                                        <option value="">Select Service Type</option>
                                        @foreach($types as $type)
                                            <option value="{{ $type->id }}" {{ old('service_type_id', $service->service_type_id) == $type->id ? 'selected' : '' }}>
                                                {{ $type->service_type }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('service_type_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="is_daily_help" class="custom-control-input" id="is_daily_help" {{ old('is_daily_help', $service->is_daily_help) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_daily_help">Is he/she will be a daily help?</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Select Tower</label>
                                            <select name="tower_id" id="tower_id" class="form-control @error('tower_id') is-invalid @enderror">
                                                <option value="">Select Tower</option>
                                                @foreach($towers as $tower)
                                                    <option value="{{ $tower->id }}" {{ old('tower_id', $service->tower_id) == $tower->id ? 'selected' : '' }}>
                                                        {{ $tower->tower_name ?? $tower->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('tower_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Select Floor</label>
                                            <select name="floor_id" id="floor_id" class="form-control @error('floor_id') is-invalid @enderror">
                                                <option value="">Select Floor</option>
                                                @foreach($floors as $floor)
                                                    <option value="{{ $floor->id }}" {{ old('floor_id', $service->floor_id) == $floor->id ? 'selected' : '' }}>
                                                        {{ $floor->floor_name ?? $floor->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('floor_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Select Apartment</label>
                                            <select name="apartment_id" id="apartment_id" class="form-control @error('apartment_id') is-invalid @enderror">
                                                <option value="">Select Apartment</option>
                                                @foreach($apartments as $apartment)
                                                    <option value="{{ $apartment->id }}" {{ old('apartment_id', $service->apartment_id) == $apartment->id ? 'selected' : '' }}>
                                                        {{ $apartment->apartment_number }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('apartment_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Contact person name <span class="text-danger">*</span></label>
                                    <input type="text" name="contact_person_name" class="form-control @error('contact_person_name') is-invalid @enderror" value="{{ old('contact_person_name', $service->contact_person_name) }}" required>
                                    @error('contact_person_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Contact Number <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <select name="country_code" class="form-control" style="max-width: 150px;">
                                                @foreach($countryCodes as $code => $label)
                                                    <option value="{{ $code }}" {{ old('country_code', $service->country_code) == $code ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <input type="text" name="contact_number" class="form-control @error('contact_number') is-invalid @enderror" value="{{ old('contact_number', $service->contact_number) }}" required>
                                    </div>
                                    @error('contact_number')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Company Name</label>
                                            <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name', $service->company_name) }}">
                                            @error('company_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Website Link</label>
                                            <input type="url" name="website_link" class="form-control @error('website_link') is-invalid @enderror" value="{{ old('website_link', $service->website_link) }}" placeholder="https://example.com">
                                            @error('website_link')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $service->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                        <option value="available" {{ old('status', $service->status) == 'available' ? 'selected' : '' }}>Available</option>
                                        <option value="unavailable" {{ old('status', $service->status) == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Upload Photo</label>
                                    @if($service->photo)
                                        <div class="mb-2">
                                            <img src="{{ $service->photo_url }}" alt="Current photo" style="max-width: 200px; height: auto;" class="img-thumbnail">
                                        </div>
                                    @endif
                                    <div class="custom-file">
                                        <input type="file" name="photo" class="custom-file-input @error('photo') is-invalid @enderror" id="photo" accept="image/*">
                                        <label class="custom-file-label" for="photo">Choose new file</label>
                                    </div>
                                    @error('photo')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Accepted formats: JPEG, PNG, JPG, GIF. Max size: 2MB</small>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('services.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        let towers = @json($towers);
        
        // Update file input label when file is selected
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });

        // Load floors when tower is selected
        $('#tower_id').on('change', function() {
            let towerId = $(this).val();
            let currentFloorId = "{{ $service->floor_id }}";
            
            $('#floor_id').empty().append('<option value="">Select Floor</option>');
            $('#apartment_id').empty().append('<option value="">Select Apartment</option>');
            
            if(towerId) {
                let selectedTower = towers.find(t => t.id == towerId);
                if (selectedTower && selectedTower.floors) {
                    selectedTower.floors.forEach(floor => {
                        let selected = floor.id == currentFloorId ? 'selected' : '';
                        $('#floor_id').append(`<option value="${floor.id}" ${selected}>${floor.floor_name || floor.name}</option>`);
                    });
                }
            }
        });

        // Load apartments when floor is selected
        $('#floor_id').on('change', function() {
            let towerId = $('#tower_id').val();
            let floorId = $(this).val();
            let currentApartmentId = "{{ $service->apartment_id }}";
            
            $('#apartment_id').empty().append('<option value="">Select Apartment</option>');
            
            if(towerId && floorId) {
                let selectedTower = towers.find(t => t.id == towerId);
                if (selectedTower && selectedTower.floors) {
                    let selectedFloor = selectedTower.floors.find(f => f.id == floorId);
                    if (selectedFloor && selectedFloor.apartments) {
                        selectedFloor.apartments.forEach(apartment => {
                            let selected = apartment.id == currentApartmentId ? 'selected' : '';
                            $('#apartment_id').append(`<option value="${apartment.id}" ${selected}>${apartment.apartment_number}</option>`);
                        });
                    }
                }
            }
        });
    });
    </script>
@endsection