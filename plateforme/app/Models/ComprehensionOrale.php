<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComprehensionOrale extends Model
{
    //
    protected $fillable = [
        'contexte_texte',
        'question_audio',
        'proposition_1',
        'proposition_2',
        'proposition_3',
        'proposition_4',
        'bonne_reponse',
    ];
}
