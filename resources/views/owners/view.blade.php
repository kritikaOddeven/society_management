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
                                                <p> {{ $owner->apartment->apartment_number ?? '-' }}</p>
                                            </div>

                                            <div class="col-md-4">
                                                <span> Parking Code </span>
                                            </div>
                                            <div class="col-md-8">
                                                <p>{{ $owner->apartment->parking->parking_number ?? '-' }}</p>

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
                                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Tenant</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Family Member</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Owner Documents</a>
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
                                                        {{-- @foreach ($owner as $key => $item) --}}
                                                            <tr>
                                                                {{-- <td>{{ ++$key }}</td> --}}
                                                                <td>{{ $owner->apartment->apartment_number ?? '-' }}</td>
                                                            </tr>
                                                        {{-- @endforeach --}}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                            Sed sed metus vel lacus hendrerit tempus. Sed efficitur velit tortor, ac efficitur est lobortis quis. Nullam lacinia metus erat, sed fermentum justo rutrum ultrices. Proin quis iaculis tellus. Etiam ac vehicula eros, pharetra consectetur dui. Aliquam convallis neque eget tellus efficitur, eget maximus massa imperdiet. Morbi a mattis velit. Donec hendrerit venenatis justo, eget scelerisque tellus pharetra a.
                                        </div>

                                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                            Vestibulum imperdiet odio sed neque ultricies, ut dapibus mi maximus. Proin ligula massa, gravida in lacinia efficitur, hendrerit eget mauris. Pellentesque fermentum, sem interdum molestie finibus, nulla diam varius leo, nec varius lectus elit id dolor. Nam malesuada orci non ornare vulputate. Ut ut sollicitudin magna. Vestibulum eget ligula ut ipsum venenatis ultrices. Proin bibendum bibendum augue ut luctus.
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
