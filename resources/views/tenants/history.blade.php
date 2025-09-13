@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tenant History: {{ $tenant->name }}</h5>
                    <a href="{{ route('tenants.index') }}" class="btn btn-secondary btn-sm">Back to Tenants</a>
                </div>

                <div class="card-body">
                    @if($histories->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Date & Time</th>
                                        <th>Action</th>
                                        <th>Apartment</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Rent Amount</th>
                                        <th>Contract Period</th>
                                        <th>Changed Fields</th>
                                        <th>Changed By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($histories as $history)
                                        <tr class="{{ $history->action == 'deleted' ? 'table-danger' : ($history->action == 'created' ? 'table-success' : 'table-info') }}">
                                            <td>{{ $history->created_at->format('Y-m-d H:i:s') }}</td>
                                            <td>
                                                <span class="badge badge-{{ $history->action == 'deleted' ? 'danger' : ($history->action == 'created' ? 'success' : 'info') }}">
                                                    {{ ucfirst($history->action) }}
                                                </span>
                                            </td>
                                            <td>{{ $history->apartment ? $history->apartment->apartment_number : 'N/A' }}</td>
                                            <td>{{ $history->country_code }} {{ $history->phone_number }}</td>
                                            <td>{{ $history->email ?: 'N/A' }}</td>
                                            <td>₹{{ number_format($history->rent_amount, 2) }}</td>
                                            <td>
                                                @if($history->contract_start_date && $history->contract_end_date)
                                                    {{ \Carbon\Carbon::parse($history->contract_start_date)->format('d/m/Y') }} - 
                                                    {{ \Carbon\Carbon::parse($history->contract_end_date)->format('d/m/Y') }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if($history->changed_fields)
                                                    <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#changesModal{{ $history->id }}">
                                                        View Changes
                                                    </button>
                                                    
                                                    <!-- Changes Modal -->
                                                    <div class="modal fade" id="changesModal{{ $history->id }}" tabindex="-1" role="dialog">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Changed Fields</h5>
                                                                    <button type="button" class="close" data-dismiss="modal">
                                                                        <span>&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <table class="table table-sm">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Field</th>
                                                                                <th>Old Value</th>
                                                                                <th>New Value</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach($history->changed_fields as $field => $values)
                                                                                <tr>
                                                                                    <td><strong>{{ ucwords(str_replace('_', ' ', $field)) }}</strong></td>
                                                                                    <td class="text-danger">{{ $values['old'] ?? 'N/A' }}</td>
                                                                                    <td class="text-success">{{ $values['new'] ?? 'N/A' }}</td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $history->changedByUser ? $history->changedByUser->name : 'System' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            No history records found for this tenant.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection