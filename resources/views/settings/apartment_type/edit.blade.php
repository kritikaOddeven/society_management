<div class="modal fade" tabindex="-1" role="dialog" id="editATypeModal{{$type->id}}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editt Apartment Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('types/'.$type->id ) }}" data-role-id="{{$type->id}}" method="POST">
                @method('PUT')  
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="apartment_type">Apartment Type <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('apartment_type') is-invalid @enderror" id="apartment_type" name="apartment_type" value="{{ $type->apartment_type}}" required>
                                @error('apartment_type')
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
