<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyHistory;

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
        ]);

        $history = CompanyHistory::create([
            'tahun' => $request->tahun,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
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
        ]);

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

        $history->delete();

        return response()->json([
            'message' => 'Company history deleted successfully'
        ]);
    }
}
