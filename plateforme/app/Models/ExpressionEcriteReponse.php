<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpressionEcriteReponse extends Model
{
    protected $fillable = [
        'user_id',
        'expression_ecrite_id',
        'abonnement_id',
        'prompt',
        'reponse',
        'score',
        'commentaire',
        'test_type',
    ];

    // Ajoutez ce cast pour s'assurer que user_id est bien un integer
    protected $casts = [
        'user_id' => 'integer',
        'expression_ecrite_id' => 'integer',
        'score' => 'integer',
    ];

    public function question()
    {
        return $this->belongsTo(ExpressionEcrite::class, 'expression_ecrite_id');
    }

    public function abonnement()
{
    return $this->belongsTo(abonnement::class, 'abonnement_id');
}

}
