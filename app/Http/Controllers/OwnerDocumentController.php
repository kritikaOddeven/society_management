<?php

namespace App\Http\Controllers;

use App\Models\OwnerDocument;
use Illuminate\Http\Request;

class OwnerDocumentController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'doc_name' => 'required',
            'doc_file' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $filename = time().'_'.$request->file('doc_file')->getClientOriginalName();
        $request->file('doc_file')->move(public_path('owner_docs'), $filename);

        OwnerDocument::create([
            'owner_id' => $id,
            'doc_name' => $request->doc_name,
            'doc_file' => $filename,
        ]);

        return back()->with('success', 'Document added successfully!');
    }

    public function destroy($id)
    {
        $doc = OwnerDocument::findOrFail($id);

        $filePath = public_path('owner_docs/'.$doc->doc_file);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $doc->delete();

        return back()->with('success', 'Document deleted successfully!');
    }
}