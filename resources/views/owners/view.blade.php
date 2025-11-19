@extends('layouts.app')
@section('pagetitle', 'Owner Details')
@section('main-content')
    {{-- Main section --}}
    <section class="section">
        <div class="section-header">
            <h1>Owner Details</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('owners.index') }}">Owners</a></div>
                <div class="breadcrumb-item">Owner Details</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card shadow-sm p-3" style="max-width: 600px;">
                                        <div class="row">
                                            <div class="col-md-4">
                                                @if ($owner->profile_image)
                                                    <img src="{{ asset($owner->profile_image) }}" alt="Profile" class="img-thumbnail" width="100" height="120">
                                                @else
                                                    <div class="img-thumbnail bg-primary text-white d-flex align-items-center justify-content-center" style="width: 100px; height: 120px;">
                                                        {{ strtoupper(substr($owner->name ?? $user->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="col-md-8">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <span> Full name </span>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <p> {{ $owner->name }}
                                                            @if ($owner->status)
                                                                <span class="badge badge-success">Active</span>
                                                            @else
                                                                <span class="badge badge-danger">Inactive</span>
                                                            @endif
                                                        </p>

                                                    </div>

                                                    <div class="col-md-4">
                                                        <span> Email id </span>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <p> {{ $owner->email }}</p>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <span> Phone No. </span>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <p>
                                                            @if ($owner->phone_number)
                                                                {{ $owner->country_code }} {{ $owner->phone_number }}
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="card shadow-sm p-3" style="max-width: 600px;">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <span>Apartment Number </span>
                                            </div>
                                            <div class="col-md-8">
                                                <p>   @if($owner->apartments && $owner->apartments->count() > 0)
                                                        @foreach($owner->apartments as $apartment)
                                                            <span>{{ $apartment->apartment_number }}</span>
                                                            @if(!$loop->last),@endif
                                                        @endforeach
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif</p>
                                            </div>

                                            <div class="col-md-4">
                                                <span> Parking Code </span>
                                            </div>
                                            <div class="col-md-8">
                                                @php
                                                    // Collect all parking IDs from all apartments
                                                    $allParkingIds = $owner->apartments
                                                        ->pluck('parking_id') // get all parking_id values
                                                        ->filter() // remove null/empty
                                                        ->map(function ($ids) {
                                                            return json_decode($ids, true); // convert JSON string to array
                                                        })
                                                        ->flatten() // merge all arrays into one
                                                        ->unique() // remove duplicates
                                                        ->values() // reindex
                                                        ->toArray();

                                                    // Fetch parking codes for those IDs
                                                    $parkingCodes = \App\Models\Parking::whereIn('id', $allParkingIds)->pluck('parking_code')->toArray();
                                                @endphp

                                                <p>{{ !empty($parkingCodes) ? implode(', ', $parkingCodes) : '-' }}</p>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">

                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="apartment-tab" data-toggle="tab" href="#apartment" role="tab" aria-controls="apartment" aria-selected="true">Apartment</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="tenat-tab" data-toggle="tab" href="#tenat" role="tab" aria-controls="tenat" aria-selected="false">Tenant</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="family-tab" data-toggle="tab" href="#family" role="tab" aria-controls="family" aria-selected="false">Family Member</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" id="document-tab" data-toggle="tab" href="#document" role="tab" aria-controls="document" aria-selected="false">Owner Documents</a>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="apartment" role="tabpanel" aria-labelledby="apartment-tab">
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="table-1">
                                                    <thead>
                                                        <tr>
                                                            <th>S.No</th>
                                                            <th>Apartment Number</th>
                                                            <th>Apartment Area</th>
                                                            <th>Apartment Type</th>
                                                            <th>Tower Name</th>
                                                            <th>Floor</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($owner->apartments as $key => $apartment)
                                                            <tr>
                                                                <td>{{ ++$key }}</td>
                                                                <td>{{ $apartment->apartment_number ?? '-' }}</td>
                                                                <td>{{ $apartment->apartment_area ?? '-' }}</td>
                                                                <td>{{ $apartment->apartment_type ?? '-' }}</td>
                                                                <td>{{ $apartment->tower->tower_name ?? '-' }}</td>
                                                                <td>{{ $apartment->floor->floor_name ?? '-' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="tenat" role="tabpanel" aria-labelledby="tenat-tab">
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="table-1">
                                                    <thead>
                                                        <tr>
                                                            <th>S.No</th>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Phone</th>
                                                            <th>Status</th>
                                                            <th>Apartment Number</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        {{-- @foreach ($owner->apartments as $key => $apartment)
                                                            <tr>
                                                                <td>{{ ++$key }}</td>
                                                                <td>{{ $apartment->apartment_number ?? '-' }}</td>
                                                                <td>{{ $apartment->apartment_area ?? '-' }}</td>
                                                                <td>{{ $apartment->apartment_type ?? '-' }}</td>
                                                                <td>{{ $apartment->tower->tower_name ?? '-' }}</td>
                                                                <td>{{ $apartment->floor->floor_name ?? '-' }}</td>
                                                            </tr>
                                                        @endforeach --}}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="family" role="tabpanel" aria-labelledby="family-tab">
                                            <div class="card">
                                                <div class="card-body">
                                                    <form action="{{ route('owners.family.store') }}" method="POST">
                                                        @csrf
                                                        <div class="row align-items-end">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="member">Add Family Member <span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control @error('member') is-invalid @enderror" id="member" name="member" value="{{ old('member') }}">
                                                                    @error('member')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-md-2 d-flex justify-content-start">
                                                                <button type="submit" class="btn btn-primary w-50" style="margin-top: 30px;">Add</button>
                                                            </div>
                                                        </div>

                                                    </form>

                                                    <div class="table-responsive">
                                                        <table class="table table-striped" id="table-1">
                                                            <thead>
                                                                <tr>
                                                                    <th>S.No</th>
                                                                    <th>Family Member Name</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                {{-- @foreach ($owner->apartments as $key => $apartment)
                                                            <tr>
                                                                <td>{{ ++$key }}</td>
                                                                <td>{{ $apartment->apartment_number ?? '-' }}</td>
                                                                <td>{{ $apartment->apartment_area ?? '-' }}</td>
                                                            </tr>
                                                        @endforeach --}}
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="document" role="tabpanel" aria-labelledby="document-tab">
                                            <div class="card">
                                                <div class="card-body">
                                                    <form action="{{ route('owners.store') }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="doc_name">Document Name <span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control @error('doc_name') is-invalid @enderror" id="doc_name" name="doc_name" value="{{ old('doc_name') }}">
                                                                    @error('doc_name')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="profile_image">Upload Document</label>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input @error('document') is-invalid @enderror" id="document" name="document" accept="image/*">
                                                                        <label class="custom-file-label" for="document">Choose file</label>
                                                                    </div>
                                                                    @error('document')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="form-group d-flex justify-content-end">
                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                        </div>
                                                    </form>

                                                    <div class="table-responsive">
                                                        <table class="table table-striped" id="table-1">
                                                            <thead>
                                                                <tr>
                                                                    <th>S.No</th>
                                                                    <th>Document Name</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                {{-- @foreach ($owner->apartments as $key => $apartment)
                                                            <tr>
                                                                <td>{{ ++$key }}</td>
                                                                <td>{{ $apartment->apartment_number ?? '-' }}</td>
                                                                <td>{{ $apartment->apartment_area ?? '-' }}</td>
                                                            </tr>
                                                        @endforeach --}}
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
