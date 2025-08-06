<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriqueTest extends Model
{
    protected $fillable = [
        'user_id',
        'test_type',
        'skill',
        'score',
        'niveau',
        'duration',
        'details_route',
        'refaire_route',
        'completed_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

