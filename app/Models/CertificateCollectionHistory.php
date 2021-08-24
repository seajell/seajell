<?php

namespace App\Models;

use App\Models\User;
use App\Models\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CertificateCollectionHistory extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = [
        'requested_by',
        'requested_on',
        'next_available_download',
        'user_id',
        'event_id',
        'certificates_total'
    ];
    /**
     * Relationships
     */
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function event(){
        return $this->belongsTo(Event::class);
    }
}
