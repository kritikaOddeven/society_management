<?php
namespace App\Http\Controllers;

use App\Models\Floor;
use App\Models\Tower;
use App\Exports\FloorExport;
use App\Exports\FloorTemplateExport;
use App\Exports\TowerExport;
use App\Imports\FloorImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class FloorController extends Controller
{
    public function index()
    {
        $floors = Floor::with('tower')->latest()->get();
        $towers = Tower::orderBy('tower_name')->get();
        return view('apartments.floor.index', compact('floors', 'towers'));
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'tower_id'   => 'required|exists:towers,id',
            'floor_name' => 'required|string|min:1|max:50',
        ], [
            'tower_id.required' => 'Tower selection is required',
            'tower_id.exists' => 'Selected tower is invalid',
            'floor_name.required' => 'Floor name is required',
            'floor_name.min' => 'Floor name must be at least 1 character',
            'floor_name.max' => 'Floor name must not exceed 50 characters',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $floor = Floor::create($request->all());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Floor created successfully.',
                'floor' => $floor->load('tower')
            ]);
        }

        return redirect()->route('floors.index')->with('success', 'Floor created successfully.');
    }

    public function update(Request $request, $id)
    {
        $floor = Floor::findOrFail($id);
        
        $validator = \Validator::make($request->all(), [
            'tower_id'   => 'required|exists:towers,id',
            'floor_name' => 'required|string|min:1|max:50',
        ], [
            'tower_id.required' => 'Tower selection is required',
            'tower_id.exists' => 'Selected tower is invalid',
            'floor_name.required' => 'Floor name is required',
            'floor_name.min' => 'Floor name must be at least 1 character',
            'floor_name.max' => 'Floor name must not exceed 50 characters',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $floor->floor_name = $request->floor_name;
        $floor->tower_id = $request->tower_id;
        $floor->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Floor updated successfully.',
                'floor' => $floor->load('tower')
            ]);
        }

        return redirect()->route('floors.index')->with('success', 'Floor updated successfully.');
    }

    public function destroy(Floor $floor)
    {
        $floor->delete();
        return redirect()->route('floors.index')->with('success', 'Floor deleted successfully.');
    }

    /**
     * Show bulk upload page
     */
    public function bulkUpload()
    {
        $towers = Tower::orderBy('tower_name')->get();
        return view('apartments.floor.bulk-upload', compact('towers'));
    }

    /**
     * Export floors to Excel
     */
    public function export()
    {
        return Excel::download(new FloorExport, 'floors_' . date('Y-m-d_His') . '.xlsx');
    }

    /**
     * Download template for floor import
     */
    public function downloadTemplate()
    {
        return Excel::download(new FloorTemplateExport, 'floor_template.xlsx');
    }

    /**
     * Download example file
     */
    public function downloadExample()
    {
        return Excel::download(new FloorExport, 'floor_example.xlsx');
    }

    /**
     * Export towers for reference
     */
    public function downloadTowers()
    {
        return Excel::download(new TowerExport, 'towers_reference_' . date('Y-m-d_His') . '.xlsx');
    }

    /**
     * Import floors from Excel
     */
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls|max:10240',
        ], [
            'file.required' => 'Please select an Excel file to upload.',
            'file.mimes' => 'The file must be an Excel file (.xlsx or .xls).',
            'file.max' => 'The file size must not exceed 10MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $import = new FloorImport();
            Excel::import($import, $request->file('file'));

            $successCount = Floor::count();
            $failures = $import->failures();

            if ($failures->count() > 0) {
                return redirect()->back()
                    ->with('warning', 'Import completed with ' . $failures->count() . ' errors. Some rows were skipped.')
                    ->with('failures', $failures);
            }

            return redirect()->back()
                ->with('success', 'Floors imported successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error importing file: ' . $e->getMessage());
        }
    }
}
