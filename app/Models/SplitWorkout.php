<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SplitWorkout extends Model
{
    use HasFactory;

    protected $fillable = ['split_id', 'workout_id', 'day'];

    public function split()
    {
        return $this->belongsTo(Split::class);
    }

    public function workout()
    {
        return $this->belongsTo(Workout::class);
    }
}
