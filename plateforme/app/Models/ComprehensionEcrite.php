<?php
// app/Models/ExpressionEcrite.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComprehensionEcrite extends Model
{
    protected $table = 'comprehension_ecrite';

    protected $casts = [
        'propositions' => 'array',
    ];

    protected $fillable = [
        'numero', 'situation', 'question', 'propositions', 'reponse'
    ];
}

