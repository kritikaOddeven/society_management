@extends('layouts.app')
@section('pagetitle', 'Amentites')
@section('main-content')
    <style>
        .bootstrap-timepicker-widget table td input {
            width: 54px !important;
        }

        .bootstrap-timepicker-widget a.btn,
        .bootstrap-timepicker-widget input {
            border: none !important;
        }
    </style>
    {{-- Main section --}}
    <section class="section">
        <div class="section-header">
            <h1>Amenities</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ url('/') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Amenities</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">

                <x-alert/>
                    <div class="card">
                        <div class="card-header d-md-flex justify-content-between">
                            <h4>Amenity Lists</h4>
                            <div>
                                <button class="btn btn-primary rounded" data-toggle="modal" data-target="#addAmenitieModal"><i class="fas fa-plus"></i> Add Amenity</button>
                            </div>
                        </div>
                        <div class="card-body">
                            

                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Amenity Name</th>
                                            <th>Open Time</th>
                                            <th>Close Time</th>
                                            <th>Status</th>
                                            <th style="width: 200px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($amenities as $key => $amenity)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $amenity->amenity_name }}</td>
                                                <td>{{ $amenity->open_time }}</td>
                                                <td>{{ $amenity->close_time }}</td>
                                                <td>
                                                    @if ($amenity->status === 'active')
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">

                                                        <button class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#editAmenityModal{{ $amenity->id }}"><i class="fas fa-pencil-alt"></i></button>

                                                        <form action="{{ route('amenities.destroy', $amenity->id) }}" method="POST" style="display: inline;">
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
    @include('amenities.create')
    @foreach ($amenities as $key => $amenity)
        @include('amenities.edit', ['amenity' => $amenity])
    @endforeach
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Flatpickr for Add Modal
            function initializeTimePickers() {
                flatpickr(".timepicker", {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    time_24hr: true,
                    allowInput: true,
                    clickOpens: true,
                    altInput: true,
                    altFormat: "h:i K"
                });

                flatpickr(".timepicker-edit", {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    time_24hr: true,
                    allowInput: true,
                    clickOpens: true,
                    altInput: true,
                    altFormat: "h:i K"
                });
            }

            // Initialize on page load
            initializeTimePickers();

            // Re-initialize when modal is shown (for dynamic content)
            $('#addAmenitieModal').on('shown.bs.modal', function() {
                flatpickr("#addAmenitieModal .timepicker", {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    time_24hr: true,
                    allowInput: true,
                    clickOpens: true,
                    altInput: true,
                    altFormat: "h:i K"
                });
            });

            // Initialize for edit modals
            $('[id^=editAmenityModal]').on('shown.bs.modal', function() {
                var modalId = $(this).attr('id');
                flatpickr('#' + modalId + ' .timepicker-edit', {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    time_24hr: true,
                    allowInput: true,
                    clickOpens: true,
                    altInput: true,
                    altFormat: "h:i K"
                });
            });

            // Make clicking on clock icon open the time picker
            $(document).on('click', '.input-group-append .fa-clock', function() {
                var input = $(this).closest('.input-group').find('input')[0];
                if (input._flatpickr) {
                    input._flatpickr.open();
                }
            });
        });
    </script>
    <style>
        .flatpickr-input {
            background-color: white !important;
            cursor: pointer;
        }

        .flatpickr-input[readonly] {
            background-color: white !important;
            opacity: 1;
        }

        .input-group-append {
            cursor: pointer;
        }

        .flatpickr-time input:hover,
        .flatpickr-time .flatpickr-am-pm:hover,
        .flatpickr-time input:focus,
        .flatpickr-time .flatpickr-am-pm:focus {
            background: #f0f0f0;
        }

        .flatpickr-calendar {
            z-index: 9999 !important;
        }
    </style>
@endsection
