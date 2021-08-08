<?php

namespace App\Models;

use App\Models\Certificate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'date',
        'location',
        'institute_name',
        'institute_logo',
        'organiser_name',
        'organiser_logo',
        'visibility',
        'verifier_signature',
        'verifier_name',
        'verifier_position',
        'background_image'
    ];

    /**
     * Relationships
     */
    public function certificate(){
        return $this->hasMany(Certificate::class);
    }
}
