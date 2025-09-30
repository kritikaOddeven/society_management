<div class="modal fade" tabindex="-1" role="dialog" id="editParkingModal{{ $parking->id }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Parking</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('parkings/' . $parking->id) }}" data-parking-id="{{ $parking->id }}" method="POST" class="editParkingForm">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="apartment_id">Apartment Number</label>
                                <select class="form-control" id="apartment_id_{{ $parking->id }}" name="apartment_id">
                                    <option value="">Select Apartment Number</option>
                                    @foreach ($apartments as $apartment)
                                        <option value="{{ $apartment->id }}" {{ old('apartment_id', $parking->apartment_id) == $apartment->id ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('-', ' ', $apartment->apartment_number)) }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger apartment_id-error"></span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="parking_code">Parking Code <span class="text-danger req-star">*</span></label>
                                <input type="text" class="form-control" id="parking_code_{{ $parking->id }}" name="parking_code" value="{{ $parking->parking_code }}">
                                <span class="text-danger parking_code-error"></span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="floor_id">Floor Name <span class="text-danger req-star">*</span></label>
                                <select class="form-control" id="floor_id_{{ $parking->id }}" name="floor_id">
                                    <option value="">Select Floor</option>
                                    @foreach ($floors as $floor)
                                        <option value="{{ $floor->id }}" {{ old('floor_id', $parking->floor_id) == $floor->id ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('-', ' ', $floor->floor_name)) }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger floor_id-error"></span>
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
