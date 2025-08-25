<div class="modal fade" tabindex="-1" role="dialog" id="editFloorModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Floor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('floors.store') }}" method="POST">
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="tower_id">Tower Name <span class="text-danger">*</span></label>
                                <select class="form-control @error('tower_id') is-invalid @enderror" id="tower_id" name="tower_id" required>
                                    <option value="">Select Tower</option>
                                    {{-- @foreach ($towers as $tower)
                                        <option value="{{ $tower->name }}" {{ old('tower_id') == $tower->name ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('-', ' ', $tower->tower_name)) }}
                                        </option>
                                    @endforeach --}}
                                </select>
                                @error('tower_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="floor">Floor <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('floor') is-invalid @enderror" id="floor" name="floor" value="{{ old('floor') }}" required>
                                @error('floor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        
                    </div>

                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
