<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpressionEcriteReponse extends Model
{
    //
    protected $fillable = [
    'user_id',
    'expression_ecrite_id',
    'reponse',
    'score',
    'commentaire',
    'question', // ici
];

}
