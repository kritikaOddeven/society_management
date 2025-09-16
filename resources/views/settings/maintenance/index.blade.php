@extends('layouts.app')
@section('pagetitle', 'Maintenance')
@section('main-content')
    {{-- Main section --}}
    <section class="section">
        <div class="section-header">
            <h1>Maintenance</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Maintenance</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-md-flex justify-content-between">
                            <h4>Maintenance Settings</h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible show fade">
                                    <div class="alert-body">
                                        <button class="close" data-dismiss="alert">
                                            <span>&times;</span>
                                        </button>
                                        {{ session('success') }}
                                    </div>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible show fade">
                                    <div class="alert-body">
                                        <button class="close" data-dismiss="alert">
                                            <span>&times;</span>
                                        </button>
                                        {{ session('error') }}
                                    </div>
                                </div>
                            @endif



                            <div class="d-flex justify-cantent-between">
                                <ul class="nav nav-pills" id="myTab3" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="fixed_value-tab3" data-toggle="tab" href="#fixed_value3" role="tab" aria-controls="fixed_value" aria-selected="true">Fixed value</a>
                                        {{-- <p>Maintenance cost will be fixed value for all apartments.</p> --}}
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="unit_type-tab3" data-toggle="tab" href="#unit_type3" role="tab" aria-controls="unit_type" aria-selected="false">Unit Type</a>
                                        {{-- <p>Maintenance cost will be calculated based on the unit type.</p> --}}
                                    </li>

                                </ul>
                            </div>
                            <div class="tab-content" id="myTabContent2">
                                <div class="tab-pane fade show active" id="fixed_value3" role="tabpanel" aria-labelledby="fixed_value-tab3">
                                    <form action="{{ route('settings.maintenance.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="fixed_maintenance" value="1">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="table-1">
                                                <thead>
                                                    <tr>
                                                        <th>Apartment Type</th>
                                                        <th>Unit Value (Annually)</th>
                                                        <th>Unit Value (Half yearly)</th>
                                                        <th>Unit Value (Quarterly)</th>
                                                        <th>Unit Value (Monthly)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($apartmentTypes as $index => $type)
                                                    <tr>
                                                        <td>
                                                            {{ $type->apartment_type }}
                                                            <input type="hidden" name="apartment_types[{{ $index }}][apartment_type]" value="{{ $type->apartment_type }}">
                                                        </td>
                                                        <td>
                                                            <input type="number" step="0.01" class="form-control" 
                                                                name="apartment_types[{{ $index }}][annual_value]" 
                                                                value="{{ isset($maintenanceByType[$type->apartment_type]) ? $maintenanceByType[$type->apartment_type]->annual_value : '' }}">
                                                        </td>
                                                        <td>
                                                            <input type="number" step="0.01" class="form-control" 
                                                                name="apartment_types[{{ $index }}][half_yearly_value]" 
                                                                value="{{ isset($maintenanceByType[$type->apartment_type]) ? $maintenanceByType[$type->apartment_type]->half_yearly_value : '' }}">
                                                        </td>
                                                        <td>
                                                            <input type="number" step="0.01" class="form-control" 
                                                                name="apartment_types[{{ $index }}][quarterly_value]" 
                                                                value="{{ isset($maintenanceByType[$type->apartment_type]) ? $maintenanceByType[$type->apartment_type]->quarterly_value : '' }}">
                                                        </td>
                                                        <td>
                                                            <input type="number" step="0.01" class="form-control" 
                                                                name="apartment_types[{{ $index }}][monthly_value]" 
                                                                value="{{ isset($maintenanceByType[$type->apartment_type]) ? $maintenanceByType[$type->apartment_type]->monthly_value : '' }}">
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Save Fixed Values</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>


                                <div class="tab-pane fade" id="unit_type3" role="tabpanel" aria-labelledby="unit_type-tab3">
                                    <form action="{{ route('settings.maintenance.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="unit_name">Unit Name<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control @error('unit_name') is-invalid @enderror" id="unit_name" name="unit_name" value="{{ old('unit_name') }}" required>
                                                        @error('unit_name')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="unit_value">Unit Value (<i class="fas fa-rupee-sign"></i>)<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control @error('unit_value') is-invalid @enderror" id="unit_value" name="unit_value" value="{{ old('unit_value') }}" required>
                                                        @error('unit_value')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- End main section --}}
@endsection
