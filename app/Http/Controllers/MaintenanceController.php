<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\ApartmentType;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $apartmentTypes = ApartmentType::where('status', 1)->get();
        $fixedMaintenances = Maintenance::where('maintenance_type', 'fixed_value')->get();
        $unitMaintenance = Maintenance::where('maintenance_type', 'unit_type')->first();
        
        $maintenanceByType = [];
        foreach ($fixedMaintenances as $maintenance) {
            $maintenanceByType[$maintenance->apartment_type] = $maintenance;
        }
        
        return view('settings.maintenance.index', compact('apartmentTypes', 'maintenanceByType', 'unitMaintenance'));
    }

    public function store(Request $request)
    {
        if ($request->has('fixed_maintenance')) {
            $validatedData = $request->validate([
                'apartment_types' => 'required|array',
                'apartment_types.*.apartment_type' => 'required|string',
                'apartment_types.*.annual_value' => 'nullable|numeric|min:0',
                'apartment_types.*.half_yearly_value' => 'nullable|numeric|min:0',
                'apartment_types.*.quarterly_value' => 'nullable|numeric|min:0',
                'apartment_types.*.monthly_value' => 'nullable|numeric|min:0',
            ]);

            foreach ($validatedData['apartment_types'] as $data) {
                Maintenance::updateOrCreate(
                    [
                        'maintenance_type' => 'fixed_value',
                        'apartment_type' => $data['apartment_type']
                    ],
                    [
                        'annual_value' => $data['annual_value'] ?? 0,
                        'half_yearly_value' => $data['half_yearly_value'] ?? 0,
                        'quarterly_value' => $data['quarterly_value'] ?? 0,
                        'monthly_value' => $data['monthly_value'] ?? 0,
                        'status' => 1
                    ]
                );
            }

            return redirect()->route('settings.maintenance.index')
                ->with('success', 'Fixed maintenance values updated successfully.');
        } else {
            $validatedData = $request->validate([
                'unit_name' => 'required|string|max:255',
                'unit_value' => 'required|numeric|min:0',
            ]);

            Maintenance::updateOrCreate(
                ['maintenance_type' => 'unit_type'],
                [
                    'unit_name' => $validatedData['unit_name'],
                    'unit_value' => $validatedData['unit_value'],
                    'status' => 1
                ]
            );

            return redirect()->route('settings.maintenance.index')
                ->with('success', 'Unit type maintenance updated successfully.');
        }
    }

    public function update(Request $request, Maintenance $maintenance)
    {
        // This method can be removed or kept for future use
        return redirect()->route('settings.maintenance.index');
    }

    public function destroy(Maintenance $maintenance)
    {
        // Prevent deletion of maintenance settings
        return redirect()->route('settings.maintenance.index')
            ->with('error', 'Maintenance settings cannot be deleted, only updated.');
    }
}