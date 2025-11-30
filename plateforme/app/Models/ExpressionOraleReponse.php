<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpressionOraleReponse extends Model
{
  protected $fillable = [
    'user_id',
    'expression_orale_id',
    'audio_eleve',
    'transcription_eleve',
    'texte_ia',
    'audio_ia',
    'score',
    'test_type',
    'abonnement_id', // ✅ ajoute ici
];


    public function question()
    {
        return $this->belongsTo(ExpressionOrale::class, 'expression_orale_id');
    }
    public function abonnement()
{
    return $this->belongsTo(abonnement::class, 'abonnement_id');
}

// Relation vers la tâche
    public function tache()
    {
        return $this->belongsTo(ExpressionOrale::class, 'expression_orale_id');
    }

}
