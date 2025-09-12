<div class="modal fade" tabindex="-1" role="dialog" id="addAmenitieModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Amenity</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('amenities.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="amenity">Amenity Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control  @error('amenity_name') is-invalid @enderror" id="amenity_name" name="amenity_name" value="{{ old('amenity_name') }}" required>
                                @error('amenity_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="open_time">Open Time <span class="text-danger">*</span></label>
                                <input type="time" class="form-control flatpickr flatpickr-input @error('open_time') is-invalid @enderror" data-id="timePicker" id="open_time" name="open_time" value="{{ old('open_time') }}" required>
                                @error('open_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="close_time">Close Time<span class="text-danger">*</span></label>
                                <input type="time" class="form-control @error('close_time') is-invalid @enderror" id="close_time" name="close_time" value="{{ old('close_time') }}" required>
                                @error('close_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="tower_id">Tower Name </label>
                                <select class="form-control @error('tower_id') is-invalid @enderror" id="tower_id" name="tower_id" >
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

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="amenity_status">Amenity Status</label>
                                <select class="form-control @error('status') is-invalid @enderror" id="amenity_status" name="status">
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
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
