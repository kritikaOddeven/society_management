@extends('layouts.app')
@section('pagetitle', 'Tower Bulk Upload')
@section('main-content')
    {{-- Main section --}}
    <section class="section">
        <div class="section-header">
            <h1>Tower Bulk Upload</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ url('/') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('towers.index') }}">Towers</a></div>
                <div class="breadcrumb-item">Bulk Upload</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <x-alert/>

                    {{-- Step 1: Data Preparation (Excel) --}}
                    <div class="card" style="margin-bottom: 20px; border-radius: 8px;">
                        <div class="card-header">
                            <h4>Step 1: Data Preparation (Excel)</h4>
                        </div>
                        <div class="card-body">
                            <ul style="list-style: none; padding-left: 0;">
                                <li style="margin-bottom: 10px;">
                                    <i class="fas fa-check-circle text-primary"></i> Download a skeleton file and fill it.
                                </li>
                                <li style="margin-bottom: 10px;">
                                    <i class="fas fa-check-circle text-primary"></i> Fill the skeleton file with the correct data.
                                </li>
                                <li style="margin-bottom: 10px;">
                                    <i class="fas fa-check-circle text-primary"></i> Upload the filled skeleton file.
                                </li>
                            </ul>
                            <div class="mt-3">
                                <a href="{{ route('towers.download-template') }}" class="btn btn-primary">
                                    <i class="fas fa-download"></i> Download Excel
                                </a>
                               
                            </div>
                        </div>
                    </div>

                    {{-- Upload Tower File --}}
                    <div class="card" style="border-radius: 8px;">
                        <div class="card-header">
                            <h4>Upload Tower File</h4>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-3">Select Excel File</h6>
                            <form action="{{ route('towers.import') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                                @csrf
                                <div class="form-group">
                                    <div class="d-flex align-items-center">
                                        <input type="file" name="file" id="fileInput" class="d-none" accept=".xlsx,.xls" required>
                                        <button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('fileInput').click()">
                                            <i class="fas fa-folder"></i> Browse
                                        </button>
                                        <span class="ml-3" id="fileName">No file chosen</span>
                                    </div>
                                    <small class="form-text text-muted mt-2">
                                        Please upload an Excel file (.xlsx or .xls) with tower data.
                                    </small>
                                    <small class="form-text text-muted d-block">
                                        Note: Tower name is required. Status should be either "active" or "inactive".
                                    </small>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" id="uploadBtn">
                                        <i class="fas fa-upload"></i> Upload Excel  
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- End main section --}}
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // File input change handler
        $('#fileInput').on('change', function() {
            const fileName = $(this).val().split('\\').pop();
            if (fileName) {
                $('#fileName').text(fileName);
            } else {
                $('#fileName').text('No file chosen');
            }
        });

        // Form submission handler
        $('#uploadForm').on('submit', function(e) {
            const fileInput = $('#fileInput')[0];
            if (!fileInput.files || !fileInput.files[0]) {
                e.preventDefault();
                showErrorAlert('Please select a file to upload.');
                return false;
            }

            const $btn = $('#uploadBtn');
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Uploading...');
        });
    });
</script>
@endsection

