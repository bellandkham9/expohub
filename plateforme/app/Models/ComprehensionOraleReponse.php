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
}
