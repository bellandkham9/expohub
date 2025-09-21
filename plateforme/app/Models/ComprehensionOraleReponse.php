<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComprehensionOraleReponse extends Model
{
    protected $table = 'comprehension_orale_user_answers';

    protected $fillable = [
        'user_id',
        'question_id',
        'reponse',
        'is_correct',
        'test_type',
        'score',          // ✅ nouveau champ
        'abonnement_id',  // ✅ nouveau champ
    ];

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(ComprehensionOrale::class, 'question_id');
    }

    public function abonnement()
    {
        return $this->belongsTo(Abonnement::class, 'abonnement_id');
    }
}
