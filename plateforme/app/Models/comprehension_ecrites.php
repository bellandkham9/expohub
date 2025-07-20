<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComprehensionEcrite extends Model
{
    protected $fillable = [
        'contexte_texte',
        'contexte_image',
        'question',
        'proposition_1',
        'proposition_2',
        'proposition_3',
        'proposition_4',
        'bonne_reponse',
    ];
}
