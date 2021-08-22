<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateCollectionDeletionSchedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'folder_name',
        'delete_after'
    ];
}
