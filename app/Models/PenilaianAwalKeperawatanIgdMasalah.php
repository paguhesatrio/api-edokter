<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianAwalKeperawatanIgdMasalah extends Model
{
    use HasFactory;

    protected $table = 'penilaian_awal_keperawatan_igd_masalah';
    protected $primaryKey = 'no_rawat';
    public $incrementing = false;
    public $timestamps = false;

    public function mastermasalah()
    {
        return $this->belongsTo(MasterMasalahKeperawatanIgd::class, 'kode_masalah', 'kode_masalah');
    }

}
