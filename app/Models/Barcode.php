<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class qrcodes extends Model
{
    use HasFactory;

    protected $fillable = ['kode_qr'];
}
