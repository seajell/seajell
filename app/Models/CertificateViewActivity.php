<?php

namespace App\Models;

use App\Models\Certificate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CertificateViewActivity extends Model
{
    use HasFactory;
    protected $fillable = [
        'certificate_id',
        'ip_address',
        'http_user_agent'
    ];

    /**
     * Relationships
     */
    public function certificate(){
        return $this->belongsTo(Certificate::class);
    }
}
