<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class paiement extends Model
{
    //

    protected $fillable = [
        'user_id',           // L'utilisateur qui a effectué le paiement
        'abonnement_id',     // L'abonnement concerné par le paiement
        'montant',           // Montant payé
        'methode',           // Méthode de paiement (ex: cinetpay, mobile money, etc.)
        'transaction_id',    // ID unique de la transaction retourné par le service (ex: CinetPay)
        'statut',            // Statut du paiement (ex: en_attente, payé, échoué)
        'devise',            // Devise utilisée (ex: XAF, EUR)
        'details',
        'created_at',         // date de création du paiement
        'updated_at',         // date de mise à jour du paiement
    ];

    // Relation avec l'utilisateur (chaque paiement appartient à un utilisateur)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec un abonnement (optionnelle selon le modèle)
    public function abonnement()
    {
        return $this->belongsTo(Abonnement::class);
    }

}
