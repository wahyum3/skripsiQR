<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ros extends Model
{
    use HasFactory;

    protected $table = 'ros';

    protected $fillable = [
        'id_qrcode',   // relasi ke qrcodes.id
        'nomor_ro',
        'quantity'
    ];

    /**
     * Relasi ke QRCode (material)
     */
    public function qrcode()
    {
        return $this->belongsTo(Qrcode::class, 'id_qrcode');
    }
}
