<?php
// Copyright (c) 2021 Muhammad Hanis Irfan bin Mohd Zaid

// This file is part of SeaJell.

// SeaJell is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

// SeaJell is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.

// You should have received a copy of the GNU General Public License
// along with SeaJell.  If not, see <https://www.gnu.org/licenses/>.

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
        'organiser_name',
        'logo_first',
        'logo_second',
        'logo_third',
        'signature_first_name',
        'signature_first_position',
        'signature_first',
        'signature_second_name',
        'signature_second_position',
        'signature_second',
        'signature_third_name',
        'signature_third_position',
        'signature_third',
        'background_image',
        'visibility',
        'border',
        'border_color',
        'text_color'
    ];

    /**
     * Relationships
     */
    public function certificate(){
        return $this->hasMany(Certificate::class);
    }
}
