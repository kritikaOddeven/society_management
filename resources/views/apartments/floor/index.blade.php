@extends('layouts.app')
@section('pagetitle', 'Apartment Floor')
@section('main-content')
    {{-- Main section --}}
    <section class="section">
        <div class="section-header">
            <h1>Apartment Floor</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ url('/') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Floor</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-md-flex justify-content-between">
                            <h4>Floors List</h4>
                            <div>
                                <button class="btn btn-primary rounded" data-toggle="modal" data-target="#addFloorModal"><i class="fas fa-plus"></i> Add Floor</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <x-alert/>

                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Floor</th>
                                            <th>Tower Name</th>
                                            <th style="width: 200px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($floors as $key => $floor)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $floor->floor_name }}</td>
                                                <td>{{ $floor->tower->tower_name ?? '' }}</td>
                                                <td>
                                                    <div class="btn-group" role="group">

                                                        <button class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#editFLoorModal{{ $floor->id }}"><i class="fas fa-pencil-alt"></i></button>

                                                        <form action="{{ route('floors.destroy', $floor->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this tower?')">
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
    @include('apartments.floor.create')
     @foreach ($floors as $key => $floor)
        @include('apartments.floor.edit', ['floor' => $floor])
    @endforeach
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // ✅ ADD FLOOR AJAX SUBMISSION
        $('#addFloorForm').on('submit', function(e) {
            e.preventDefault();

            let $form = $(this);
            let $submitBtn = $form.find('button[type="submit"]');
            $submitBtn.prop('disabled', true).text('Saving...');

            $.ajax({
                url: "{{ route('floors.store') }}",
                type: 'POST',
                data: $form.serialize(),
                success: function(res) {
                    $form[0].reset();
                    $form.find('.text-danger').not('.req-star').text('');
                    $('#addFloorModal').modal('hide');

                    showSuccessAlert(res.message || 'Floor added successfully!', () => {
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

        // ✅ EDIT FLOOR AJAX SUBMISSION
        $('.editFloorForm').on('submit', function(e) {
            e.preventDefault();

            let $form = $(this);
            let floorId = $form.data('floor-id');
            let $submitBtn = $form.find('button[type="submit"]');
            $submitBtn.prop('disabled', true).text('Saving...');

            $.ajax({
                url: '/floors/' + floorId,
                type: 'POST',
                data: $form.serialize() + '&_method=PUT',
                success: function(res) {
                    $form.find('.text-danger').not('.req-star').text('');
                    $('#editFLoorModal' + floorId).modal('hide');

                    showSuccessAlert(res.message || 'Floor updated successfully!', () => {
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
                    $submitBtn.prop('disabled', false).text('Save changes');
                }
            });
        });

        // Real-time validation
        $('#addFloorForm select[name="tower_id"], .editFloorForm select[name="tower_id"]').on('change', function() {
            let $errorSpan = $(this).siblings('.tower_id-error');
            if($(this).val() === '') {
                $errorSpan.text('Tower selection is required');
            } else {
                $errorSpan.text('');
            }
        });

        $('#addFloorForm input[name="floor_name"], .editFloorForm input[name="floor_name"]').on('blur', function() {
            let $errorSpan = $(this).siblings('.floor_name-error');
            if($(this).val().trim() === '') {
                $errorSpan.text('Floor name is required');
            } else if($(this).val().length > 50) {
                $errorSpan.text('Floor name must not exceed 50 characters');
            } else {
                $errorSpan.text('');
            }
        });

        // Clear errors on input
        $('#addFloorForm input[name="floor_name"], .editFloorForm input[name="floor_name"]').on('input', function() {
            if($(this).val().trim() !== '') {
                $(this).siblings('.floor_name-error').text('');
            }
        });
    });
</script>
@endsection
