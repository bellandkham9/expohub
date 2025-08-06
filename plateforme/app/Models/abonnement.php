<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class abonnement extends Model
{
    //
   protected $fillable = [
        'nom', 'prix', 'duree', 'description'
    ];

    // Un abonnement peut être souscrit par plusieurs utilisateurs

    public function paiements(){
            return $this->hasMany(Paiement::class);
    }
}
