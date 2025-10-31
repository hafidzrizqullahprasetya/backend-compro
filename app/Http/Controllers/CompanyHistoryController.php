<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyHistory;
use Illuminate\Support\Facades\Storage;

class CompanyHistoryController extends Controller
{
    public function index()
    {
        $histories = CompanyHistory::orderBy('tahun', 'asc')->get();
        return response()->json($histories);
    }

    public function show($id)
    {
        $history = CompanyHistory::find($id);
        if ($history) {
            return response()->json($history);
        } else {
            return response()->json(['message' => 'Company history not found'], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 10),
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:102400', // 100MB in KB
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('company-histories', 'public');
        }

        $history = CompanyHistory::create([
            'tahun' => $request->tahun,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'image_path' => $imagePath,
        ]);

        return response()->json([
            'message' => 'Company history created successfully',
            'data' => $history
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $history = CompanyHistory::find($id);
        if (!$history) {
            return response()->json(['message' => 'Company history not found'], 404);
        }

        $request->validate([
            'tahun' => 'sometimes|integer|min:1900|max:' . (date('Y') + 10),
            'judul' => 'sometimes|string|max:255',
            'deskripsi' => 'sometimes|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:102400', // 100MB in KB
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($history->image_path) {
                Storage::disk('public')->delete($history->image_path);
            }

            $imagePath = $request->file('image')->store('company-histories', 'public');
            $history->image_path = $imagePath;
        }

        $updateData = $request->only(['tahun', 'judul', 'deskripsi']);
        $history->fill($updateData);
        $history->save();

        return response()->json([
            'message' => 'Company history updated successfully',
            'data' => $history
        ]);
    }

    public function destroy($id)
    {
        $history = CompanyHistory::find($id);
        if (!$history) {
            return response()->json(['message' => 'Company history not found'], 404);
        }

        // Delete image if exists
        if ($history->image_path) {
            Storage::disk('public')->delete($history->image_path);
        }

        $history->delete();

        return response()->json([
            'message' => 'Company history deleted successfully'
        ]);
    }
}
