<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTriaseIgdPrimer extends Model
{
    protected $table = 'data_triase_igdprimer';
    protected $primaryKey = 'no_rawat';
    public $incrementing = false;
    public $timestamps = false;

    public function petugas()
    {
        return $this->belongsTo(Pegawai::class, 'nik', 'nik');
    }
}
