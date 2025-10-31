<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hero;
use Illuminate\Support\Facades\Storage;

class HeroController extends Controller
{
    public function index()
    {
        $heroes = Hero::all();
        return response()->json($heroes);
    }

    public function show($id)
    {
        $hero = Hero::find($id);
        if ($hero) {
            return response()->json($hero);
        } else {
            return response()->json(['message' => 'Hero not found'], 404);
        }
    }

    public function update(Request $request)
    {
        // Get the first hero record (singleton pattern)
        $hero = Hero::first();

        if (!$hero) {
            // Create if doesn't exist
            $hero = new Hero();
        }

        $request->validate([
            'location' => 'sometimes|string|max:255',
            'title' => 'sometimes|string',
            'machines' => 'sometimes|integer|min:0',
            'clients' => 'sometimes|integer|min:0',
            'customers' => 'sometimes|integer|min:0',
            'experience_years' => 'sometimes|integer|min:0',
            'trust_years' => 'sometimes|integer|min:0',
            'background' => 'sometimes|image|mimes:jpeg,png,jpg,gif,webp|max:102400', // max 100MB
        ]);

        // Handle background image upload
        if ($request->hasFile('background')) {
            // Delete old image if exists
            if ($hero->background && Storage::disk('public')->exists($hero->background)) {
                Storage::disk('public')->delete($hero->background);
            }

            $backgroundPath = $request->file('background')->store('heroes', 'public');
            $hero->background = $backgroundPath;
        }

        // Update other fields
        $updateData = $request->only([
            'location',
            'title',
            'machines',
            'clients',
            'customers',
            'experience_years',
            'trust_years'
        ]);

        $hero->fill($updateData);
        $hero->save();

        return response()->json([
            'message' => 'Hero updated successfully',
            'data' => $hero
        ]);
    }
}
