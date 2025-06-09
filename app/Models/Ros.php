<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ros extends Model
{
    protected $table = 'ros';

    protected $fillable = [
        'id_material',
        'nomor_ro',
        'quantity'
    ];

    public function materialData()
    {
    return $this->belongsTo(qrcodes::class, 'id_material', 'jenis_material');
    }
}

