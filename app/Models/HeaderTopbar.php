<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderTopbar extends Model
{
    use HasFactory;

    protected $fillable = [
        'left_text',
        'email',
        'phone',
        'opening_hours',
        'facebook',
        'instagram',
        'linkedin',
        'youtube',
        'twitter',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
