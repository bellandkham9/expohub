<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComprehensionEcriteUserAnswer extends Model
{
    protected $table = 'comprehension_ecrite_user_answers';

    protected $fillable = [
        'user_id',
        'question_id',
        'reponse',
        'test_type',
        'is_correct',
    ];

    /**
     * La question associée.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(ComprehensionEcrite::class, 'question_id');
    }

    /**
     * L'utilisateur qui a répondu.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
