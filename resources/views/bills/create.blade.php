<div class="modal fade" tabindex="-1" role="dialog" id="addBillModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Maintenance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('bills.store') }}" method="POST" id="addBillForm">
                @csrf
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="month">Month <span class="text-danger req-star">*</span></label>
                                <select class="form-control" id="month" name="month">
                                    <option value="">Select Month</option>

                                </select>
                                <span class="text-danger month-error"></span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="year">Year <span class="text-danger req-star">*</span></label>
                                <select class="form-control" id="year" name="year">
                                    <option value="">Select Year</option>

                                </select>
                                <span class="text-danger year-error"></span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="payment_due_date">Payment Due Date</label>
                                <input type="text" class="form-control flatpickr @error('payment_due_date') is-invalid @enderror" id="datepicker" name="payment_due_date" value="{{ old('payment_due_date') }}" placeholder="Select payment date">
                                @error('payment_due_date')
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
