<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanPemeriksaanRadiologi extends Model
{
    use HasFactory;

    protected $table = 'permintaan_pemeriksaan_radiologi';
    protected $primaryKey = 'noorder';
    public $incrementing = false;
    public $timestamps = false;

    public function permintaanRadiologi()
    {
        return $this->belongsTo(PermintaanRadiologi::class, 'noorder', 'noorder');
    }

    public function kdjenis()
    {
        return $this->hasMany(JnsPerawatanRadiologi::class, 'kd_jenis_prw', 'kd_jenis_prw');
    }


}
