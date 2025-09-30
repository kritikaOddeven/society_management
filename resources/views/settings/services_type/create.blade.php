<div class="modal fade" tabindex="-1" role="dialog" id="addSTypeModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Service Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('settings.service_types.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="service_type">Service Type <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('service_type') is-invalid @enderror" id="service_type" name="service_type" value="{{ old('service_type') }}">
                                @error('service_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="service_icon">Service Icon </label>
                                <input type="text" class="form-control @error('service_icon') is-invalid @enderror" id="service_icon" name="service_icon" value="{{ old('service_icon') }}">
                                @error('service_icon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            
                            <div class="form-group">
                                <label for="service_status">Service Status</label>
                                <select class="form-control @error('status') is-invalid @enderror" id="service_status" name="status">
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
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
