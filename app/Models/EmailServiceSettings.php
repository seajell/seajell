<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailServiceSettings extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = [
        'service_status',
        'service_host',
        'service_port',
        'account_username',
        'account_password',
        'from_email',
        'support_email',
    ];
}
