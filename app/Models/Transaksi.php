<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'id_umkm', 'tanggal_transaksi', 'jenis_transaksi', 'keterangan', 'id_pelanggan'
    ];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'id_umkm');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }

    public function scopeTodayTransactions($query, $umkmId = null)
    {
        $user = auth()->user();

        if (!$user) {
            return $query->whereDate('tanggal_transaksi', today());
        }

        $umkmId = $umkmId ?? optional($user->umkm)->id;

        if (!$umkmId) {
            return $query->whereDate('tanggal_transaksi', today());
        }

        return $query->where('id_umkm', $umkmId)
                    ->whereDate('tanggal_transaksi', today());
    }
}
