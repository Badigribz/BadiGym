<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Split;
use App\Models\SplitWorkout;
use Illuminate\Http\Request;

class SplitController extends Controller
{
    // ✅ Get all splits with workouts organized by day
    public function index(Request $request)
    {
        $splits = $request->user()->splits()->with(['workouts.workout'])->get();
        return response()->json($splits);
    }

    // ✅ Create new split plan
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $split = $request->user()->splits()->create($data);
        return response()->json($split, 201);
    }

    // ✅ Assign workout to a split day
    public function assignWorkout(Request $request)
    {
        $data = $request->validate([
            'split_id' => 'required|exists:splits,id',
            'workout_id' => 'required|exists:workouts,id',
            'day' => 'required|string',
        ]);

        $assignment = SplitWorkout::create($data);
        return response()->json($assignment, 201);
    }

    // ✅ Delete a workout from split
    public function removeWorkout($id)
    {
        $item = SplitWorkout::findOrFail($id);
        $item->delete();

        return response()->json(['message' => 'Removed']);
    }
}
