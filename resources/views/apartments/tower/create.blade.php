<div class="modal fade" tabindex="-1" role="dialog" id="addTowerModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Tower</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('towers.store') }}" method="POST" id="addTowerForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="tower_name">Tower Name <span class="text-danger req-star">*</span></label>
                                <input type="text" class="form-control" id="tower_name" name="tower_name" value="{{ old('tower_name') }}">
                                <span class="text-danger tower_name-error"></span>
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
