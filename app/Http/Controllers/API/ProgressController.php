<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProgressEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProgressController extends Controller
{
    public function index(Request $request)
    {
        $entries = $request->user()
            ->progressEntries()
            ->orderBy('date', 'desc')
            ->get();

        return response()->json($entries);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'weight' => 'nullable|numeric',
            'chest' => 'nullable|numeric',
            'waist' => 'nullable|numeric',
            'bicep' => 'nullable|numeric',
            'thigh' => 'nullable|numeric',
            'notes' => 'nullable|string',
            'photo' => 'nullable|image|max:5120', // max 5MB
        ]);

        $path = null;
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('progress_photos', 'public');
        }

        $entry = $request->user()->progressEntries()->create(array_merge(
            $data,
            ['photo_path' => $path]
        ));

        return response()->json($entry, 201);
    }

    public function show(Request $request, $id)
    {
        $entry = $request->user()->progressEntries()->findOrFail($id);
        return response()->json($entry);
    }

    public function update(Request $request, $id)
    {
        $entry = $request->user()->progressEntries()->findOrFail($id);

        $data = $request->validate([
            'date' => 'required|date',
            'weight' => 'nullable|numeric',
            'chest' => 'nullable|numeric',
            'waist' => 'nullable|numeric',
            'bicep' => 'nullable|numeric',
            'thigh' => 'nullable|numeric',
            'notes' => 'nullable|string',
            'photo' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('photo')) {
            // delete old photo if exists
            if ($entry->photo_path) {
                Storage::disk('public')->delete($entry->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('progress_photos', 'public');
        }

        $entry->update($data);

        return response()->json($entry);
    }

    public function destroy(Request $request, $id)
    {
        $entry = $request->user()->progressEntries()->findOrFail($id);

        if ($entry->photo_path) {
            Storage::disk('public')->delete($entry->photo_path);
        }

        $entry->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
