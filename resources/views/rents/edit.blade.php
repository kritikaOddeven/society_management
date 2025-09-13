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
                            <h4>Add Rent</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('rents.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                   
                                     <div class="col-md-6">
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

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="floor_id">Select Floor</label>
                                            <select class="form-control @error('floor_id') is-invalid @enderror" id="floor_id" name="floor_id">
                                                <option value="">Select Floor</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="apartment_id">Select Apartment</label>
                                            <select class="form-control @error('apartment_id') is-invalid @enderror" id="apartment_id" name="apartment_id">
                                                <option value="">Select Apartment</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tenant_name">Tenant Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('tenant_name') is-invalid @enderror" id="tenant_name" name="tenant_name" value="{{ old('tenant_name') }}" required>
                                            @error('tenant_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rent_year">Rent For Year </label>
                                            <input type="number" class="form-control @error('rent_year') is-invalid @enderror" id="rent_year" name="rent_year" value="{{ old('rent_year') }}">
                                            @error('rent_year')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rent_month">Rent For Month </label>
                                            <input type="number" class="form-control @error('rent_month') is-invalid @enderror" id="rent_month" name="rent_month" value="{{ old('rent_month') }}">
                                            @error('rent_month')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rent_amount">Rent Amount </label>
                                            <input type="number" class="form-control @error('rent_amount') is-invalid @enderror" id="rent_amount" name="rent_amount" value="{{ old('rent_amount') }}">
                                            @error('rent_amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="payment_status">Payment Status</label>
                                            <select class="form-control @error('payment_status') is-invalid @enderror" id="payment_status" name="payment_status">
                                               
                                                <option value="Unpaid" {{ old('payment_status') == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                                                <option value="Paid" {{ old('payment_status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                                            </select>
                                            @error('payment_status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="form-group d-flex justify-content-end">
                                    <a href="{{ route('tenants.index') }}" class="btn btn-secondary mr-2">Cancel</a>
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

@endsection

