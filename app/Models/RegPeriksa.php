<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegPeriksa extends Model
{
    use HasFactory;

    protected $table = 'reg_periksa';
    protected $primaryKey = 'no_rawat';
    public $incrementing = false;
    public $timestamps = false;

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'no_rkm_medis', 'no_rkm_medis');
    }
    
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'kd_dokter', 'kd_dokter');
    }

    public function resepObat()
    {
        return $this->hasMany(ResepObat::class, 'no_rawat', 'no_rawat');
    }

    public function detailPemberianObat()
    {
        return $this->hasMany(DetailPemberianObat::class, 'no_rawat', 'no_rawat');
    }

    public function poliklinik()
    {
        return $this->belongsTo(Poliklinik::class, 'kd_poli', 'kd_poli');
    }

    public function gambarRadiologi()
    {
        return $this->hasMany(GambarRadiologi::class, 'no_rawat', 'no_rawat');
    }

    public function hasilRadiologi()
    {
        return $this->belongsTo(hasilRadiologi::class, 'no_rawat', 'no_rawat');
    }

    public function dataTriase()
    {
        return $this->hasMany(DataTriaseIgd::class, 'no_rawat', 'no_rawat');
    }
    
    public function penilaianawalIgd()
    {
        return $this->hasMany(PenilaianAwalKeperawatanIgd::class, 'no_rawat', 'no_rawat');
    }

}
