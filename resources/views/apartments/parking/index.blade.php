@extends('layouts.app')
@section('pagetitle', 'Apartment Parking')
@section('main-content')
    {{-- Main section --}}
    <section class="section">
        <div class="section-header">
            <h1>Apartment Parking</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ url('/') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Parking</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-md-flex justify-content-between">
                            <h4>Parkings List</h4>
                            <div>
                                <button class="btn btn-primary rounded" data-toggle="modal" data-target="#addParkingModal"><i class="fas fa-plus"></i> Add Parking</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <x-alert/>

                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Parking Code</th>
                                            <th>Apartment Number</th>
                                            <th>Parking Status</th>
                                            <th style="width: 200px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($parkings as $key => $parking)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $parking->parking_code }}</td>
                                                <td>{{ $parking->apartment->apartment_number ?? '--' }}</td>
                                                <td>
                                                    @if ($parking->status === 'Available')
                                                        <span class="badge bg-success">Available</span>
                                                    @elseif ($parking->status === 'Occupied')
                                                        <span class="badge bg-warning">Alloted</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <div class="btn-group" role="group">

                                                        <button class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#editParkingModal{{ $parking->id }}"><i class="fas fa-pencil-alt"></i></button>

                                                        <form action="{{ route('parkings.destroy', $parking->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this parking?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- End main section --}}
    @include('apartments.parking.create')
    @foreach ($parkings as $key => $p)
        @include('apartments.parking.edit', ['parking' => $p])
    @endforeach
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // ✅ ADD PARKING AJAX SUBMISSION
        $('#addParkingForm').on('submit', function(e) {
            e.preventDefault();

            let $form = $(this);
            let $submitBtn = $form.find('button[type="submit"]');
            $submitBtn.prop('disabled', true).text('Saving...');

            $.ajax({
                url: "{{ route('parkings.store') }}",
                type: 'POST',
                data: $form.serialize(),
                success: function(res) {
                    $form[0].reset();
                    $form.find('.text-danger').not('.req-star').text('');
                    $('#addParkingModal').modal('hide');

                    showSuccessAlert(res.message || 'Parking added successfully!', () => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    if(xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $form.find('.text-danger').not('.req-star').text('');
                        
                        $.each(errors, function(field, messages) {
                            $form.find('.' + field + '-error').text(messages[0]);
                        });
                    } else {
                        showErrorAlert('Something went wrong. Please try again.');
                    }
                    $submitBtn.prop('disabled', false).text('Save');
                }
            });
        });

        // ✅ EDIT PARKING AJAX SUBMISSION
        $('.editParkingForm').on('submit', function(e) {
            e.preventDefault();

            let $form = $(this);
            let parkingId = $form.data('parking-id');
            let $submitBtn = $form.find('button[type="submit"]');
            $submitBtn.prop('disabled', true).text('Saving...');

            $.ajax({
                url: '/parkings/' + parkingId,
                type: 'POST',
                data: $form.serialize() + '&_method=PUT',
                success: function(res) {
                    $form.find('.text-danger').not('.req-star').text('');
                    $('#editParkingModal' + parkingId).modal('hide');

                    showSuccessAlert(res.message || 'Parking updated successfully!', () => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    if(xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $form.find('.text-danger').not('.req-star').text('');
                        
                        $.each(errors, function(field, messages) {
                            $form.find('.' + field + '-error').text(messages[0]);
                        });
                    } else {
                        showErrorAlert('Something went wrong. Please try again.');
                    }
                    $submitBtn.prop('disabled', false).text('Save');
                }
            });
        });

        // Real-time validation
        $('#addParkingForm input[name="parking_code"], .editParkingForm input[name="parking_code"]').on('blur', function() {
            let $errorSpan = $(this).siblings('.parking_code-error');
            if($(this).val().trim() === '') {
                $errorSpan.text('Parking code is required');
            } else if($(this).val().length > 20) {
                $errorSpan.text('Parking code must not exceed 20 characters');
            } else {
                $errorSpan.text('');
            }
        });

        $('#addParkingForm select[name="floor_id"], .editParkingForm select[name="floor_id"]').on('change', function() {
            let $errorSpan = $(this).siblings('.floor_id-error');
            if($(this).val() === '') {
                $errorSpan.text('Floor selection is required');
            } else {
                $errorSpan.text('');
            }
        });

        // Clear errors on input
        $('#addParkingForm input[name="parking_code"], .editParkingForm input[name="parking_code"]').on('input', function() {
            if($(this).val().trim() !== '') {
                $(this).siblings('.parking_code-error').text('');
            }
        });
    });
</script>
@endsection
