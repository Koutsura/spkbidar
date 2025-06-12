<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $table = 'results';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'recommended_1',
        'recommended_2',
        'recommended_3',
        'pendekatan_1',
        'pendekatan_2',
        'pendekatan_3',
    ];

    // Relasi ke User (asumsi kamu punya model User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
