<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qrcode extends Model
{
    use HasFactory;

    protected $table = 'qrcodes'; // Secara default, Laravel akan mendeteksi ini, tapi bisa dituliskan eksplisit

    protected $fillable = [
        'kode_qr',
        'jenis_material',
        'quantity_in',
        'quantity_out',
        'status',
    ];

    // protected $casts = [
    //     'status_at' => 'datetime',
    // ];

    // Relasi ke tabel ros (standar relasi foreign key: ros.id_qrcode → qrcodes.id)
    public function ros()
    {
        return $this->hasMany(Ros::class, 'id_qrcode', 'id');
    }
}
