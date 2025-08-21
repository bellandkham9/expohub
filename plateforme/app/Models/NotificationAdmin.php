<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationAdmin extends Model
{
    protected $fillable = ['user_id', 'title', 'message', 'read'];
    
    public function user() {
        return $this->belongsTo(User::class);
    }
}
