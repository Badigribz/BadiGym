<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Workout;
use Illuminate\Http\Request;

class WorkoutController extends Controller
{
    public function index(Request $request)
    {
        $workouts = $request->user()->workouts()->orderBy('date', 'desc')->get();
        return response()->json($workouts);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'exercise' => 'required|string|max:255',
            'weight' => 'required|numeric',
            'reps' => 'nullable|integer',
            'date' => 'required|date',
        ]);

        $workout = $request->user()->workouts()->create($data);
        return response()->json($workout, 201);
    }

    public function show(Request $request, $id)
    {
        $workout = $request->user()->workouts()->findOrFail($id);
        return response()->json($workout);
    }

    public function update(Request $request, $id)
    {
        $workout = $request->user()->workouts()->findOrFail($id);
        $workout->update($request->only(['exercise','weight','reps','date']));
        return response()->json($workout);
    }

    public function destroy(Request $request, $id)
    {
        $workout = $request->user()->workouts()->findOrFail($id);
        $workout->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
