<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Souscription extends Model
{
    //
     protected $fillable = [
        'user_id',
        'abonnement_id',
        'date_debut',
        'date_fin',
        'paye'
     ];
     
     public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function abonnement()
    {
        return $this->belongsTo(Abonnement::class);
    }
}
