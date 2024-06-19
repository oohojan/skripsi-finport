<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    use HasFactory;

    protected $table = 'umkm';

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function pemasok()
    {
        return $this->hasMany(Pemasok::class, 'id_umkm');
    }

    public function pelanggan(){
        return $this->hasMany(Pelanggan::class, 'id_umkm');
    }

    public function transactions()
    {
        return $this->hasMany(Transaksi::class, 'id_umkm');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class, 'id_umkm');
    }
}
