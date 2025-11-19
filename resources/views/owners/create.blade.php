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
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email Address </label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone_number">Phone Number <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <select class="form-control col-md-2 @error('country_code') is-invalid @enderror" id="country_code" name="country_code">
                                                    <option value="+91" {{ old('country_code') == '+91' ? 'selected' : '' }}>+91</option>
                                                    <option value="+93" {{ old('country_code') == '+93' ? 'selected' : '' }}>+93</option>
                                                    <option value="+1"  {{ old('country_code') == '+1'  ? 'selected' : '' }}>+1</option>
                                                    <option value="+44" {{ old('country_code') == '+44' ? 'selected' : '' }}>+44</option>
                                                    <option value="+86" {{ old('country_code') == '+86' ? 'selected' : '' }}>+86</option>
                                                    <option value="+81" {{ old('country_code') == '+81' ? 'selected' : '' }}>+81</option>
                                                    <option value="+49" {{ old('country_code') == '+49' ? 'selected' : '' }}>+49</option>
                                                    <option value="+33" {{ old('country_code') == '+33' ? 'selected' : '' }}>+33</option>
                                                    <option value="+39" {{ old('country_code') == '+39' ? 'selected' : '' }}>+39</option>
                                                    <option value="+34" {{ old('country_code') == '+34' ? 'selected' : '' }}>+34</option>
                                                </select>
                                                <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" placeholder="Phone">
                                            </div>
                                            @error('country_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
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
                                            <label for="apartment_id">Select Apartment(s)</label>
                                            <select class="form-control @error('apartment_ids') is-invalid @enderror" id="apartment_id" name="apartment_ids[]" multiple>
                                            </select>
                                            <div id="selected-apartments-display" class="mt-2"></div>
                                            <small class="form-text text-muted">Select apartments from the dropdown. Selected apartments will appear below.</small>
                                            @error('apartment_ids')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="parking_id">Assign Parking</label>
                                            <select class="form-control @error('parking_id') is-invalid @enderror" id="parking_id" name="parking_id">
                                                <option value="">Select Parking</option>
                                                @foreach ($parkings as $parking)
                                                    <option value="{{ $parking->id }}" {{ old('parking_id') == $parking->id ? 'selected' : '' }}>
                                                        {{ $parking->parking_code }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('parking_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        // Update file input label when file is selected
        document.getElementById('profile_image').addEventListener('change', function(e) {
            var fileName = e.target.files[0] ? e.target.files[0].name : 'Choose file';
            e.target.nextElementSibling.textContent = fileName;
        });
    </script>

    <script>
        let towers = @json($towers);
        let preselectedFloorId = @json(old('floor_id'));
        let preselectedApartmentIds = @json(array_map('strval', (array) old('apartment_ids', [])));

        let apartmentChoicesInstance = null;
        let apartmentChoiceCache = [];

        function populateFloors(towerId, selectedFloorId = null) {
            const floorDropdown = $('#floor_id');
            floorDropdown.empty().append('<option value="">Select Floor</option>');

            if (!towerId) {
                return;
            }

            const selectedTower = towers.find(tower => tower.id == towerId);
            if (selectedTower && selectedTower.floors) {
                selectedTower.floors.forEach(floor => {
                    const isSelected = selectedFloorId != null && String(selectedFloorId) === String(floor.id) ? 'selected' : '';
                    floorDropdown.append(`<option value="${floor.id}" ${isSelected}>${floor.floor_name}</option>`);
                });
            }
        }

        function buildApartmentChoiceCache() {
            apartmentChoiceCache = [];

            towers.forEach(tower => {
                if (!tower.floors) {
                    return;
                }

                tower.floors.forEach(floor => {
                    if (!floor.apartments) {
                        return;
                    }

                    floor.apartments.forEach(apartment => {
                        apartmentChoiceCache.push({
                            value: String(apartment.id),
                            label: `${apartment.apartment_number}`,
                            customProperties: {
                                towerId: String(tower.id),
                                floorId: String(floor.id),
                            },
                        });
                    });
                });
            });
        }

        let selectedApartments = new Map();

        function updateSelectedApartmentsDisplay() {
            const displayContainer = $('#selected-apartments-display');
            displayContainer.empty();

            if (selectedApartments.size === 0) {
                return;
            }

            selectedApartments.forEach((label, id) => {
                const badge = $(`
                    <span class="badge badge-primary mr-2 mb-2" style="font-size: 0.9rem; padding: 0.5rem 0.75rem; cursor: pointer;" data-apartment-id="${id}">
                        ${label} <i class="fas fa-times ml-1"></i>
                    </span>
                `);
                
                badge.find('i').on('click', function(e) {
                    e.stopPropagation();
                    removeApartment(id);
                });
                
                displayContainer.append(badge);
            });
        }

        function removeApartment(apartmentId) {
            selectedApartments.delete(String(apartmentId));
            updateSelectedApartmentsDisplay();
            syncApartmentChoices();
        }

        function addApartment(apartmentId, label) {
            selectedApartments.set(String(apartmentId), label);
            updateSelectedApartmentsDisplay();
            syncApartmentChoices();
        }

        function syncApartmentChoices(forceValues = null) {
            if (!apartmentChoicesInstance) {
                return;
            }

            const selectedTowerId = $('#tower_id').val();
            const selectedFloorId = $('#floor_id').val();
            const currentSelected = Array.from(selectedApartments.keys());

            // Filter out already selected apartments from available choices
            const filteredChoices = apartmentChoiceCache.filter(choice => {
                const matchesTower = !selectedTowerId || choice.customProperties.towerId === String(selectedTowerId);
                const matchesFloor = !selectedFloorId || choice.customProperties.floorId === String(selectedFloorId);
                const notSelected = !currentSelected.includes(choice.value);
                return matchesTower && matchesFloor && notSelected;
            });

            apartmentChoicesInstance.clearChoices();
            apartmentChoicesInstance.setChoices(filteredChoices, 'value', 'label', true);
        }

        $(document).ready(function() {
            buildApartmentChoiceCache();

            // Initialize preselected apartments
            preselectedApartmentIds.forEach(aptId => {
                const apt = apartmentChoiceCache.find(c => c.value === String(aptId));
                if (apt) {
                    selectedApartments.set(String(aptId), apt.label);
                }
            });
            updateSelectedApartmentsDisplay();

            const apartmentSelectElement = document.getElementById('apartment_id');
            if (apartmentSelectElement) {
                apartmentChoicesInstance = new Choices(apartmentSelectElement, {
                    removeItemButton: false,
                    placeholder: true,
                    placeholderValue: 'Select Apartment(s)',
                    searchPlaceholderValue: 'Search apartment',
                    shouldSort: false,
                });

                // Handle when an apartment is selected - listen to the underlying select change
                $(apartmentSelectElement).on('change', function() {
                    const selectedValues = $(this).val() || [];
                    const newlySelected = selectedValues.filter(val => !selectedApartments.has(String(val)));
                    
                    newlySelected.forEach(aptId => {
                        const apt = apartmentChoiceCache.find(c => c.value === String(aptId));
                        if (apt) {
                            addApartment(apt.value, apt.label);
                        }
                    });
                    
                    // Clear the select and refresh choices
                    $(this).val(null);
                    syncApartmentChoices();
                });
            }

            if ($('#tower_id').val()) {
                populateFloors($('#tower_id').val(), preselectedFloorId);
            }

            syncApartmentChoices();

            $('#tower_id').on('change', function() {
                populateFloors($(this).val());
                $('#floor_id').val('');
                syncApartmentChoices();
            });

            $('#floor_id').on('change', function() {
                syncApartmentChoices();
            });

            // Before form submit, set values for selected apartments
            $('form').on('submit', function(e) {
                // Destroy Choices.js instance to access the native select
                if (apartmentChoicesInstance) {
                    apartmentChoicesInstance.destroy();
                }
                
                // Clear and populate the select with selected apartments
                const apartmentInput = $('#apartment_id');
                apartmentInput.empty();
                
                selectedApartments.forEach((label, id) => {
                    apartmentInput.append(`<option value="${id}" selected>${label}</option>`);
                });
            });
        });
    </script>
@endsection

