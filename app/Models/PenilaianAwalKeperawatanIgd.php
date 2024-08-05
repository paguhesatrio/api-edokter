<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianAwalKeperawatanIgd extends Model
{
    use HasFactory;

    protected $table = 'penilaian_awal_keperawatan_igd';
    protected $primaryKey = 'no_rawat';
    public $incrementing = false;
    public $timestamps = false;

    public function masalah()
    {
        return $this->hasMany(PenilaianAwalKeperawatanIgdMasalah::class, 'no_rawat', 'no_rawat');
    }

}
