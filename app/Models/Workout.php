<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    protected $fillable = [
        'exercise',
        'weight',
        'reps',
        'date',
    ];
    //added this for flutter frontend sake
    protected $casts = [
        'weight' => 'float',
        'reps' => 'integer',
        'date' => 'date:Y-m-d',
    ];
    //ends here
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
