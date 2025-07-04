<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'profile_photo', 'nim', 'phone_number', 'jurusan','tahun_angkatan',
        'organization_1', 'organization_2', 'organization_3'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

