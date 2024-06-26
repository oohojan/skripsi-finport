<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = 'employee';
    protected $fillable = [
        'id_umkm', 'id_user'
    ];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'id_umkm');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
