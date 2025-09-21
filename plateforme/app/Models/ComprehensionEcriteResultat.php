<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComprehensionEcriteResultat extends Model
{
    protected $fillable = [
        'user_id',
        'score',
        'total',
        'abonnement_id', // ✅ Ajout du champ abonnement
    ];

    // Relation vers l'utilisateur
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    // Relation vers l'abonnement
    public function abonnement()
{
    return $this->belongsTo(abonnement::class, 'abonnement_id');
}

}
