<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class ExpressionEcrite extends Model
{
    protected $fillable = ['numero_tache', 'contexte_texte', 'consigne'];

    public function reponses()
    {
        return $this->hasMany(ExpressionEcriteReponse::class);
    }
}
