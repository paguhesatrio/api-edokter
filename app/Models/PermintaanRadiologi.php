<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanRadiologi extends Model
{
    use HasFactory;

    protected $table = 'permintaan_radiologi';
    protected $primaryKey = 'noorder';
    public $incrementing = false;
    public $timestamps = false;

    public function regperiksa()
    {
        return $this->belongsTo(RegPeriksa::class, 'no_rawat', 'no_rawat');
    }

    public function periksaRadiologi()
    {
        return $this->hasMany(PermintaanPemeriksaanRadiologi::class, 'noorder', 'noorder');
    }


}
