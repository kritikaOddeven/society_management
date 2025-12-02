<?php
namespace App\Http\Controllers;

use App\Models\Tower;
use App\Exports\TowerExport;
use App\Exports\TowerTemplateExport;
use App\Imports\TowerImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class TowerController extends Controller
{
    public function index()
    {
        $towers = Tower::latest()->get();
        return view('apartments.tower.index', compact('towers'));
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'tower_name' => 'required|string|min:2|max:100|unique:towers,tower_name',
        ], [
            'tower_name.required' => 'Tower name is required',
            'tower_name.min' => 'Tower name must be at least 2 characters',
            'tower_name.max' => 'Tower name must not exceed 100 characters',
            'tower_name.unique' => 'This tower name already exists',
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

        $tower = Tower::create($request->all());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Tower created successfully.',
                'tower' => $tower
            ]);
        }

        return redirect()->route('towers.index')->with('success', 'Tower created successfully.');
    }

   

    public function update(Request $request, $id)
    {
        $tower = Tower::findOrFail($id);
        
        $validator = \Validator::make($request->all(), [
            'tower_name' => 'required|string|min:2|max:100|unique:towers,tower_name,' . $id,
        ], [
            'tower_name.required' => 'Tower name is required',
            'tower_name.min' => 'Tower name must be at least 2 characters',
            'tower_name.max' => 'Tower name must not exceed 100 characters',
            'tower_name.unique' => 'This tower name already exists',
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

        $tower->tower_name = $request->tower_name;
        $tower->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Tower updated successfully.',
                'tower' => $tower
            ]);
        }

        return redirect()->route('towers.index')->with('success', 'Tower updated successfully.');
    }

    public function destroy(Tower $tower)
    {
        $tower->delete();
        return redirect()->route('towers.index')->with('success', 'Tower deleted successfully.');
    }

    /**
     * Show bulk upload page
     */
    public function bulkUpload()
    {
        return view('apartments.tower.bulk-upload');
    }

    /**
     * Export towers to Excel
     */
    public function export()
    {
        return Excel::download(new TowerExport, 'towers_' . date('Y-m-d_His') . '.xlsx');
    }

    /**
     * Download template for tower import
     */
    public function downloadTemplate()
    {
        return Excel::download(new TowerTemplateExport, 'tower_template.xlsx');
    }

    /**
     * Download example file
     */
    public function downloadExample()
    {
        $towers = Tower::take(5)->get();
        if ($towers->isEmpty()) {
            // Create sample data
            $sampleData = collect([
                (object)['id' => 1, 'tower_name' => 'Tower A', 'status' => true],
                (object)['id' => 2, 'tower_name' => 'Tower B', 'status' => true],
                (object)['id' => 3, 'tower_name' => 'Tower C', 'status' => false],
            ]);
            return Excel::download(new TowerExport, 'tower_example.xlsx');
        }
        return Excel::download(new TowerExport, 'tower_example.xlsx');
    }

    /**
     * Import towers from Excel
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
            $import = new TowerImport();
            Excel::import($import, $request->file('file'));

            $successCount = Tower::count();
            $failures = $import->failures();

            if ($failures->count() > 0) {
                return redirect()->back()
                    ->with('warning', 'Import completed with ' . $failures->count() . ' errors. Some rows were skipped.')
                    ->with('failures', $failures);
            }

            return redirect()->back()
                ->with('success', 'Towers imported successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error importing file: ' . $e->getMessage());
        }
    }
}
