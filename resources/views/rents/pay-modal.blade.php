<div class="modal fade" tabindex="-1" role="dialog" id="payModal{{ $rent->id }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Payment Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('rents/payment/' . $rent->id) }}" data-role-id="{{ $rent->id }}" method="POST">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="payment_date">Payment Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control flatpickr @error('payment_date') is-invalid @enderror" id="payment_date" name="payment_date" value="{{ $rent->payment_date }}" required>
                                @error('payment_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="payment_image">Upload Payment Prof</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('payment_image') is-invalid @enderror" id="payment_image" name="payment_image" accept="image/*">
                                    <label class="custom-file-label" for="payment_image">Choose file</label>
                                </div>
                                @error('payment_image')
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
