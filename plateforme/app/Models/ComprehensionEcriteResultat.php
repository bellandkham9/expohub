<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/ExpressionEcriteResultat.php
class ComprehensionEcriteResultat extends Model
{
    protected $fillable = ['user_id', 'score', 'total'];
}
