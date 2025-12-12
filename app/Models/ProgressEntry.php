<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgressEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'weight',
        'chest',
        'waist',
        'bicep',
        'thigh',
        'photo_path',
        'notes',
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
        'weight' => 'float',
        'chest' => 'float',
        'waist' => 'float',
        'bicep' => 'float',
        'thigh' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
