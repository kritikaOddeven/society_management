@extends('layouts.app')
@section('pagetitle', 'Tower')
@section('main-content')
    {{-- Main section --}}
    <section class="section">
        <div class="section-header">
            <h1>Tower</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ url('/') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Tower</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-md-flex justify-content-between">
                            <h4>Tower List</h4>
                            <div>
                                <a href="{{ route('towers.bulk-upload') }}" class="btn btn-info rounded mr-2"><i class="fas fa-upload"></i> Bulk Upload</a>
                                <a href="{{ route('towers.export') }}" class="btn btn-success rounded mr-2"><i class="fas fa-download"></i> Export</a>
                                <button class="btn btn-primary rounded" data-toggle="modal" data-target="#addTowerModal"><i class="fas fa-plus"></i> Add Tower</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <x-alert/>

                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Tower Name</th>
                                            <th>No. of Aparment</th>
                                            <th style="width: 200px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($towers as $key => $tower)
                                        @php
                                            $apart_count = App\Models\Apartment::where('tower_id', $tower->id)->count();
                                        @endphp
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $tower->tower_name }}</td>
                                                <td>{{ $apart_count ?? '--' }}</td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <button class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#editTowerModal{{ $tower->id }}"><i class="fas fa-pencil-alt"></i></button>
                                                        <form action="{{ route('towers.destroy', $tower->id) }}" method="POST" style="display: inline;">
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
    @include('apartments.tower.create')
    
    @foreach ($towers as $key => $t)
        @include('apartments.tower.edit', ['tower' => $t])
    @endforeach

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // ✅ ADD TOWER AJAX SUBMISSION
        $('#addTowerForm').on('submit', function(e) {
            e.preventDefault();

            let $form = $(this);
            let $submitBtn = $form.find('button[type="submit"]');
            $submitBtn.prop('disabled', true).text('Saving...');

            $.ajax({
                url: "{{ route('towers.store') }}",
                type: 'POST',
                data: $form.serialize(),
                success: function(res) {
                    $form[0].reset();
                    $form.find('.text-danger').not('.req-star').text('');
                    $('#addTowerModal').modal('hide');

                    showSuccessAlert(res.message || 'Tower added successfully!', () => {
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

        // ✅ EDIT TOWER AJAX SUBMISSION
        $('.editTowerForm').on('submit', function(e) {
            e.preventDefault();

            let $form = $(this);
            let towerId = $form.data('tower-id');
            let $submitBtn = $form.find('button[type="submit"]');
            $submitBtn.prop('disabled', true).text('Saving...');

            $.ajax({
                url: '/towers/' + towerId,
                type: 'POST',
                data: $form.serialize() + '&_method=PUT',
                success: function(res) {
                    $form.find('.text-danger').not('.req-star').text('');
                    $('#editTowerModal' + towerId).modal('hide');

                    showSuccessAlert(res.message || 'Tower updated successfully!', () => {
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

        // Real-time validation for required fields
        $('#addTowerForm input[name="tower_name"], .editTowerForm input[name="tower_name"]').on('blur', function() {
            let $errorSpan = $(this).siblings('.tower_name-error');
            if($(this).val().trim() === '') {
                $errorSpan.text('Tower name is required');
            } else if($(this).val().length < 2) {
                $errorSpan.text('Tower name must be at least 2 characters');
            } else if($(this).val().length > 100) {
                $errorSpan.text('Tower name must not exceed 100 characters');
            } else {
                $errorSpan.text('');
            }
        });

        // Clear errors on input
        $('#addTowerForm input[name="tower_name"], .editTowerForm input[name="tower_name"]').on('input', function() {
            if($(this).val().trim() !== '') {
                $(this).siblings('.tower_name-error').text('');
            }
        });
    });
</script>
@endsection
