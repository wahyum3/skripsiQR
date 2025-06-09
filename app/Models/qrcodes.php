<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class qrcodes extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_qr',
        'jenis_material',
        'quantity_in',
        'quantity_out'
    ];

    public function Ros()
    {
    return $this->hasMany(\App\Models\Ros::class, 'id_material', 'jenis_material');
    }
}