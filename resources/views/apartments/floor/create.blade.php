<div class="modal fade" tabindex="-1" role="dialog" id="addFloorModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Floor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('floors.store') }}" method="POST" id="addFloorForm">
                @csrf
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="tower_id">Tower Name <span class="text-danger req-star">*</span></label>
                                <select class="form-control" id="tower_id" name="tower_id">
                                    <option value="">Select Tower</option>
                                    @foreach ($towers as $tower)
                                        <option value="{{ $tower->id }}" {{ old('tower_id') == $tower->id ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('-', ' ', $tower->tower_name)) }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger tower_id-error"></span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="floor">Floor <span class="text-danger req-star">*</span></label>
                                <input type="text" class="form-control" id="floor_name" name="floor_name" value="{{ old('floor_name') }}">
                                <span class="text-danger floor_name-error"></span>
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
