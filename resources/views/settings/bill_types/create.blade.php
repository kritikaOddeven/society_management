<div class="modal fade" tabindex="-1" role="dialog" id="addBTypeModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Bill Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('settings.bill_types.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="bill_type">Bill Type <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('bill_type') is-invalid @enderror" id="bill_type" name="bill_type" value="{{ old('bill_type') }}">
                                @error('bill_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="type_category">Bill Type Category <span class="text-danger">*</span></label>
                                <select class="form-control @error('type_category') is-invalid @enderror" id="type_category" name="type_category">
                                    <option selected disabled>Select Bill Type</option>
                                    <option value="utility_bill" {{ old('type_category') == 'utility_bill' ? 'selected' : '' }}>Utility Bills Type</option>
                                    <option value="common_bill" {{ old('type_category') == 'common_bill' ? 'selected' : '' }}>Common Bills Type</option>
                                </select>
                                @error('type_category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="service_status">Bill Status</label>
                                <select class="form-control @error('status') is-invalid @enderror" id="bill_status" name="status">
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
