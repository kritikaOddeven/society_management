<div class="modal fade" tabindex="-1" role="dialog" id="editTowerModal{{$tower->id}}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Tower</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('towers/'.$tower->id ) }}" data-role-id="{{$tower->id}}" method="POST">
                @method('PUT')  
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="tower_name">Tower Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('tower_name') is-invalid @enderror" id="tower_name" name="tower_name" value="{{ $tower->tower_name}}" required>
                                @error('tower_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
