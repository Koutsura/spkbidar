<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alternative extends Model
{
    protected $table = 'alternatives';

    protected $fillable = [
        'name',
        'kreativitas',
        'fisik',
        'musik',
        'teknologi',
        'religiusitas',
    ];

    public $timestamps = true;

    // Tambahan: casting nilai kriteria ke float
    protected $casts = [
        'kreativitas' => 'float',
        'fisik' => 'float',
        'musik' => 'float',
        'teknologi' => 'float',
        'religiusitas' => 'float',
    ];
}
