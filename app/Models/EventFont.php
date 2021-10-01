<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventFont extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = [
        'event_id',
        'certificate_type_text_size',
        'certificate_type_text_color',
        'certificate_type_text_font',
        'first_text_size',
        'first_text_color',
        'first_text_font',
        'second_text_size',
        'second_text_color',
        'second_text_font',
        'verifier_text_size',
        'verifier_text_color',
        'verifier_text_font',
    ];

    /**
     * Relationships.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
