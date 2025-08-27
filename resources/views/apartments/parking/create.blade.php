<div class="modal fade" tabindex="-1" role="dialog" id="addParkingModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Parking</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('parkings.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="apartment_id ">Apartment Number</label>
                                <select class="form-control @error('apartment_id') is-invalid @enderror" id="apartment_id" name="apartment_id">
                                    <option value="">Select Apartment Number</option>
                                    @foreach ($apartments as $apartment)
                                        <option value="{{ $apartment->id }}" {{ old('apartment_id ') == $apartment->id ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('-', ' ', $apartment->apartment_number)) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('apartment_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="parking_code">Parking Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('parking_code') is-invalid @enderror" id="parking_code" name="parking_code" value="{{ old('parking_code') }}" required>
                                @error('parking_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="floor_id">Floor Name</label>
                                <select class="form-control @error('floor_id ') is-invalid @enderror" id="floor_id" name="floor_id" required>
                                    <option value="">Select Apartment Number</option>
                                    @foreach ($floors as $floor)
                                        <option value="{{ $floor->id }}" {{ old('floor_id') == $floor->id ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('-', ' ', $floor->floor_name)) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('floor_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                    </div>

                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save </button>
                </div>
            </form>
        </div>
    </div>
</div>
