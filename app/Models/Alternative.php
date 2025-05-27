<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alternative extends Model
{
    protected $table = 'alternatives';

    protected $fillable = ['kreativitas', 'keaktifan','teknologi','inovatif','fisik & olahraga','komunikasi & public speaking', 'religiusitas','seni & musik'];

    public $timestamps = true;

    // Tambahan: casting nilai kriteria ke float
    protected $casts = [
        'kreativitas' => 'float',
        'keaktifan' => 'float',
        'teknologi' => 'float',
        'inovatif' => 'float',
        'fisik & olahraga' => 'float',
        'komunikasi & public speaking' => 'float',
        'religiusitas' => 'float',
        'seni & musik' => 'float',
    ];
}
