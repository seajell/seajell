<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoginActivity extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'ip_address',
        'http_user_agent'
    ];

    /**
     * Relationships
     */
    public function user(){
        return $this->belongsTo(User::class);
    }
}
