<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventLayout extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = [
        'event_id',
        'logo_first_input_width',
        'logo_first_input_height',
        'logo_first_input_translate',
        'logo_second_input_width',
        'logo_second_input_height',
        'logo_second_input_translate',
        'logo_third_input_width',
        'logo_third_input_height',
        'logo_third_input_translate',
        'details_input_width',
        'details_input_height',
        'details_input_translate',
        'signature_first_input_width',
        'signature_first_input_height',
        'signature_first_input_translate',
        'signature_second_input_width',
        'signature_second_input_height',
        'signature_second_input_translate',
        'signature_third_input_width',
        'signature_third_input_height',
        'signature_third_input_translate',
        'qr_code_input_translate',
    ];

    /**
     * Relationships.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
