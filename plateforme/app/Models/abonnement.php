<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TestType;

class abonnement extends Model
{
    //
     protected $fillable = ['nom_du_plan','examen','prix','duree','description'];

 

    // Un abonnement peut être souscrit par plusieurs utilisateurs

    public function paiements(){
            return $this->hasMany(Paiement::class);
    }

     // S'il y a une clé étrangère test_type_id
    public function testType()
    {
        return $this->belongsTo(TestType::class, 'test_type_id');
    }
}
