<div class="modal fade" tabindex="-1" role="dialog" id="addFloorModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Floor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('floors.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="tower_id">Tower Name <span class="text-danger">*</span></label>
                                <select class="form-control @error('tower_id') is-invalid @enderror" id="tower_id" name="tower_id" required>
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
                                <label for="floor">Floor <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('floor_name') is-invalid @enderror" id="floor_name" name="floor_name" value="{{ old('floor_name') }}" required>
                                @error('floor_name')
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
