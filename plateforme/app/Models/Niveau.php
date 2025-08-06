<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Niveau extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'test_type','niveau', 'expression_ecrite','expression_orale', 'comprehension_ecrite','comprehension_orale'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

