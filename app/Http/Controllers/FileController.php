<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {
        $files = Storage::files('public/uploads');
        return view('file.index', compact('files'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'files.*' => 'required|file|max:10240', // Example: Max file size of 10MB
        ]);

        foreach ($request->file('files') as $file) {
            $file->store('public/uploads');
        }

        return redirect()->back()->with('success', 'Files uploaded successfully.');
    }

    public function delete($filename)
    {
        Storage::delete('public/uploads/' . $filename);
        return redirect()->back()->with('success', 'File deleted successfully.');
    }

    public function download($filename)
    {
        $file = Storage::path('public/uploads/' . $filename);
        return response()->download($file);
    }
}
