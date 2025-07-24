<?php

// app/Models/ExpressionEcrite.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpressionEcrite extends Model
{
    protected $fillable = ['contexte_texte', 'consigne'];
}

