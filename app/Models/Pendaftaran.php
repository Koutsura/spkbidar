<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

   protected $fillable = [
    'user_id',
    'setting_id',
    'organization_1',
    'organization_2',
    'organization_3',
    'alamat',
    'deskripsi',
    'upload_file', // Ganti dari document_path ke file
];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setting()
    {
        return $this->belongsTo(Setting::class);
    }
}
