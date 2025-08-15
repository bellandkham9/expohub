<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpressionOrale extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'numero',
        'contexte',
        'consigne',
        'consigne_audio', // <-- IMPORTANT
    ];

   public function reponses()
    {
        return $this->hasMany(ExpressionOraleReponse::class);
    }
}
