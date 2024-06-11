<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class pemasok extends Model
{
    protected $table = 'pemasok';
    protected $fillable = [
        'id_umkm', 'name', 'no_telepon', 'alamat', 'keterangan'
    ];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'id_umkm');
    }
}
